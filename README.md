# Steemconnect Provider for OAuth 2.0 Client
[![Latest Version](https://img.shields.io/github/release/guix77/oauth2-steemconnect.svg?style=flat-square)](https://github.com/guix77/oauth2-steemconnect/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/guix77/oauth2-steemconnect/master.svg?style=flat-square)](https://travis-ci.org/guix77/oauth2-steemconnect)
[![Quality Score](https://img.shields.io/scrutinizer/g/guix77/oauth2-steemconnect.svg?style=flat-square)](https://scrutinizer-ci.com/g/guix77/oauth2-steemconnect)
[![Total Downloads](https://img.shields.io/packagist/dt/guix77/oauth2-steemconnect.svg?style=flat-square)](https://packagist.org/packages/guix77/oauth2-steemconnect)

This package provides Steemconnect API v2 OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

    composer require guix77/oauth2-steemconnect

## Usage

Usage is the same as The League's OAuth client, using `\League\OAuth2\Client\Provider\Steemconnect` as the provider.

### Authorization code flow

```php
$provider = new League\OAuth2\Client\Provider\Steemconnect([
    'clientId'          => '{your-steem-app-name}',
    'clientSecret'      => '{your-steem-app-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $user->getNickname());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```

### Managing Scopes

When creating your Steemconnect authorization URL, you can specify the scopes your application may authorize.

```php
$options = [
    'scope' => ['login', 'post'] // @see https://github.com/steemit/steemconnect/wiki/OAuth-2
];

$authorizationUrl = $provider->getAuthorizationUrl($options);
```
If neither are defined, the provider will utilize internal defaults ('login' scope).

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Steemconnect PHP modules / plugins

+ Drupal : https://www.drupal.org/project/social_auth_steemconnect (uses this provider)
+ Wordpress : https://github.com/guix77/wordpress-social-login/tree/steemconnect (I've submitted a PR to include it in the excellent Wordpress Social Login plugin, let's hope a release will make its way to Wordpress plugins repository!)

## License

The MIT License (MIT). Please see [License File](https://github.com/guix77/oauth2-steemconnect/blob/master/LICENSE) for more information.

## Credits

- [Guillaume Duveau](https://github.com/guix77/oauth2-steemconnect/contributors)
- Adapted to Steemconnect from https://github.com/thephpleague/oauth2-github

## Donations

If you want to support the original developer and current maintainer, donations are welcome at:
+ Steemit: @guix77 / https://steemit.com/@guix77
+ Bitcoin: 12BkpRaeAPcUvxft5yWrSxtknVe7jNUNer
+ Ethereum and Ethereum-based (ERC-20) Tokens: 0xa32e0e0a0C8Aa10ac70a2827cB20641850824eEc
+ Cardano: DdzFFzCqrhsfUhaNNWuV1BSgjXC5ySNMhfPFRASXTkj26qCKoyYSbW3qWzQucuVLU2AE6AzuYiEfgHnc3DwhSyofeqZZxzANVMLBpDxp
+ Paypal : guillaume.duveau@gmail.com
