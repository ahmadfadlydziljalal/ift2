<?php

namespace app\storage;

use DateTimeImmutable;
use DateTimeZone;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Throwable;
use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;

/**
 * SihrdAuthenticator authenticates incoming requests carrying a Bearer JWT
 * signed with RS256 and issued by OAuth server
 *
 * It sets Yii::$app->user identity for the duration of the request (non-persistent).
 */
class SihrdAuthenticator extends AuthMethod {
    /** @var string alias to public key file */
    public string $publicKeyPath = '@app/storage/sihrd-pubkey.pem';

    /** @var string expected issuer */
    public string $issuer = '';

    /** @var string|null optional timezone override (e.g. 'Asia/Jakarta'); if null use Yii::$app->timeZone or UTC */
    public ?string $clockTimeZone = null;


    public function init(): void {
        parent::init();
        $this->issuer = getenv('HRD_ISSUER');
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate($user, $request, $response) {
        // orchestrator: small clear steps
        $tokenString = $this->getBearerToken($request);
        $publicKey = $this->getPublicKey();
        $config = $this->buildConfiguration($publicKey);
        $token = $this->parseToken($config, $tokenString);
        [$constraints, $usedClockConstraint] = $this->buildConstraints($config);
        $this->validateToken($config, $token, $constraints);
        $this->checkExpiry($token, $usedClockConstraint);

        return $this->resolveIdentity($token);
    }

    // --- helper methods (clear single-responsibility units) ---

    /**
     * @throws UnauthorizedHttpException
     */
    private function getBearerToken($request): string {
        $authHeader = $request->getHeaders()->get('Authorization');
        if (!$authHeader) {
            return (string)null; // let orchestrator handle null; will be caught below
        }

        if (!preg_match('/^Bearer\s+(.*?)$/i', $authHeader, $m)) {
            throw new UnauthorizedHttpException('Invalid Authorization header format.');
        }

        return $m[1];
    }

    /**
     * @throws UnauthorizedHttpException
     */
    private function getPublicKey(): InMemory {
        $pubFile = Yii::getAlias($this->publicKeyPath);
        if (!is_file($pubFile) || !is_readable($pubFile)) {
            throw new UnauthorizedHttpException('Public key not available.');
        }

        return InMemory::file($pubFile);
    }

    private function buildConfiguration($publicKey): Configuration {
        // Some lcobucci versions require a non-empty private key during Configuration creation.
        // Use placeholder; verification uses public key.
        return Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::plainText('NOT_USED_PRIVATE_KEY_PLACEHOLDER'),
            $publicKey
        );
    }

    /**
     * @throws UnauthorizedHttpException
     */
    private function parseToken(Configuration $config, string $tokenString): Token {
        try {
            return $config->parser()->parse($tokenString);
        } catch (Throwable $e) {
            Yii::error($e->getMessage());
            throw new UnauthorizedHttpException('Invalid token format.');
        }
    }

    /**
     * Build constraints array and indicate if we added a clock-based constraint
     * @return array [constraintsArray, usedClockConstraintBool]
     */
    private function buildConstraints(Configuration $config): array {
        $constraints = [
            new SignedWith($config->signer(), $config->verificationKey()),
            new IssuedBy($this->issuer),
        ];

        $usedClockConstraint = false;
        try {
            $tz = $this->clockTimeZone ?: (isset(Yii::$app) && !empty(Yii::$app->timeZone) ? Yii::$app->timeZone : 'UTC');
            $clock = new SystemClock(new DateTimeZone($tz));
            $constraints[] = new LooseValidAt($clock);
            $usedClockConstraint = true;
        } catch (Throwable $e) {
            // ignore: fallback handled by manual expiry check
            Yii::error($e->getMessage());
        }

        return [$constraints, $usedClockConstraint];
    }

    /**
     * @throws UnauthorizedHttpException
     */
    private function validateToken(Configuration $config, $token, array $constraints): void {
        try {
            $validator = $config->validator();
            if (!$validator->validate($token, ...$constraints)) {
                throw new UnauthorizedHttpException('Token validation failed.');
            }
        } catch (Throwable $e) {
            Yii::error($e->getMessage());
            throw new UnauthorizedHttpException('Token validation error.');
        }
    }

    /**
     * @throws UnauthorizedHttpException
     */
    private function checkExpiry($token, bool $usedClockConstraint): void {
        $claims = $token->claims();
        // clock constraint handles exp/nbf/iat
        if ($usedClockConstraint) return;

        if (!$claims->has('exp')) {
            throw new UnauthorizedHttpException('Token missing expiry (exp) claim.');
        }

        $expClaim = $claims->get('exp');
        $expTs = null;
        if ($expClaim instanceof DateTimeImmutable) {
            $expTs = $expClaim->getTimestamp();
        } elseif (is_int($expClaim) || (is_string($expClaim) && ctype_digit($expClaim))) {
            $expTs = (int)$expClaim;
        } elseif (is_object($expClaim) && method_exists($expClaim, 'getTimestamp')) {
            $expTs = $expClaim->getTimestamp();
        }

        if ($expTs === null) {
            throw new UnauthorizedHttpException('Unrecognized exp claim format.');
        }

        if ($expTs < time()) {
            throw new UnauthorizedHttpException('Token is expired.');
        }
    }

    /**
     * @throws UnauthorizedHttpException
     */
    private function resolveIdentity($token) {
        $claims = $token->claims();
        if (!$claims->has('sub')) {
            throw new UnauthorizedHttpException('Token does not contain subject (sub).');
        }

        $identityClass = Yii::$app->user->identityClass;
        if (!$identityClass || !is_callable([$identityClass, 'findIdentity'])) {
            throw new UnauthorizedHttpException('Application identityClass not configured.');
        }

        $identity = $identityClass::findIdentity($claims->get('sub'));
        if (!$identity) {
            throw new UnauthorizedHttpException('User not found.');
        }

        // login identity for this request only
        Yii::$app->user->login($identity, 0);

        return $identity;
    }

    /**
     * {@inheritdoc}
     */
    public function challenge($response): void {
        $response->getHeaders()->set('WWW-Authenticate', 'Bearer realm="api"');
    }

    /**
     * {@inheritdoc}
     */
    public function handleFailure($response) {
        throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
    }
}

