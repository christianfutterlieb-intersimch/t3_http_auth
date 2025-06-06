# HTTP Authentication for TYPO3

This TYPO3 extension allows frontend access restriction by using HTTP
Authentication ([RFC 7235](https://datatracker.ietf.org/doc/html/rfc7235)). The
functionality will co-exist with the TYPO3 authentication system, but neither
will influence the other.

## Supported authentication schemes

* Basic ([RFC 7617](https://datatracker.ietf.org/doc/html/rfc7617))

### Planned additions

* Digest ([RFC 7616](https://datatracker.ietf.org/doc/html/rfc7616))
* Bearer Token ([RFC 6750](https://datatracker.ietf.org/doc/html/rfc6750))

## Features

### 1. Access definitions without the TYPO3 authentication system

### 2. Define access to the TYPO3 frontend on different levels

| Level | Configuration | Description | Target users |
| --- | --- | --- | --- |
| global | Environment-variables | Protect a whole TYPO3 installation, for example on a staging server | Developers, sysadmins, DevOps |
| global | `$GLOBALS['TYPO3_CONF_VARS']` | Same as above | Developers, sysadmins |
| site | Site settings | Protect a site's frontend | Developers, integrators |
| page | Database | Protect single pages. Access definition can be edited through the TYPO3 backend interface | Integrators, editors |

### 3. Secure access definitions by default

The system only works with hashed passwords, no plaintext storage of secrets is
allowed. Available hashing methods are:

1. Default: PHP's `password_hash()` with `PASSWORD_BCRYPT` (https://www.php.net/manual/en/function.password-hash.php)
2. Advanced: TYPO3 Password Hashing (https://docs.typo3.org/m/typo3/reference-coreapi/13.4/en-us/ApiOverview/PasswordHashing/Index.html).
3. Planned: Apache-style MD5 salted hashing. This hash is not secure, but it is
   the default hashing method of the `htpasswd` tool and thus widely used.

### 4. Idea: TYPO3 authentication service

Authenticate frontend user logins via HTTP Authentication, rather than through
the default felogin. Combine the Middleware with an Authentication Service
(https://docs.typo3.org/m/typo3/reference-coreapi/13.4/en-us/ApiOverview/Authentication/AuthenticationService/Index.html#authentication-service).


## Installation

### System requirements

The extension supports TYPO3 `v11.5`-`v13.4` on PHP `8.1`-`8.4`.

### Install with composer

```
composer require christianfutterlieb/t3_http_auth
```

## Docs

A documentation has not been written yet.

## License

GPLv2.0 or later

## Copyright

2025 by Christian Futterlieb
