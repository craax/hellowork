<?php

namespace App\Service;

use App\Model\API\JobiJobaQuery;
use App\Model\API\JobiJobaResponse;
use App\Service\API\JobiJobaClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class JobSearch
{

    /**
     * @var JobiJobaClient
     */
    private $client;
    /**
     * @var JobiJobaQuery
     */
    private $query;

    /**
     * @param JobiJobaClient $jobiJobaClient
     */
    public function __construct( JobiJobaClient $jobiJobaClient ) {
        $this->client = $jobiJobaClient;
    }

    /**
     * @return JobiJobaResponse|null
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function search(): ?JobiJobaResponse
    {
        return $this->client->jobSearch( $this->query );
    }

    /**
     * @param JobiJobaQuery $jobiJobaQuery
     * @return void
     */
    public function setQuery( JobiJobaQuery $jobiJobaQuery )
    {
        $this->query = $jobiJobaQuery;
    }
}