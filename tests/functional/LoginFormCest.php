<?php

use app\models\User;

class LoginFormCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    public function openLoginPage(FunctionalTester $I)
    {
        $I->seeElement('form#login-form');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see('Dashboard');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByUsername(getenv('SUPER_ADMIN_USERNAME')));
        $I->amOnPage('/');
        $I->see('Dashboard');
    }

    public function loginWithEmptyCredentials(FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function loginWithWrongCredentials(FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');
    }

    public function loginSuccessfully(FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => getenv('SUPER_ADMIN_USERNAME'),
            'LoginForm[password]' => getenv('SUPER_ADMIN_PASSWORD'),
        ]);
        $I->see('Dashboard');
        $I->dontSeeElement('form#login-form');
    }
}