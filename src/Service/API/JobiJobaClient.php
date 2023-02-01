<?php

namespace App\Service\API;

use App\Service\JobSearch;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class JobiJobaClient
{

    const DEFAULT_PAGE = 1;
    const DEFAULT_LIMIT = 10;


    /**
     * @var HttpClientInterface
     */
    private $client;

    private $token;
    /**
     * @var ParameterBagInterface
     */
    private $parameters;

    // Could depend on user language selection
    public $country = 'fr';

    public function __construct(HttpClientInterface $client, ParameterBagInterface $parameterBag) {
        $this->client = $client;
        $this->parameters = $parameterBag;
    }

    private function getBasicUrl(): string
    {
        return $this->parameters->get('jobijoba.url') . '/' . $this->country;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    private function getAuthToken() {

        if ( empty( $this->token ) ) {

            $response = $this->client->request('POST', $this->getBasicUrl() . '/login', [
                'body' => json_encode([
                    'client_id' => $this->parameters->get('jobijoba.client'),
                    'client_secret' => $this->parameters->get('jobijoba.secret')
                ])
            ]);

            if ( $body = $this->handleResponse($response) ) {
                $this->token = $body->token;
            }
        }

        return $this->token;
    }

    private function handleResponse( $response ) {

        //dump($response->getStatusCode());
        if ( $response->getStatusCode() === Response::HTTP_OK ) {
            return json_decode($response->getContent());
        }
        return null;
    }


    /**
     * @throws TransportExceptionInterface
     */
    public function jobSearch( $params ) {
        $response = $this->client->request('GET', $this->getBasicUrl() . '/ads/search', [
            'headers' => [
                'Authorization: Bearer '. $this->getAuthToken()
            ],
            'query' => [
                JobSearch::PARAM_WHAT => $params[JobSearch::PARAM_WHAT],
                JobSearch::PARAM_WHERE => $params[JobSearch::PARAM_WHERE],
                JobSearch::PARAM_PAGE => $params[JobSearch::PARAM_PAGE] ?: self::DEFAULT_PAGE,
                JobSearch::PARAM_LIMIT => $params[JobSearch::PARAM_LIMIT] ?: self::DEFAULT_LIMIT
            ]
        ]);

        if ( $body = $this->handleResponse($response) ) {
            return $body->data;
        }
        return null;
    }

}