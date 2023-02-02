<?php

namespace App\Model\API;

class JobiJobaResponse
{
    private $total;
    private $ads;

    /**
     * @param $params
     */
    public function __construct( $params )
    {
        $this->total = $params->total ?: 0;
        $this->ads = $params->ads ?: [];
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getAds()
    {
        return $this->ads;
    }

    /**
     * @param mixed $ads
     */
    public function setAds($ads): void
    {
        $this->ads = $ads;
    }


}