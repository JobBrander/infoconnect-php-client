<?php namespace JobBrander\Clients;

use GuzzleHttp\Client as HttpClient;
use JobBrander\Clients\Responses\Company;
use Psr\Http\Message\ResponseInterface;

class InfoconnectClient
{
    /**
     * API Key
     *
     * @var string
     */
    private $apiKey;
    
    /**
     * Base API url
     *
     * @var string
     */
    private $baseUrl = 'https://api.infoconnect.com/';
    
    /**
     * Create new client
     *
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        $this->setRequiredParameters($parameters);

        $this->setClient(new HttpClient(['base_uri' => $this->baseUrl]));
    }
    
    /**
     * Get a single company by id
     *
     * @param $id
     *
     * @return Company
     */
    public function getCompany($id = null, $parameters = [])
    {
        $response = $this->get('companies/'.$id, $parameters);

        $company = new Company($this->decodeResponse($response));

        return $company;
    }
    
    /**
     * Search companies using simple get method. Full list of parameters: http://developer.infoconnect.com/api/companies-get-search
     *
     * @param $parameters
     *
     * @return array Company objects in array
     */
    public function getSearchCompanies($parameters = [])
    {
        $companies = [];

        $response = $this->get('companies', $parameters);
        $objects = $this->decodeResponse($response);

        foreach($objects as $company) {
            $companies[] = new Company($company);
        }

        return $companies;
    }

    /**
     * Sets http client
     *
     * @param HttpClient $client
     *
     * @return InfoconnectClient
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Sets base parameters required by the API
     *
     * @param array $parameters
     *
     * @return InfoconnectClient
     */
    public function setRequiredParameters($parameters = [])
    {
        if (isset($parameters['apiKey'])) {
            $this->apiKey = $parameters['apiKey'];
        } else {
            throw new \Exception("Required parameter `apiKey` not included.");
        }
        
        if (isset($parameters['baseUrl'])) {
            $this->baseUrl = $parameters['baseUrl'];
        }
        
        return $this;
    }

    /**
     * Ensures response is valid, and decodes json
     *
     * @param ResponseInterface $response
     *
     * @return stdClass
     */
    private function decodeResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() == '200') {
            $object = json_decode($response->getBody()->getContents());
            if ($object !== null) {
                return $object;
            }
        }
        throw new \Exception("Invalid response format.");
    }

    /**
     * Makes a get request to the API via the http client
     *
     * @param string $path
     *
     * @param array $parameters
     *
     * @return InfoconnectClient
     */
    private function get($path = '', $parameters = [])
    {
        $parameters = array_merge(['apikey' => $this->apiKey], $parameters);

        $query = http_build_query($parameters);

        return $this->client->request('GET', 'v1/'.$path.'?'.$query);
    }
}