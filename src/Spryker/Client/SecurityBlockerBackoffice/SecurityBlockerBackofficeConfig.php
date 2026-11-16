<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SecurityBlockerBackoffice;

use Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer;
use Spryker\Client\Kernel\AbstractBundleConfig;
use Spryker\Shared\SecurityBlockerBackoffice\SecurityBlockerBackofficeConfig as SharedSecurityBlockerBackofficeConfig;
use Spryker\Shared\SecurityBlockerBackoffice\SecurityBlockerBackofficeConstants;

class SecurityBlockerBackofficeConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const BACKOFFICE_USER_SECURITY_BLOCKER_ENTITY_TYPE = 'back-office-user';

    protected const int DEFAULT_USER_ACCOUNT_BLOCKING_NUMBER_OF_ATTEMPTS = 9;

    protected const int DEFAULT_USER_ACCOUNT_BLOCKING_COUNTING_WINDOW_MINUTES = 15;

    protected const int DEFAULT_USER_ACCOUNT_BLOCKING_DURATION_MINUTES = 6;

    protected const int DEFAULT_USER_ACCOUNT_CHALLENGE_NUMBER_OF_ATTEMPTS = 3;

    protected const int DEFAULT_USER_IP_CHALLENGE_NUMBER_OF_ATTEMPTS = 5;

    protected const int DEFAULT_USER_GLOBAL_CHALLENGE_NUMBER_OF_ATTEMPTS = 30;

    protected const int DEFAULT_USER_GLOBAL_CHALLENGE_TIME_WINDOW_MINUTES = 5;

    protected const int SECONDS_PER_MINUTE = 60;

    /**
     * Specification:
     * - Returns the login protection settings of the user realm (`SecurityBlockerBackofficeConfig::LOGIN_REALM_USER`).
     * - The user realm is shared by every login surface of a user: Back Office, Merchant Portal, Merchant Portal agent, Yves agent and Backend API.
     * - Reads the account lock and the login challenge thresholds from the Back Office settings `security:login_lock:user:*` of this module.
     * - Converts the time settings, which the Back Office stores in minutes, to seconds.
     * - Without the Configuration module: locks an account after 9 failed logins within 15 minutes for 6 minutes, and requires a
     *   login challenge after 3 failed logins to one account, 5 from one IP address or 30 across all accounts within 5 minutes.
     * - A threshold of `0` disables that dimension; it is never replaced by a default.
     *
     * @api
     */
    public function getUserLoginRealmConfiguration(): SecurityBlockerLoginRealmConfigurationTransfer
    {
        return (new SecurityBlockerLoginRealmConfigurationTransfer())
            ->setRealm(SharedSecurityBlockerBackofficeConfig::LOGIN_REALM_USER)
            ->setAccountNumberOfAttempts($this->getIntegerSetting(SharedSecurityBlockerBackofficeConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_NUMBER_OF_FAILED_ATTEMPTS, static::DEFAULT_USER_ACCOUNT_BLOCKING_NUMBER_OF_ATTEMPTS))
            ->setAccountTtl($this->getMinutesSettingInSeconds(SharedSecurityBlockerBackofficeConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_COUNTING_WINDOW, static::DEFAULT_USER_ACCOUNT_BLOCKING_COUNTING_WINDOW_MINUTES))
            ->setAccountBlockFor($this->getMinutesSettingInSeconds(SharedSecurityBlockerBackofficeConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_DURATION, static::DEFAULT_USER_ACCOUNT_BLOCKING_DURATION_MINUTES))
            ->setAccountChallengeNumberOfAttempts($this->getIntegerSetting(SharedSecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_ACCOUNT_NUMBER_OF_FAILED_ATTEMPTS, static::DEFAULT_USER_ACCOUNT_CHALLENGE_NUMBER_OF_ATTEMPTS))
            ->setIpChallengeNumberOfAttempts($this->getIntegerSetting(SharedSecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_IP_NUMBER_OF_FAILED_ATTEMPTS, static::DEFAULT_USER_IP_CHALLENGE_NUMBER_OF_ATTEMPTS))
            ->setGlobalChallengeNumberOfAttempts($this->getIntegerSetting(SharedSecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_NUMBER_OF_FAILED_ATTEMPTS, static::DEFAULT_USER_GLOBAL_CHALLENGE_NUMBER_OF_ATTEMPTS))
            ->setGlobalTtl($this->getMinutesSettingInSeconds(SharedSecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_TIME_WINDOW, static::DEFAULT_USER_GLOBAL_CHALLENGE_TIME_WINDOW_MINUTES));
    }

    /**
     * Specification:
     * - Returns security blocker Backoffice entity type.
     *
     * @api
     */
    public function getBackofficeUserSecurityBlockerEntityType(): string
    {
        return static::BACKOFFICE_USER_SECURITY_BLOCKER_ENTITY_TYPE;
    }

    /**
     * Specification:
     * - Returns backoffice user time for block in seconds.
     *
     * @api
     */
    public function getBackofficeUserBlockForSeconds(): int
    {
        return $this->get(SecurityBlockerBackofficeConstants::BACKOFFICE_USER_BLOCK_FOR_SECONDS, 0);
    }

    /**
     * Specification:
     * - Returns backoffice user blocking TTL in seconds.
     *
     * @api
     */
    public function getBackofficeUserBlockingTTL(): int
    {
        return $this->get(SecurityBlockerBackofficeConstants::BACKOFFICE_USER_BLOCKING_TTL, 0);
    }

    /**
     * Specification:
     * - Returns backoffice user number of attempts configuration.
     *
     * @api
     */
    public function getBackofficeUserBlockingNumberOfAttempts(): int
    {
        return $this->get(SecurityBlockerBackofficeConstants::BACKOFFICE_USER_BLOCKING_NUMBER_OF_ATTEMPTS, 0);
    }

    protected function getIntegerSetting(string $settingKey, int $default): int
    {
        return (int)$this->getModuleConfig($settingKey, $default);
    }

    protected function getMinutesSettingInSeconds(string $settingKey, int $defaultMinutes): int
    {
        return $this->getIntegerSetting($settingKey, $defaultMinutes) * static::SECONDS_PER_MINUTE;
    }
}
