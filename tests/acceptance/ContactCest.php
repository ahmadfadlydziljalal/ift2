<?php

use yii\helpers\Url;

class ContactCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/contact'));
    }
    
    public function ensureContactPageCanBeAccessed(AcceptanceTester $I)
    {
        $I->wantTo('Membuka Halaman Contact');
        $I->see('Contact', 'h1');
    }

    public function ensureContactFormCanBeSubmitted(AcceptanceTester $I)
    {
        $I->wantTo('Submit contact form dengan data yang benar');
        $I->amGoingTo('Submit contact form with correct data');

        $I->fillField('#contactform-name', 'tester');
        $I->fillField('#contactform-email', 'tester@example.com');
        $I->fillField('#contactform-subject', 'test subject');
        $I->fillField('#contactform-body', 'test content');
        $I->fillField('#contactform-verifycode', 'testme');
        $I->click('contact-button');

        $I->wait(2); // wait for button to be clicked
        $I->dontSeeElement('#contact-form');
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }
}