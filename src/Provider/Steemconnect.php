<?php

namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\Exception\SteemconnectIdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Steemconnect extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Domain
     *
     * @var string
     */
    public $domain = 'https://v2.steemconnect.com';

    /**
     * Api domain
     *
     * @var string
     */
    public $apiDomain = 'https://v2.steemconnect.com/api';

    /**
     * A list of all scopes available in the Steemconnect API v2.
     * @see https://github.com/steemit/steemconnect/wiki/OAuth-2
     *
     * TODO: are all those scopes safe for access by a server? Ask Steemit INC.
     *
     * @var array
     */
    protected $allScopes = array(
      'login',
      'offline',
      'vote',
      'comment',
      'comment_delete',
      'comment_options',
      'custom_json',
      'claim_reward_balance',
    );

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->domain.'/oauth2/authorize';
    }

    /**
     * Get access token url to retrieve token
     *
     * @param  array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->domain.'/api/oauth2/token';
    }

    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->apiDomain.'/me';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * TODO: @see question about scopes safety for servers.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return ['login'];
    }

    /**
     * Check a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  array $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw SteemconnectIdentityProviderException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw SteemconnectProviderException::oauthException($response, $data);
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $user = new SteemconnectResourceOwner($response);

        return $user->setDomain($this->domain);
    }
}
