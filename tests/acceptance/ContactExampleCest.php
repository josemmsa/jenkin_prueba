<?php

use Codeception\Template\Acceptance;
use yii\helpers\Url;
class ContactExampleCest
{
    public function _before(AcceptanceTester $I)
    {
        $I -> amOnPage(Url::toRoute('/site/contact'));
    }

    // tests
    public function ensureThatContactPageWorks(AcceptanceTester $I)
    {
        $I -> see('Contact','h1');
        $I -> see('If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.');
    }

    public function ensureThatCantSubmitWithoutInformation(AcceptanceTester $I)
    {
        $I-> click('Submit');
        $I -> see('Body cannot be blank.');
        $I -> see('Subject cannot be blank.');
        $I -> see('Email cannot be blank.');
        $I -> see('Name cannot be blank.');
    }
    public function ensureThatCanSubmitFormCorrectly(AcceptanceTester $I)
    {
        $I -> fillField('#contactform-name','admin');
        $I -> click('Submit');
        $I -> dontSee('Name cannot be blank.');
        $I -> fillField('#contactform-email','admin@admin.a');
        $I -> click('Submit');
        $I -> dontSee('Email cannot be blank.');
        $I -> fillField('#contactform-subject','admin');
        $I -> click('Submit');
        $I -> dontSee('Subject cannot be blank.');
        $I -> fillField('#contactform-body','a');
        $I -> click('Submit');
        $I -> dontSee('Body cannot be blank.');
        $I -> fillField('#contactform-verifycode','testme');
        $I -> click('Submit');
        $I -> wait(2);
        $I -> dontSeeElement('Submit');
        $I -> see('Thank you for contacting us. We will respond to you as soon as possible.');
    }

    public function ensureThatEmailFormCantResolveAIncorrectValue(AcceptanceTester $I)
    {
        $I -> fillField('#contactform-email','Incorrect');
        $I -> click('Submit');
        $I -> see('Email is not a valid email address.');
        $I -> seeResponseCodeIs(200);
    }   
}
