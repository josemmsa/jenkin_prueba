<?php
namespace tests\unit\models;
use app\models\User;
use \Codeception\Specify;
class exampleTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testFindByUsernameGetWrongUsername()
    {
        $user = new User;

        $this->assertNull(User::findByUsername("cualquiera"));
        //expect_not(User::findByUsername('not-admin'));
    }

    public function testFindByUsernameGetExpectUsername()
    {
        $user = new User;
        $this->assertIsObject($user = User::findByUsername("admin")); 
        $this->assertNotNull($user = User::findByUsername("admin")); 
    }

    public function testValidatePasswordGetCorrectPassword()
    {
        $user = User::findByUsername('admin');
        //$user->password = Yii::$app->getSecurity()->generatePasswordHash('admin');
        $this->assertTrue($user->validatePassword('admin'));
    }
    /** @specify */
    private $user;
    use Specify;
    public function testFindIdentityGetCorrectId()
    {
        $this->user = new User;
        $this->specify("wrong id", function (){
            $this->assertNotNull($user = User::findIdentity("100"));
        });
    }
}