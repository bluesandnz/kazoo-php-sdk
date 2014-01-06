<?php

namespace Kazoo\Tests\Functional;

use Kazoo\Api\Data\Entity\User;
use Kazoo\Exception\ApiLimitExceedException;
use Kazoo\Exception\RuntimeException;

/**
 * @group functional
 */
class UserTest extends \PHPUnit_Framework_TestCase {

    protected $client;

    public function setUp() {

        $username = 'bwann';
        $password = '12341234';
        $sipRealm = 'sip.benwann.com';
        $options = array();
        $options["base_url"] = "http://192.168.0.111:8000";
        $options["log_type"] = "file";
        $options["log_file"] = "/var/log/kazoo-sdk.log";

        // You have to specify authentication here to run full suite

        try {
            $this->client = new \Kazoo\Client($username, $password, $sipRealm, $options);
        } catch (ApiLimitExceedException $e) {
            $this->markTestSkipped('API limit reached. Skipping to prevent unnecessary failure.');
        } catch (RuntimeException $e) {
            if ('Requires authentication' == $e->getMessage()) {
                $this->markTestSkipped('Test requires authentication. Skipping to prevent unnecessary failure.');
            }
        }
    }

    public function testRetrieveAll() {
        $users = $this->client->accounts()->users()->retrieve();
        $this->assertGreaterThan(0, count($users));
    }

//    /**
//     * @test
//     */
//    public function testEmptyShell() {
//        try {
//            $user = $this->client->accounts()->users()->new();
//            $this->assertInstanceOf("Kazoo\\Api\\Data\\Entity\\User", $user);
//        } catch (Exception $e) {
//            $this->markTestSkipped($e->getMessage());
//        }
//    }
//
//    /**
//     * @test
//     */
//    public function shouldCreateUser() {
//        $user = $this->client->accounts()->users()->new();
//        $num = substr(number_format(time() * rand(), 0, '', ''), 0, 4);
//        $device->name = "Test Device #" . $num;
//        $device->sip->password = substr(number_format(time() * rand(), 0, '', ''), 0, 10);
//        $device->sip->username = "testdevice" . $num;
//        $this->client->accounts()->devices()->create($device);
//
//        echo $device . "\n";
//        die();
//
//        $this->assertInstanceOf("Kazoo\\Api\\Data\\Entity\\Device", $this->test_device);
//        $this->assertObjectHasAttribute('id', $this->test_device);
//
//        return $this->test_device->id;
//    }
//
//    /**
//     * @test
//     * @depends shouldCreateDevice
//     */
//    public function shouldRetriveDevice($device_id) {
//        $device = $this->client->accounts()->devices()->retrieve($device_id);
//        $this->assertInstanceOf("Kazoo\\Api\\Data\\Entity\\Device", $device);
//        $this->assertObjectHasAttribute('id', $this->test_device);
//    }
//
//    /**
//     * @test
//     * @depends shouldCreateDevice
//     */
//    public function testUpdateOne($device_id) {
//        $device = $this->client->accounts()->devices()->retrieve($this->test_device->id);
//        $device->name = "Updated Name";
//        $device->save();
//
//        $this->assertInstanceOf("Kazoo\\Api\\Data\\Entity\\Device", $device);
//        $this->assertObjectHasAttribute('id', $device);
//    }
//
//    /**
//     * @test
//     * @depends shouldCreateDevice
//     */
//    public function testDeleteOne() {
//        $this->test_device = $this->client->accounts()->devices()->retrieve($this->test_device->id);
//        $this->test_device->delete();
//        $this->assertTrue(true);    //TODO, figure out assertion for successful deletion
//    }

}