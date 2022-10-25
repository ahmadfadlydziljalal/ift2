<?php

use yii\helpers\Url;

class AboutCest
{
    protected ?string $title = null;
    public function _before(AcceptanceTester $I)
    {
        $this->title = empty(Yii::$app->settings->get('site.name'))
            ? Yii::$app->name
            : Yii::$app->settings->get('site.name')
        ;
        $I->amOnPage(Url::toRoute('/site/about'));
    }

    public function ensureAboutPageCanBeAccessed(AcceptanceTester $I)
    {
        $I->see($this->title, 'h1');
    }
}