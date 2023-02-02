<?php

namespace App\Service\API;

use App\Model\API\JobiJobaQuery;
use App\Model\API\JobiJobaResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

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

            if ( $body = $this->handleResponse( $response ) ) {
                $this->token = $body->token;
            }
        }

        return $this->token;
    }

    /**
     * @param ResponseInterface $response
     * @return mixed|null
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    private function handleResponse( ResponseInterface $response ) {

        if ( $response->getStatusCode() === Response::HTTP_OK ) {
            return json_decode($response->getContent());
        }
        return null;
    }


    /**
     * @param JobiJobaQuery $jobiJobaQuery
     * @return JobiJobaResponse|null
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function jobSearch( JobiJobaQuery $jobiJobaQuery ): ?JobiJobaResponse
    {
        $response = $this->client->request('GET', $this->getBasicUrl() . '/ads/search', [
            'headers' => [
                'Authorization: Bearer '. $this->getAuthToken()
            ],
            'query' => [
                JobiJobaQuery::PARAM_WHAT => $jobiJobaQuery->getWhat(),
                JobiJobaQuery::PARAM_WHERE => $jobiJobaQuery->getWhere(),
                JobiJobaQuery::PARAM_PAGE => $jobiJobaQuery->getPage(),
                JobiJobaQuery::PARAM_LIMIT => $jobiJobaQuery->getLimit()
            ]
        ]);

        if ( $body = $this->handleResponse($response) ) {
            return new JobiJobaResponse( $body->data );
        }
        return null;
    }

}