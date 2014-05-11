<?php
require_once WORDPRESS_LOCATION. DIRECTORY_SEPARATOR . 'wp-includes' . DIRECTORY_SEPARATOR . 'capabilities.php' ;
require_once WORDPRESS_LOCATION. DIRECTORY_SEPARATOR . 'wp-includes' . DIRECTORY_SEPARATOR . 'pluggable.php' ;

class WordPressTest extends PHPUnit_Framework_TestCase
{
    public function testIs_user_logged_in()
    {
        $user = $this->getMockBuilder('WP_User')
            ->setMethods(array('exists'))
            ->disableOriginalConstructor()
            ->getMock();

        $user->expects($this->any())
            ->method('exists')
            ->will($this->returnValue(true));

        Patchwork\replace('wp_get_current_user',
            function () use ($user) {
                return $user;
            });

        $this->assertTrue(is_user_logged_in());
    }

    public function testWp_get_current_user()
    {
        $user = $this->getMockBuilder('WP_User')
            ->setMethods(array('exists'))
            ->disableOriginalConstructor()
            ->getMock();

        Patchwork\replace('get_currentuserinfo', function () {});

        $GLOBALS['current_user'] = $user;
        $this->assertEquals($user, wp_get_current_user());
    }

    public function tearDown()
    {
        unset($GLOBALS['current_user']);
    }
}
