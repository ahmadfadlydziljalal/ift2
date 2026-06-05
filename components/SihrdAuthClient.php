<?php

namespace app\components;

use yii\authclient\OAuth2;

class SihrdAuthClient extends OAuth2 {
    public ?string $apiUserInfo = null;

    protected function defaultName(): string {
        return 'sihrd';
    }

    protected function defaultTitle(): string {
        return 'SIHRD';
    }

    protected function initUserAttributes(): array {
        return $this->api(
            $this->apiUserInfo,
            'GET',
            [],
            [
                'Authorization' => 'Bearer ' . $this->accessToken->params['access_token']
            ]
        );
    }
}
