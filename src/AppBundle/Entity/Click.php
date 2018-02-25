<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="click")
 */
class Click
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    protected $id;

    /**
     * @ORM\Column(name="ua", type="string")
     */
    protected $userAgent;

    /**
     * @ORM\Column(name="ip", type="string")
     */
    protected $ip;

    /**
     * @ORM\Column(name="ref", type="string", nullable=true)
     */
    protected $referrer;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $param1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $param2;

    /**
     * @ORM\Column(name="error", type="integer")
     */
    protected $error = 0;

    /**
     * @ORM\Column(name="bad_domain", type="boolean")
     */
    protected $badDomain = false;

    /**
     * Click constructor.
     * @param $userAgent
     * @param $ip
     * @param $ref
     * @param $param1
     * @param $param2
     */
    public function __construct($userAgent, $ip, $ref, $param1, $param2)
    {
        $this->userAgent = $userAgent;
        $this->ip = $ip;
        $this->referrer = $ref;
        $this->param1 = $param1;
        $this->param2 = $param2;
        $this->id = md5($userAgent + $ip + $ref + $param1);
    }

    public function __toString()
    {
        return $this->userAgent . DIRECTORY_SEPARATOR . $this->ip;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user agent
     *
     * @param string $userAgent
     * @return Click
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get user agent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Click
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set referrer
     *
     * @param string $referrer
     * @return Click
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * Get referrer
     *
     * @return string
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * Get first parameter
     *
     * @return string
     */
    public function getParam1()
    {
        return $this->param1;
    }

    /**
     * Get second parameter
     *
     * @return string
     */
    public function getParam2()
    {
        return $this->param2;
    }
    
    public function incrementError()
    {
        $this->error++;
    }

    public function thisDomainIsBad()
    {
        $this->badDomain = true;
    }
}
