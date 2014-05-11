<?php

namespace ApplicationTest;

use Application\UserManager;
use Application\User;

require_once 'User.php';
require_once 'UserManager.php';
require_once 'Mail.php';

class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateUser()
    {
        $db = new \PDO('mysql:host=localhost;port=3306;dbname=test','root','');
        $config = new \stdClass();
        $config->email = 'test@example.com';
        $config->site_url = 'http://example.com';

        $user = new User(array('firstName' => 'FirtsName', 'lastName' => 'LastName',
            'email' => 'user@example.com', 'password' => 'password123'));

        $email = $this->getMock('\Util\Mail');

        $userManager = new UserManager($email, $db, $config);

        $this->assertTrue($userManager->createUser($user));
        $this->assertEquals(sha1('password123'.$user->salt), $user->password);
        $this->assertTrue($user->userId > 0);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateUserException()
    {
        $db = new \PDO('mysql:host=localhost;port=3306;dbname=test','root','');
        $config = new \stdClass();
        $config->email = 'test@example.com';
        $config->site_url = 'http://example.com';

        $user = new User(array('firstName' => 'FirtsName', 'lastName' => 'LastName',
            'email' => null, 'password' => 'password123'));

        $email = $this->getMock('\Util\Mail');

        $userManager = new UserManager($email, $db, $config);
        $userManager->createUser($user);
    }
}