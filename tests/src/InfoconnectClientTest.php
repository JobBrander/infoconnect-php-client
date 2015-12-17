<?php namespace JobBrander\Clients\Test;

use JobBrander\Clients\InfoconnectClient;
use Mockery as m;

class InfoconnectClientTest extends \PHPUnit_Framework_TestCase
{
    // Test Client
    public function testItCanInstantiateClient()
    {
        $params = [
            'apiKey' => uniqid(),
            'baseUrl' => 'https://api.infoconnect.com/v1/',
        ];
        $client = new InfoconnectClient($params);
    }
}
