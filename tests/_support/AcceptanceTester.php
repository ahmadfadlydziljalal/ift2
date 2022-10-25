<?php

use Codeception\Actor;
use Codeception\Lib\Friend;
use Codeception\Step\Argument\PasswordArgument;
use yii\helpers\Url;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends Actor
{
    use _generated\AcceptanceTesterActions;

   /**
    * Define custom actions here
    */

    public function login($name, $password)
    {
        $I = $this;

        // if snapshot exists - skipping login
        if ($I->loadSessionSnapshot('login')) {
            return;
        }

        // logging in
        $I->amOnPage(Url::toRoute('/site/login'));

        $I->fillField('input[name="LoginForm[username]"]', $name);
        $I->fillField('input[name="LoginForm[password]"]', $password);

        $I->click('login-button');
        $I->wait(2); // wait for button to be clicked

        $I->see('Dashboard');

        // saving snapshot
        $I->saveSessionSnapshot('login');
    }

}