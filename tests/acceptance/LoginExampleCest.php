<?php
use yii\helpers\Url;

class LoginExampleCest
{
    public function _before(AcceptanceTester $I)
    {
        $I -> amOnPage(Url::toRoute('/site/login'));
    }

    // tests
    public function ensureThatLoginFormWorks(AcceptanceTester $I)
    {
        $I -> see('Login','h1');
        $I -> fillField('#loginform-username','admin');
        $I -> fillField('#loginform-password','admin');
        $I -> click('login-button');
        $I -> wait(4);
        $I -> dontSee('Login');
        $I -> see('Logout (admin)');
        $I -> seeCookie('PHPSESSID');
        $I -> seeCookie('_csrf');
        //$I -> seeCookie('_identity');
        //$I -> grabCookie('_identity');
        //$I -> dontSeeCookie('PHPSESSID');
    }

    public function ensureThatLoginFormDoesntWorkWithInvalidUsername(AcceptanceTester $I)
    {
        $I -> see('Login','h1');
        $I -> fillField('#loginform-username','incorrect value');
        $I -> fillField('#loginform-password','admin');
        $I -> click('login-button');
        $I -> wait(2);
        $I -> see('Incorrect username or password.');
        $I -> seeCookie('PHPSESSID');
        $I -> dontSeeCookie('_csrf');
    }

    public function ensureThatLoginFormDoesntWorkWithInvalidPassword(AcceptanceTester $I)
    {
        $I -> see('Login','h1');
        $I -> fillField('#loginform-username','admin');
        $I -> fillField('#loginform-password','incorrect');
        $I -> click('login-button');
        $I -> wait(2);
        $I -> see('Incorrect username or password.');
    }

    public function ensureThatLoginFormDoesntWorkWithInvalidParams(AcceptanceTester $I)
    {
        $I -> see('Login','h1');
        $I -> fillField('#loginform-username','incorrect');
        $I -> fillField('#loginform-password','incorrect');
        $I -> click('login-button');
        $I -> wait(2);
        $I -> see('Incorrect username or password.');
    }
}
