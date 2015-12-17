<?php namespace JobBrander\Clients;

use GuzzleHttp\Client as HttpClient;

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
    private $baseUrl;
    
    /**
     * Resource Type
     *
     * @var string
     */
    private $resourceType;
    
    /**
     * Create new client
     *
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        array_walk($parameters, function ($value, $key) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        });

        $this->setClient(new HttpClient);
    }
    
    /**
     * Get a single company by id
     *
     * @param $id
     *
     * @return Company
     */
    public function getCompany($id = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Sets http client
     *
     * @param HttpClient $client
     *
     * @return  AbstractClient
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;

        return $this;
    }
}