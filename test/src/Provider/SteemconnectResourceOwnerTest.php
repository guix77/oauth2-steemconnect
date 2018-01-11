<?php namespace League\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Provider\SteemconnectResourceOwner;
use Mockery as m;

class SteemconnectResourceOwnerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->user = new SteemconnectResourceOwner([
            'user' => 'mock_user',
            '_id' => 'mock_id',
            'name' => 'mock_name',
            'account' => [
              'id' => 'mock_account_id',
              'name' => 'mock_account_name',
              'json_metadata' => '{"profile":{"profile_image":"mock_profile_image","cover_image":"mock_profile_cover","name":"mock_nickname","location":"mock_location","website":"mock_website"}}',
            ],
        ]);
    }

    public function testUser()
    {
        $this->assertEquals('mock_id', $this->user->getId());
        $this->assertEquals('mock_id@fake-steemconnect-email.com', $this->user->getEmail());
        $this->assertEquals('mock_name', $this->user->getName());
        $this->assertEquals('mock_nickname', $this->user->getNickname());
        $this->assertEquals('mock_id', $this->user->toArray()['_id']);
    }
}
