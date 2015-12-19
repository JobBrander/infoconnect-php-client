<?php namespace JobBrander\Clients\Test;

use JobBrander\Clients\InfoconnectClient;
use Mockery as m;

class InfoconnectClientTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->params = [
            'apiKey' => getenv('APIKEY'),
        ];
        $this->client = new InfoconnectClient($this->params);
    }

    public function testItCanGetCompanyById()
    {
        if (!getenv('APIKEY')) {
            $this->markTestSkipped('APIKEY variable not set.');
        }

        $id = '826381212';

        $result = $this->client->getCompany($id);

        $this->assertEquals('JobBrander\Clients\Responses\Company', get_class($result));
    }
    
    public function testItCanGetSearchCompanies()
    {
        if (!getenv('APIKEY')) {
            $this->markTestSkipped('APIKEY variable not set.');
        }

        $parameters = [
            'companyname' => 'Google',
            'resourcetype' => 'Enhanced',
        ];

        $results = $this->client->getSearchCompanies($parameters);

        foreach ($results as $result) {
            $this->assertEquals('JobBrander\Clients\Responses\Company', get_class($result));
        }
    }
}
