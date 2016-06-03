<?php

namespace AdoptOrNot\Api\Util;

/**
 * cURL client wrapper
 * Used to handle making cURL requests
 */
class CurlClient {

	/**
	 * URL to fetch
	 * @var string
	 */
	protected $url;

	/**
	 * @param string $url
	 */
	public function __construct($url) {
		$this->url = $url;
	}

	/**
	 * Send POST request with headers
	 * @param array|string $data Data to POST
	 * @param array $headers HTTP request headers
	 * @return mixed
	 * @throws \Exception If request failed
	 */
	public function post($data, array $headers = []) {

		// Encode POST data
		$postData = $this->_encodeData($data);

		// Setup cURL session
		$curl = $this->_initCurlSession([
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $postData,
			CURLOPT_HTTPHEADER => $headers
		]);

		// Execute request & return response
		return $this->_execCurlSession($curl);

	}

	/**
	 * Initialize cURL with provided opts
	 * @param array $opts cURL options
	 * @return resource cURL resource
	 */
	protected function _initCurlSession(array $opts = []) {
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $this->url,
		    CURLOPT_RETURNTRANSFER => true,
			CURLOPT_VERBOSE => true
		] + $opts);
		return $curl;
	}

	/**
	 * Execute cURL session & return response
	 * @param resource $curl cURL resource
	 * @return mixed Response data
	 * @throws \Exception If cURL failed
	 */
	protected function _execCurlSession($curl) {
		$result = curl_exec($curl);
		if (curl_errno($curl)) {
			throw new \Exception(sprintf(
				'Failed to execute cURL request [%s]',
				curl_error($curl)
			));
		}
		curl_close($curl);
		return $result;
	}

	/**
	 * Encode HTTP request data
	 * @param string|array $data
	 * @return string
	 */
	protected function _encodeData($data) {
		if (is_string($data)) return $data;
		return http_build_query($data);
	}

}
