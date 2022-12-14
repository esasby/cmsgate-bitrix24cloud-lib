<?php


namespace esas\cmsgate\bridge;

class ShopConfigBitrix24 extends ShopConfig
{
    protected $domain = null;
    protected $accessToken = null;
    protected $expireAt = null;
    protected $refreshToken = null;
    protected $memberId = null;

    /**
     * @return null
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param null $domain
     * @return ShopConfigBitrix24
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param null $accessToken
     * @return ShopConfigBitrix24
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @return null
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }

    /**
     * @param null $expireAt
     * @return ShopConfigBitrix24
     */
    public function setExpireAt($expireAt)
    {
        $this->expireAt = $expireAt;
        return $this;
    }

    /**
     * @return null
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param null $refreshToken
     * @return ShopConfigBitrix24
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    /**
     * @return null
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @param null $memberId
     * @return ShopConfigBitrix24
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
        return $this;
    }
}