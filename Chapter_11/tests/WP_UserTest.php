<?php
require_once WORDPRESS_LOCATION. DIRECTORY_SEPARATOR . 'wp-includes' . DIRECTORY_SEPARATOR . 'capabilities.php' ;
require_once WORDPRESS_LOCATION. DIRECTORY_SEPARATOR . 'wp-includes' . DIRECTORY_SEPARATOR . 'cache.php' ;
require_once WORDPRESS_LOCATION. DIRECTORY_SEPARATOR . 'wp-includes' . DIRECTORY_SEPARATOR . 'wp-db.php' ;

class WP_UserTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $GLOBALS['wpdb'] = $this->getMockBuilder('wpdb')->disableOriginalConstructor()->getMock();
        $GLOBALS['wpdb']->prefix = 'xx';

        runkit_method_redefine('WP_User', 'get_data_by', '', 'return (object) array(\'ID\'=>99);', RUNKIT_ACC_PUBLIC | RUNKIT_ACC_STATIC);
        runkit_method_redefine('WP_User', '_init_caps', '', '', (RUNKIT_ACC_PUBLIC));
        runkit_function_redefine('wp_cache_get', '$key, $group', 'return 1;');

    }

    public function tearDown()
    {
        unset($GLOBALS['wpdb']);
    }

    public function testConstructById()
    {
        $wpUser = new WP_User();
        $this->assertNotEquals(1, $wpUser->get('ID'));
        $this->assertEquals(99, $wpUser->get('ID'));
    }
}
