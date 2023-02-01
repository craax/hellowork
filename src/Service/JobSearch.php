<?php

namespace App\Service;

use App\Service\API\JobiJobaClient;

class JobSearch
{

    const PARAM_WHAT = 'what';
    const PARAM_WHERE = 'where';
    const PARAM_LIMIT = 'limit';
    const PARAM_PAGE = 'page';


    /**
     * @var JobiJobaClient
     */
    private $client;

    public function __construct( JobiJobaClient $jobiJobaClient ) {
        $this->client = $jobiJobaClient;
    }

    private $country;

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    private $what;

    /**
     * @return mixed
     */
    public function getWhat()
    {
        return $this->what;
    }

    /**
     * @param mixed $what
     */
    public function setWhat($what): void
    {
        $this->what = $what;
    }

    /**
     * @return mixed
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * @param mixed $where
     */
    public function setWhere($where): void
    {
        $this->where = $where;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page): void
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit): void
    {
        $this->limit = $limit;
    }
    private $where;
    private $page;
    private $limit;

    public function search() {
        return $this->client->jobSearch(
            [
                self::PARAM_WHAT => $this->what,
                self::PARAM_WHERE => $this->where,
                self::PARAM_LIMIT => $this->limit,
                self::PARAM_PAGE => $this->page
            ]
        );
    }
}