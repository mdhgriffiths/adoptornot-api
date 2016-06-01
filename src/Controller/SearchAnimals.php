<?php

namespace AdoptOrNot\Api\Controller;
use AdoptOrNot\Api\RescueGroups\ApiClient;
use \Slim\Http\Response as Response;
use \Slim\Http\Request as Request;

/**
 * SearchAnimals controller
 * @package AdoptOrNot\Api\Controller
 */
class SearchAnimals {

    /**
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * Results limit
     * @var int
     */
    protected $limit = 10;

    /**
     * Constructor
     * @param ApiClient $apiClient
     */
    public function __construct (ApiClient $apiClient) {
        $this->apiClient = $apiClient;
    }

    /**
     * Invoke controller action
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     * @throws \Exception
     */
    public function __invoke (Request $request, Response $response, $args) {
        try {

            // Find & return list of available pets
            $animals = $this->getAvailableAnimals();
            return $response->withJson($animals, 200, JSON_PRETTY_PRINT);

        // TODO: error handling
        } catch (\Exception $e) {
            throw $e;

        }
    }

    /**
     * Get animals to adopt
     * @return mixed
     * @throws \Exception
     */
    protected function getAvailableAnimals () {
        return $this->apiClient->post([
            'objectType' => 'animals',
            'objectAction' => 'publicSearch',
            'search' => [
                'resultSort' => 'animalID',
                'resultLimit' => $this->limit,
                'fields' => $this->getAnimalFields(),
                'filters' => $this->getAnimalFilters()
            ]
        ]);
    }

    /**
     * Get list of animal fields to fetch
     * @link https://userguide.rescuegroups.org/display/APIDG/Object+definitions#Objectdefinitions-17.publicSearch
     * @return array
     */
    protected function getAnimalFields() {
        return [
            'animalID',
            'animalOrgID',
            'animalUrl',
            'animalSex',
            'animalName',
            'animalBreed',
            'animalSpecies',
            'animalLocation',
            'animalLocationCitystate',
            'animalDescriptionPlain',
            'animalThumbnailUrl'
        ];
    }

    /**
     * Get filters for searching animals
     * @link https://userguide.rescuegroups.org/display/APIDG/Using+search+filters+with+the+HTTP+API
     * @return array
     */
    protected function getAnimalFilters() {
        return [
            // Only adoptable pets
            ['fieldName' => 'animalStatus', 'operation' => 'equals', 'criteria' => 'Available'],
            // Dogs are better than cats
            ['fieldName' => 'animalSpecies', 'operation' => 'equals', 'criteria' => 'Dog']
        ];
    }

}