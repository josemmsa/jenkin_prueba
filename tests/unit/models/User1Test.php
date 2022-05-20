<?php

namespace tests\unit\models;
use Codeception\PHPUnit\TestCase as PHPUnitTestCase;
use app\models\User;
use Error;
use yii\base\Security;
use Yii;
class User1Test extends \Codeception\Test\Unit
{
 
    /*
    public function testValidateReturnsFalseIfParametersAreNotSet()
    {
        $user = new User;
        $this->assertFalse($user->validate(),"New User should not validate");
    }
    public function testValidateReturnsTrueIfParametersAreSet()
    {
        $configurationParams = [
            'username' => 'admin',
            'password' => 'admin',
            'authkey' => 'test100key'
        ];
        $user = new User($configurationParams);
        $this->assertTrue($user->validate(), "User with set parameters should validate");

    }
    

    /**
     * @expectedException yii\base\NotSupportedException
     */

     /*public function testFindIdentityByAccessTokenReturnsTheExpectedObject()
     {
         User::findIdentityByAccessToken('anyAccesToken');
     }
    
     public function testGetIdReturnsTheExpectedId()
     {
         $expectedId =2;
         $user = new User();
         $user->id = 2;
         $this->assertEquals($expectedId, $user->getId());
     }

     public function testFindIdentityReturnsTheExpectedObject()
     {
         $expectedAttrs = [
             'username' => 'someone',
             'password' => 'else',
             'authkey' => 'random string'
         ];
         $user = new User($expectedAttrs);
         $this->assertTrue($user->save());

         $expectedAttrs['id'] = $user->id;
         $user = User::findIdentity($expectedAttrs['id']);

         $this->assertNotNull($user);
         $this->assertInstanceOf('yii\web\IdentityInterface',$user);
         $this->assertEquals($expectedAttrs['username'],$user->username);
         $this->assertEquals($expectedAttrs['password'],$user->password);
         $this->assertEquals($expectedAttrs['authkey'],$user->authkey);
     }
    */
     /**
      * @dataProvider nonExistingIdsDataProvider
      */

      public function testFindIdentityReturnsNullIfUserIsNotFound($invalidId)
      {
          $this->assertNull(User::findIdentity($invalidId));          
      }

      public function nonExistingIdsDataProvider(){
          return [[-1],[null],[30]];
      }

      public function testFindIdentityGetExpectValue()
      {
        $user = new User();
        $this->assertNotNull(User::findIdentity('100'));
      }

      public function testFindIdentityGetUnexpectedValueReturnNull()
      {
          $this->assertNull(User::findByUsername('10'));
      }

      public function testFindIdentityGetNumericValueReturnNull()
      {
          $this->assertNull(User::findByUsername(100));
      }

      public function testFindIdentityByAccessTokenReturnNullIfGetInvalidToken()
      {
        $this->assertNull(User::findIdentityByAccessToken("a"));
      }

      public function testFindIdentityByAccessTokenReturnUserIfGetValidToken()
      {
          $user = new User();
          $this->assertIsObject($user = User::findIdentityByAccessToken('100-token'));
          $this->assertEquals('admin',$user->username);
      }

      public function testFindByUsernameReturnsUserIfGetValidUsername()
      {
          $user = new User();
          $this->assertIsObject($user = User::findByUsername('admin'));
      }

      public function testFindByUsernameReturnsNullIfGetInvalidUsername()
      {
          $user = new User();
          $this->assertIsObject($user);
          $this->assertNull($user = User::findByUsername('a'));
      }
      public function testGetIdGetTheCorrectId()
      {
          $user = User::findByUsername('admin');
          $this->assertEquals($user->id,$user->getId());
      }
      /**
       *  @expectedException Error
       *  */
      public function testGetIdFromANullUser()
      {
          $user = User::findByUsername('noexiste');
         $user->getId();
      }

      public function testGetAuthKeyGetTheCorrectAuthKey()
      {
          
          $user = User::findByUsername('admin');
          $this->assertIsObject($user);
          $this->assertEquals($user->authKey,$user->getAuthKey());

      }
      /**
       *  @expectedException Error
       *  */
      public function testGetAuthKeyFromANullUser()
      {
          $user = User::findByUsername('noexiste');
          $user->getAuthKey();
      }

      public function testValidateAuthKeyGetATrueValue()
      {
          $user = User::findByUsername('admin');
          $this->assertFalse($user->validateAuthKey('noesigual'));
      }
      public function testValidateAuthKeyGetAFalseValue()
      {
          $user = User::findByUsername('admin');
          $this->assertTrue($user->validateAuthKey('test100key'));
      }

      /**
       *  @expectedException Error
       *  */

      public function testValidateAuthKeyFromANullUser()
      {
          $user = User::findByUsername('noexiste');
          $user->validateAuthKey('test100key');

      }
      public function testValidateAuthKeyGetANullValue()
      {
          $user = User::findByUsername('admin');
          $this->assertFalse($user->validateAuthKey(null));
      }

      public function testValidatePasswordReturnsAFalseValue()
      {
          $user = User::findByUsername('admin');
          $this->assertFalse($user->validatePassword('1234'));
      }
      public function testValidatePasswordReturnsATrueValue()
      {
          $user = User::findByUsername('admin');
          $this->assertTrue($user->validatePassword('admin'));
      }
      public function testValidatePasswordGetANullValue(){
          $user = User::findByUsername('admin');
          $this->assertFalse($user->validatePassword(null));
      }
      public function testValidateReturnsATrueValue()
      {
          $user = User::findByUsername('admin');
          $this->assertTrue($user->validate('admin','test100key'));
      }

      public function testValidateReturnsAFalseValue()
      {
          $user = User::findByUsername('admin');
          $this->assertFalse($user->validate('','test100key'));
          $this->assertFalse($user->validate('admin',''));
          $this->assertFalse($user->validate('',''));
      }
      /*
      public function testValidatePasswordReturnsTrueIfPasswordIsCorrect()
      {
          $expectedPassword = 'admin';
          $user = new User();
          $user->password = Yii::$app->getSecurity()->generatePasswordHash($expectedPassword);
          $this->assertTrue($user->validatePassword($expectedPassword));

      }
      */
      /**
       * Undocumented function
       *
       * @param string $expectedPassword
       * @param mixed $wrongPassword
       * 
       */
      private function _mockYiiSecurity($expectedPassword, $wrongPassword = false)
      {
        $security = $this->getMockBuilder('yii\base\Security');
      }
      public function testSetPasswordCallsGeneratePasswordHash(){
          $clearTextPassword = 'some password';

          $security = $this->getMockBuilder(
              'yii\base\Security')
                    ->getMock();
          $security->expects($this->once())
            ->method('generatePasswordHash')
            ->with($this->equalTo($clearTextPassword));
        Yii::$app->set('security',$security);
        $user = new User();
        $this->$user->setPassword($clearTextPassword);
      }




}