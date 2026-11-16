# SecurityBlockerBackoffice Module
[![Latest Stable Version](https://poser.pugx.org/spryker/security-blocker-backoffice/v/stable.svg)](https://packagist.org/packages/spryker/security-blocker-backoffice)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.3-8892BF.svg)](https://php.net/)

Module provides functionality to secure backoffice authentication process. It owns the `user` login realm of the Back Office, Merchant Portal and agent logins, whose account lock and security check (CAPTCHA) limits per account, per IP address and across all accounts are set in the Back Office on **Configuration → Security → Login Lock → User Accounts** (`security:login_lock:user:*`).

## Installation

```
composer require spryker/security-blocker-backoffice
```

## Documentation

[Spryker Documentation](https://docs.spryker.com)
