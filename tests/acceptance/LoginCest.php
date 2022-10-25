<?php

use Codeception\Step\Argument\PasswordArgument;
use yii\helpers\Url;

class LoginCest
{
    protected ?string $title = null;
    public function _before(AcceptanceTester $I)
    {
        $this->title = empty(Yii::$app->settings->get('site.name'))
            ? Yii::$app->name
            : Yii::$app->settings->get('site.name')
        ;
        $I->amOnPage(Url::toRoute('/site/login'));
    }

    public function ensureLoginPageCanBeAccessed(AcceptanceTester $I)
    {
        $I->see($this->title, 'h1');
    }

    /**
     * @param AcceptanceTester $I
     * @return void
     */
    public function ensureValidationForBlankInput(AcceptanceTester $I)
    {
        $I->wantTo('Mencoba login dengan inputan form yang kosong');
        $I->amGoingTo('try to login with wrong credentials');

        $I->fillField('input[name="LoginForm[username]"]', null);
        $I->fillField('input[name="LoginForm[password]"]', null);
        $I->click('login-button');
        $I->wait(2); // wait for button to be clicked

        $I->expectTo('Still in login page');
        $I->see($this->title, 'h1');

        $I->seeElement('input[name="LoginForm[username]"]', [
            'class' => 'form-control is-invalid'
        ]);
        $I->seeElement('input[name="LoginForm[password]"]', [
            'class' => 'form-control is-invalid'
        ]);
    }

    /**
     * @param AcceptanceTester $I
     * @return void
     */
    public function ensureValidationForWrongAccountCredential(AcceptanceTester $I)
    {
        $I->wantTo('Mencoba login dengan account yang tidak valid...!');
        $I->amGoingTo('try to login with wrong credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'non-valid-admin');
        $I->fillField('input[name="LoginForm[password]"]', 'non-valid-password');
        $I->click('login-button');
        $I->wait(2); // wait for button to be clicked

        $I->expectTo('Still in login page');
        $I->see($this->title, 'h1');
        $I->seeElement('input[name="LoginForm[password]"]', [
            'class' => 'form-control is-invalid'
        ]);
    }

    /**
     * @param AcceptanceTester $I
     * @return void
     */
    public function ensureThatLoginFormWorks(AcceptanceTester $I)
    {
        $I->wantTo('Mencoba login dengan account yang valid...!');
        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', getenv('SUPER_ADMIN_USERNAME'));
        $I->fillField('input[name="LoginForm[password]"]', new PasswordArgument(getenv('SUPER_ADMIN_PASSWORD')));
        $I->click('login-button');
        $I->wait(2); // wait for button to be clicked

        $I->expectTo('see user info');
        $I->see('Dashboard');
    }
}