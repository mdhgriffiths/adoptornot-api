<?php

namespace AdoptOrNot\Api\RescueGroups;

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
    public function __construct ($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * Send POST request to API
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function post (array $data = []) {

        // Include API key in request
        $data = array_merge([
            'apikey' => $this->apiKey
        ], $data);

        // POST JSON data to API
        $jsonData = json_encode($data);
        $response = $this->postJsonData($jsonData);
        $jsonResponse = json_decode($response, true);

        // TODO: handle JSON errors
        if ($jsonError = $this->getJsonError()) {
            throw new \Exception(sprintf(
                'Failed to parse JSON data [%s]',
                $jsonError
            ));
        }

        // JSON response data
        return $jsonResponse;

    }

    /**
     * Send POST request and return response data
     * @param array $data
     * @return mixed
     * @throws \Exception If cURL failed
     */
    protected function postJsonData (array $data) {

        // Request headers (send data as JSON0
        $headers = ['Content-Type: application/json'];

        // cURL instance
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // DEBUG !!!
        curl_setopt($ch, CURLOPT_POST, 1);

        // Execute cURL request
        $result = curl_exec($ch);

        // TODO: handle errors
        if (curl_errno($ch)) {
            throw new \Exception(sprintf(
                'Failed to execute cURL request [%s]',
                curl_error($ch)
            ));
        }

        // Response data
        curl_close($ch);
        return $result;

    }

    /**
     * Get message for last JSON error
     * @return string|false
     */
    protected function getJsonError() {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return false;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded';
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch';
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON';
            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded';
            default:
                return 'Unknown error';
        }
    }

}