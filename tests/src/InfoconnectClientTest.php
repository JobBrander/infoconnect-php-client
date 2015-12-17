<?php namespace JobBrander\Clients\Test;

use JobBrander\Clients\InfoconnectClient;
use Mockery as m;

class InfoconnectClientTest extends \PHPUnit_Framework_TestCase
{
    // Test Client
    public function testItCanInstantiateClient()
    {
        $params = [];
        $client = new InfoconnectClient($params);
    }
}
