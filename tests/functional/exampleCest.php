<?php
use \Codeception\Util\Locator;
class exampleCest 

{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
    }

    public function openAboutPage(FunctionalTester $I)
    {
        $I->wantTo('ensure that home page works');
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see('My Company');
        $I->seeLink('About');
        $I->click('About');
        $I->see('This is the About page.');


    }

    public function linksMenu(FunctionalTester $I)
    {
        $I->wantTo('ensure that home page works');
        $I->amOnPage(Yii::$app->homeUrl);
        $I->expect('the title to be set correctly');
        $I->seeInTitle('My Yii Application');
        $I->expectTo('see all the links of the menu');
        //$url = $I->grabFromCurrentUrl();
        $I->seeLink('Home');
        $I->seeLink('About');
        $I->seeLink('Login');
        $I->seeLink('Contact');
        $I->expectTo('see a self-referencing link to my company homepage');
        $I->seeLink('My Application');
        $I->dontSeeLink('About','site/about');
        $I->dontSeeLink('Login','site/login');
        $I->dontSeeLink('About','site/contact');
        $I->expectTo('see the link of the homepage as selected');
        $I->seeElement('//li[@class="nav-item"]/a[contains(.,"Home")]');
        $I->see('Congratulations',Locator::combine('h1','h2','h3'));
    }

    public function loginpage(FunctionalTester $I){
        $I->wantTo('see if login page works');
        $I->amOnPage(Yii::$app->homeUrl);
        $I->seeLink('Login');
        $I->click('Login');
        $I->see('Username');
        $I->submitForm('#login-form',[
            'LoginForm[username]'=>'admin',
            'LoginForm[password]'=>'admin']);
        $I->see('Logout');
    }
}
