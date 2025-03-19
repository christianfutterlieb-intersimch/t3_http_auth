# HTTP Authentication for TYPO3

This TYPO3 extension allows frontend access restriction by using HTTP
Authentication ([RFC 7235](https://datatracker.ietf.org/doc/html/rfc7235)). The
functionality will co-exist with the TYPO3 authentication system, but neither
will influence the other.

**Important note: this package is currently under active development and not yet
ready for any usage.**

## Supported authentication schemes

* Basic ([RFC 7617](https://datatracker.ietf.org/doc/html/rfc7617))
* Bearer Token ([RFC 6750](https://datatracker.ietf.org/doc/html/rfc6750)) (planned)

## Features

* Define access on a global level (what is usually done on staging/testing servers)
* Define access on a site level (protect a whole TYPO3 site)
* Define access on a page level
* Set up access by configuration (Developers, Integrators)
* Set up access via TYPO3 Backend (Integrators, Editors)

## Installation

```
composer require christianfutterlieb/t3_http_auth
```

## Docs

The documentation can be found here:
https://docs.typo3.org/p/christianfutterlieb/http_authentication/main/en-us/

## License

GPLv2.0 or later

## Copyright

2025 by Christian Futterlieb
