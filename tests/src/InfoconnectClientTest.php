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
        $id = '826381212';
        $this->client->client = m::mock('GuzzleHttp\Client');
        $response = m::mock('Psr\Http\Message\ResponseInterface');

        $content = $this->generateCompany($id);
        
        $this->client->client->shouldReceive('request')
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getStatusCode')
            ->once()
            ->andReturn('200');
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getContents')
            ->once()
            ->andReturn($content);

        $result = $this->client->getCompany($id);

        $this->assertEquals('JobBrander\Clients\Responses\Company', get_class($result));
        $this->assertEquals($id, $result->Id);
    }

    public function testItCanGetSearchCompanies()
    {
        $parameters = [
            'companyname' => 'Google',
            'resourcetype' => 'Enhanced',
        ];
        
        $this->client->client = m::mock('GuzzleHttp\Client');
        $response = m::mock('Psr\Http\Message\ResponseInterface');

        $content = $this->generateCompanies();

        $this->client->client->shouldReceive('request')
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getStatusCode')
            ->once()
            ->andReturn('200');
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getContents')
            ->once()
            ->andReturn($content);

        $results = $this->client->getSearchCompanies($parameters);

        foreach ($results as $result) {
            $this->assertEquals('JobBrander\Clients\Responses\Company', get_class($result));
        }
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid response format.
     */
    public function testItThrowsExceptionWhenResponseInvalid()
    {
        $id = uniqid();
        $this->client->client = m::mock('GuzzleHttp\Client');
        $response = m::mock('Psr\Http\Message\ResponseInterface');

        $content = '<html></html>';
        
        $this->client->client->shouldReceive('request')
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getStatusCode')
            ->once()
            ->andReturn('200');
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getContents')
            ->once()
            ->andReturn($content);

        $result = $this->client->getCompany($id);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid response format.
     */
    public function testItThrowsExceptionWhenStatusCodeInvalid()
    {
        $id = uniqid();
        $this->client->client = m::mock('GuzzleHttp\Client');
        $response = m::mock('Psr\Http\Message\ResponseInterface');

        $content = '<html></html>';
        
        $this->client->client->shouldReceive('request')
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getStatusCode')
            ->once()
            ->andReturn('401');

        $result = $this->client->getCompany($id);
    }

    public function testItCanGetCompanyByIdWithRealApiKey()
    {
        if (!getenv('APIKEY')) {
            $this->markTestSkipped('APIKEY variable not set.');
        }

        $id = '826381212';

        $result = $this->client->getCompany($id);

        $this->assertEquals('JobBrander\Clients\Responses\Company', get_class($result));
    }
    
    public function testItCanGetSearchCompaniesWithRealApiKey()
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
    
    public function testItCanPostSearchCompaniesWithRealApiKey()
    {
        if (!getenv('APIKEY')) {
            $this->markTestSkipped('APIKEY variable not set.');
        }

        $parameters = [
            'CompanyName' => 'Google',
            'ResourceType' => 'Enhanced',
            'Limit' => '100',
        ];

        $results = $this->client->postSearchCompanies($parameters);

        foreach ($results as $result) {
            $this->assertEquals('JobBrander\Clients\Responses\Company', get_class($result));
        }
    }
    
    private function generateCompanies()
    {
        $content = '[';
        $id = 1;
        $max = rand(1,10);
        while ($id < $max) {
            $content .= $this->generateCompany($id).',';
            $id++;
        }
        $content = rtrim($content, ",");
        $content .= ']';
        return $content;
    }
    
    private function generateCompany($id) 
    {
        $json = '{
          "ETag": "9bdbb214",
          "Id": '.$id.',
          "Links": [
            {
              "Href": "/v1/companies/826381212",
              "Rel": "self"
            },
            {
              "Href": "/v1/companies/637824467",
              "Rel": "parent"
            }
          ],
          "Address": "1020 E 1st St",
          "AddressParsed": {
            "Name": "1st",
            "Number": "1020",
            "PreDirectional": "E",
            "Suffix": "St"
          },
          "City": "Papillion",
          "CompanyName": "Infogroup Inc",
          "FirstName": "Mike",
          "LastName": "Iaccarino",
          "Location": {
            "Latitude": 41.15728,
            "Longitude": -96.02988
          },
          "Phone": "4028364500",
          "PostalCode": "68046",
          "StateProvince": "NE",
          "ParentCompany": "637824467"
        }';

        return $json;
    }
}
