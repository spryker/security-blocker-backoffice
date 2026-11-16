<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\SecurityBlockerBackoffice;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class SecurityBlockerBackofficeConfig extends AbstractSharedConfig
{
    /**
     * Specification:
     * - Identity realm of users (Back Office, Merchant Portal, agents, Backend API).
     * - Login attempts against one user account are counted together, regardless of the login surface and the source IP.
     *
     * @api
     */
    public const string LOGIN_REALM_USER = 'user';

    /**
     * Specification:
     * - Key of the Back Office setting with the number of failed logins to one user account, from any IP address and any login surface,
     *   after which the account is locked: a whole number from 1 to 100, `9` by default.
     *
     * @api
     */
    public const string CONFIGURATION_KEY_ACCOUNT_LOCK_NUMBER_OF_FAILED_ATTEMPTS = 'security:login_lock:user:number_of_failed_attempts';

    /**
     * Specification:
     * - Key of the Back Office setting with the minutes in which failed logins to one user account are counted, starting
     *   with the first one: a whole number from 1 to 1440, `15` by default.
     *
     * @api
     */
    public const string CONFIGURATION_KEY_ACCOUNT_LOCK_COUNTING_WINDOW = 'security:login_lock:user:counting_window';

    /**
     * Specification:
     * - Key of the Back Office setting with the minutes a locked user account stays locked: a whole number from 1 to 1440,
     *   `6` by default.
     *
     * @api
     */
    public const string CONFIGURATION_KEY_ACCOUNT_LOCK_DURATION = 'security:login_lock:user:lock_duration';

    /**
     * Specification:
     * - Key of the Back Office setting with the number of failed logins to one user account, from any IP address, after which
     *   a login challenge is required (`SecurityCheckAuthResponseTransfer.isChallengeRequired`): a whole number from 1 to 10, `3` by default.
     * - When this number is not below the account lock, the challenge is required one login before the lock.
     * - The login forms answer a required challenge with a CAPTCHA while the CAPTCHA is on in the `after_failed_attempts` mode.
     *
     * @api
     */
    public const string CONFIGURATION_KEY_CHALLENGE_ACCOUNT_NUMBER_OF_FAILED_ATTEMPTS = 'security:login_lock:user:challenge_account_number_of_failed_attempts';

    /**
     * Specification:
     * - Key of the Back Office setting with the number of failed user logins from one IP address after which a login challenge
     *   is required (`SecurityCheckAuthResponseTransfer.isChallengeRequired`): a whole number from 0 to 1000, `5` by default.
     * - Also caps the failed logins from one IP address that count toward `CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_NUMBER_OF_FAILED_ATTEMPTS`.
     * - `0` turns both off.
     * - The login forms answer a required challenge with a CAPTCHA while the CAPTCHA is on in the `after_failed_attempts` mode.
     *
     * @api
     */
    public const string CONFIGURATION_KEY_CHALLENGE_IP_NUMBER_OF_FAILED_ATTEMPTS = 'security:login_lock:user:challenge_ip_number_of_failed_attempts';

    /**
     * Specification:
     * - Key of the Back Office setting with the number of failed user logins across all accounts within
     *   `CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_TIME_WINDOW` after which a login challenge is required for every user login:
     *   a whole number from 0 to 100000, `30` by default.
     * - Reaching this number writes the `login_global_challenge_threshold_reached` entry to the security audit log while
     *   `SecurityBlockerConfig::isSecurityAuditLogEnabled()` (Client, SecurityBlocker) returns `true`.
     * - `0` turns both off.
     * - The login forms answer a required challenge with a CAPTCHA while the CAPTCHA is on in the `after_failed_attempts` mode.
     *
     * @api
     */
    public const string CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_NUMBER_OF_FAILED_ATTEMPTS = 'security:login_lock:user:challenge_all_accounts_number_of_failed_attempts';

    /**
     * Specification:
     * - Key of the Back Office setting with the minutes in which failed user logins across all accounts are counted, starting
     *   with the first one: a whole number from 1 to 60, `5` by default.
     *
     * @api
     */
    public const string CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_TIME_WINDOW = 'security:login_lock:user:challenge_all_accounts_time_window';
}
