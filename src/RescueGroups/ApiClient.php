<?php

namespace AdoptOrNot\Api\RescueGroups;
use AdoptOrNot\Api\Util\CurlClient;
use AdoptOrNot\Api\Util\JsonTools;

/**
 * RescueGroups.org API Client
 * Used to interact with RescueGroups.org HTTP API
 * @package AdoptOrNot\Api\RescueGroups
 */
class ApiClient {

    /**
     * RescueGroups.org API URL
     * @var string
     */
    protected $apiUrl = 'https://api.rescuegroups.org/http/v2.json';

    /**
     * RescueGroups.org API Key
     * @var string
     */
    protected $apiKey;

    /**
     * Constructor
     * @param string $apiKey
     */
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * Get available animals
     * @param array $fields
     * @param array $filters
     * @param int $limit
     * @return mixed
     * @throws \Exception
     */
    public function searchAnimals(array $fields, array $filters = [], $limit = 10) {
        return $this->post([
            'objectType' => 'animals',
            'objectAction' => 'publicSearch',
            'search' => [
                'resultSort' => 'animalID',
                'resultLimit' => $limit,
                'filters' => $filters,
                'fields' => $fields
            ]
        ]);
    }

    /**
     * Send POST request to API
     * @param array $data POST data
     * @return array Response data
     * @throws \Exception On failure
     */
    public function post(array $data = []) {

        // Include API key in request
        $data = json_encode(['apikey' => $this->apiKey] + $data);
		$headers = ['Content-Type: application/json'];

        // POST JSON data to API via cURL
        $curl = new CurlClient($this->apiUrl);
        $response = $curl->post($data, $headers);

        // Return response data as JSON
        return JsonTools::decode($response);

    }

}
