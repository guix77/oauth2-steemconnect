<?php namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class SteemconnectResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /**
     * Domain
     *
     * @var string
     */
    protected $domain;

    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner.
     *
     * @param array  $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }

    /**
     * Get resource owner id
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getValueByKey($this->response, '_id');
    }

    /**
     * Get resource owner fake email
     *
     * Steemconnect does not provide any emails for now.
     * Many PHP apps need an email so we are building a fake one here.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getValueByKey($this->response, '_id') . '@fake-steemconnect-email.com';
    }

    /**
     * Get resource owner name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getValueByKey($this->response, 'name');
    }

    /**
     * Get resource owner account
     *
     * @return array
     */
    public function getAccount()
    {
        return $this->response['account'];
    }

    /**
     * Get resource owner profile from JSON metadata account
     *
     * @return array
     */
    public function getProfile()
    {
        return json_decode($this->getAccount()['json_metadata'], true)['profile'];
    }

    /**
     * Get resource owner nickname
     *
     * @return string|null
     */
    public function getNickname()
    {
        $value = isset($this->getProfile()['name']) ? $this->getProfile()['name'] : null;
        return $value;
    }

    /**
     * Get resource owner profile image
     *
     * @return array
     */
    public function getProfileImage()
    {
        $value = isset($this->getProfile()['profile_image']) ? $this->getProfile()['profile_image'] : null;
        return $value;
    }

    /**
     * Get resource owner cover image
     *
     * @return array
     */
    public function getCoverImage()
    {
        $value = isset($this->getProfile()['cover_image']) ? $this->getProfile()['cover_image'] : null;
        return $value;
    }

    /**
     * Get resource owner profile about
     *
     * @return string|null
     */
    public function getAbout()
    {
        $value = isset($this->getProfile()['about']) ? $this->getProfile()['about'] : null;
        return $value;
    }

    /**
     * Get resource owner profile location
     *
     * @return string|null
     */
    public function getLocation()
    {
        $value = isset($this->getProfile()['location']) ? $this->getProfile()['location'] : null;
        return $value;
    }

    /**
     * Get resource owner profile website
     *
     * @return string|null
     */
    public function getWebsite()
    {
        $value = isset($this->getProfile()['website']) ? $this->getProfile()['website'] : null;
        return $value;
    }

    /**
     * Get resource owner date of account creation
     *
     * @return string|null
     */
    public function getCreated()
    {
        return $this->getValueByKey($this->getAccount(), 'created');
    }

    /**
     * Get resource owner number of posts
     *
     * @return string|null
     */
    public function getPostCount()
    {
        return $this->getValueByKey($this->getAccount(), 'post_count');
    }

    /**
     * Get resource owner voting power
     *
     * @return string|null
     */
    public function getVotingPower()
    {
        return $this->getValueByKey($this->getAccount(), 'voting_power');
    }

    /**
     * Get resource owner last vote time
     *
     * @return string|null
     */
    public function getLastVoteTime()
    {
        return $this->getValueByKey($this->getAccount(), 'last_vote_time');
    }

    /**
     * Get resource owner balance
     *
     * @return string|null
     */
    public function getBalance()
    {
        return $this->getValueByKey($this->getAccount(), 'balance');
    }

    /**
     * Get resource owner savings balance
     *
     * @return string|null
     */
    public function getSavingsBalance()
    {
        return $this->getValueByKey($this->getAccount(), 'savings_balance');
    }

    /**
     * Get resource owner reputation
     *
     * @return string|null
     */
    public function getReputation()
    {
        return $this->getValueByKey($this->getAccount(), 'reputation');
    }

    /**
     * Get resource owner url
     *
     * @return string|null
     */
    public function getUrl()
    {
        $urlParts = array_filter([$this->domain, $this->getName()]);

        return count($urlParts) ? implode('/', $urlParts) : null;
    }

    /**
     * Set resource owner domain
     *
     * @param  string $domain
     *
     * @return ResourceOwner
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }
}
