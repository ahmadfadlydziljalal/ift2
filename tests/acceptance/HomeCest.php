<?php

use Codeception\Step\Argument\PasswordArgument;
use yii\helpers\Url;

class HomeCest
{
    public function _before(AcceptanceTester $I){
        $I->login(
            getenv('SUPER_ADMIN_USERNAME'),
            new PasswordArgument(getenv('SUPER_ADMIN_PASSWORD'))
        );
    }

    public function ensureHomePageCanBeAccessed(AcceptanceTester $I)
    {
        $I->amGoingTo('Mengakses halaman home page. Sebelumnya harus login terlebih dahulu');
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('Dashboard');
    }

}