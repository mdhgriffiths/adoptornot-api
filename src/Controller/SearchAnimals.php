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

            // Search for available animals to adopt
            $animals = $this->apiClient->searchAnimals(
                $this->getSearchFields(),
                $this->getSearchFilters()
            );

            // Return list of adoptable animals
            return $response->withJson($animals, 200, JSON_PRETTY_PRINT);
            // TODO: don't set JSON_PRETTY_PRINT in production

        // TODO: error handling
        } catch (\Exception $e) {
            throw $e;

        }
    }

    /**
     * Get list of animal fields to fetch
     * @link https://userguide.rescuegroups.org/display/APIDG/Object+definitions#Objectdefinitions-17.publicSearch
     * @return array
     */
    protected function getSearchFields() {
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
    protected function getSearchFilters() {
        return [
            // Only adoptable pets
            ['fieldName' => 'animalStatus', 'operation' => 'equals', 'criteria' => 'Available'],
            // Dogs are better than cats
            ['fieldName' => 'animalSpecies', 'operation' => 'equals', 'criteria' => 'Dog']
        ];
    }

}
