<?php

namespace App\Model\API;

class JobiJobaQuery
{
    const PARAM_WHAT = 'what';
    const PARAM_WHERE = 'where';
    const PARAM_LIMIT = 'limit';
    const PARAM_PAGE = 'page';



    const DEFAULT_PAGE = 1;
    const DEFAULT_LIMIT = 10;

    private $country = 'FR';

    private $page;
    private $limit;
    private $what;
    private $where;

    /**
     * @param array $params
     */
    public function __construct( array $params ) {

        $this->what = array_key_exists('what', $params) ? $params['what'] : '';
        $this->where = array_key_exists('where', $params) ? $params['where'] : '';
        $this->page = array_key_exists('page', $params) ? $params['page'] : self::DEFAULT_PAGE;
        $this->limit = array_key_exists('limit', $params) ? $params['limit'] : self::DEFAULT_LIMIT;

    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage( int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit( int $limit ): void
    {
        $this->limit = $limit;
    }

    /**
     * @return string
     */
    public function getWhat(): string
    {
        return $this->what;
    }

    /**
     * @param string $what
     */
    public function setWhat( string $what ): void
    {
        $this->what = $what;
    }

    /**
     * @return string
     */
    public function getWhere(): string
    {
        return $this->where;
    }

    /**
     * @param string $where
     */
    public function setWhere( string $where ): void
    {
        $this->where = $where;
    }
}