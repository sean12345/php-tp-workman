<?php
/**
 * OAuth 2.0 Resource Server
 *
 * @package     league/oauth2-server
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace League\OAuth2\Server;

use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Exception\AccessDeniedException;
use League\OAuth2\Server\Exception\InvalidRequestException;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use League\OAuth2\Server\Storage\ClientInterface;
use League\OAuth2\Server\Storage\ScopeInterface;
use League\OAuth2\Server\Storage\SessionInterface;
use League\OAuth2\Server\TokenType\Bearer;
use League\OAuth2\Server\TokenType\MAC;

/**
 * OAuth 2.0 Resource Server
 */
class ResourceServer extends AbstractServer
{
    /**
     * The access token
     *
     * @var \League\OAuth2\Server\Entity\AccessTokenEntity
     */
    protected $accessToken;

    /**
     * The query string key which is used by clients to present the access token (default: access_token)
     *
     * @var string
     */
        protected $tokenKey = 'access_token';

    /**
     * Initialise the resource server
     *
     * @param \League\OAuth2\Server\Storage\SessionInterface     $sessionStorage
     * @param \League\OAuth2\Server\Storage\AccessTokenInterface $accessTokenStorage
     * @param \League\OAuth2\Server\Storage\ClientInterface      $clientStorage
     * @param \League\OAuth2\Server\Storage\ScopeInterface       $scopeStorage
     *
     * @return self
     */
    public function __construct(
        SessionInterface $sessionStorage,
        AccessTokenInterface $accessTokenStorage,
        ClientInterface $clientStorage,
        ScopeInterface $scopeStorage
    ) {
        $this->setSessionStorage($sessionStorage);
//        设置令牌访问接口
        $this->setAccessTokenStorage($accessTokenStorage);
        $this->setClientStorage($clientStorage);
        $this->setScopeStorage($scopeStorage);

        // Set Bearer as the default token type
        $this->setTokenType(new Bearer());

        parent::__construct();

        return $this;
    }

    /**
     * Sets the query string key for the access token.
     *
     * @param string $key The new query string key
     *
     * @return self
     */
    public function setIdKey($key)
    {
        $this->tokenKey = $key;

        return $this;
    }

    /**
     * Gets the access token
     *
     * @return \League\OAuth2\Server\Entity\AccessTokenEntity
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Checks if the access token is valid or not
     *
     * @param bool                                                $headerOnly Limit Access Token to Authorization header
     * @param \League\OAuth2\Server\Entity\AccessTokenEntity|null $accessToken Access Token
     *
     * @throws \League\OAuth2\Server\Exception\AccessDeniedException
     * @throws \League\OAuth2\Server\Exception\InvalidRequestException
     *
     * @return bool
     */
    public function isValidRequest($headerOnly = true, $accessToken = null)
    {

//        获取access_token
        $accessTokenString = ($accessToken !== null)
                                ? $accessToken
                                : $this->determineAccessToken($headerOnly);
        // Set the access token
//        检查access_token是否允许
        $this->accessToken = $this->getAccessTokenStorage()->get($accessTokenString);

        // Ensure the access token exists
//        access_token不允许
        if (!$this->accessToken instanceof AccessTokenEntity) {
            throw new AccessDeniedException();
        }

        // Check the access token hasn't expired
        // Ensure the auth code hasn't expired
//        验证是够在有效期内
        if ($this->accessToken->isExpired() === true) {
            throw new AccessDeniedException();
        }
        return true;
    }

    /**
     * Reads in the access token from the headers
     *
     * @param bool $headerOnly Limit Access Token to Authorization header
     *
     * @throws \League\OAuth2\Server\Exception\InvalidRequestException Thrown if there is no access token presented
     *
     * @return string
     */
    public function determineAccessToken($headerOnly = false)
    {
//        页头如果有Authorization
        if ($this->getRequest()->headers->get('Authorization') !== null) {
            $accessToken = $this->getTokenType()->determineAccessTokenInHeader($this->getRequest());
        }
//        不仅仅从页头并且？
        elseif ($headerOnly === false && (! $this->getTokenType() instanceof MAC)) {
//            如果是GET，从query里取
//            如果不是GET，从request里取
            $accessToken = ($this->getRequest()->server->get('REQUEST_METHOD') === 'GET')
                                ? $this->getRequest()->query->get($this->tokenKey)
                                : $this->getRequest()->request->get($this->tokenKey);
        }
//        access_token为空
        if (empty($accessToken)) {
            throw new InvalidRequestException('access token');
        }
//        返回access_token
        return $accessToken;
    }
}
