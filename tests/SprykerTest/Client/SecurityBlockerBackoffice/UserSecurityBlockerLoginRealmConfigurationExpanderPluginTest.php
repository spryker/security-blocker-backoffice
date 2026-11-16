<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\SecurityBlockerBackoffice;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer;
use Spryker\Client\SecurityBlockerBackoffice\Plugin\SecurityBlocker\UserSecurityBlockerLoginRealmConfigurationExpanderPlugin;
use Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeClient;
use Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeConfig as ClientSecurityBlockerBackofficeConfig;
use Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeFactory;
use Spryker\Shared\SecurityBlockerBackoffice\SecurityBlockerBackofficeConfig;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Client
 * @group SecurityBlockerBackoffice
 * @group UserSecurityBlockerLoginRealmConfigurationExpanderPluginTest
 * Add your own group annotations below this line
 */
class UserSecurityBlockerLoginRealmConfigurationExpanderPluginTest extends Unit
{
    protected const string OTHER_REALM = 'other-realm';

    protected SecurityBlockerBackofficeClientTester $tester;

    /**
     * A threshold of `0` disables its dimension, so it must reach the security blocker unchanged.
     */
    public function testExpandAddsTheUserRealmWithTheConfiguredThresholdsAndKeepsOtherRealms(): void
    {
        // Arrange
        $otherRealmConfigurationTransfer = (new SecurityBlockerLoginRealmConfigurationTransfer())->setRealm(static::OTHER_REALM);
        $userSecurityBlockerLoginRealmConfigurationExpanderPlugin = new UserSecurityBlockerLoginRealmConfigurationExpanderPlugin();
        $userSecurityBlockerLoginRealmConfigurationExpanderPlugin->setClient($this->createClientWithBackOfficeSettings([
            SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_NUMBER_OF_FAILED_ATTEMPTS => '7',
            SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_NUMBER_OF_FAILED_ATTEMPTS => '0',
        ]));

        // Act
        $securityBlockerLoginRealmConfigurationTransfers = $userSecurityBlockerLoginRealmConfigurationExpanderPlugin->expand([static::OTHER_REALM => $otherRealmConfigurationTransfer]);

        // Assert
        $this->assertSame([static::OTHER_REALM, SecurityBlockerBackofficeConfig::LOGIN_REALM_USER], array_keys($securityBlockerLoginRealmConfigurationTransfers));
        $userLoginRealmConfigurationTransfer = $securityBlockerLoginRealmConfigurationTransfers[SecurityBlockerBackofficeConfig::LOGIN_REALM_USER];
        $this->assertSame(SecurityBlockerBackofficeConfig::LOGIN_REALM_USER, $userLoginRealmConfigurationTransfer->getRealm());
        $this->assertSame(7, $userLoginRealmConfigurationTransfer->getAccountNumberOfAttempts());
        $this->assertSame(0, $userLoginRealmConfigurationTransfer->getGlobalChallengeNumberOfAttempts());
    }

    public function testGetUserLoginRealmConfigurationAppliesTheModuleDefaultsWhenNothingIsConfigured(): void
    {
        // Act
        $userLoginRealmConfigurationTransfer = $this->createConfigWithBackOfficeSettings([])->getUserLoginRealmConfiguration();

        // Assert
        $this->assertSame(9, $userLoginRealmConfigurationTransfer->getAccountNumberOfAttempts());
        $this->assertSame(900, $userLoginRealmConfigurationTransfer->getAccountTtl());
        $this->assertSame(360, $userLoginRealmConfigurationTransfer->getAccountBlockFor());
        $this->assertSame(3, $userLoginRealmConfigurationTransfer->getAccountChallengeNumberOfAttempts());
        $this->assertSame(5, $userLoginRealmConfigurationTransfer->getIpChallengeNumberOfAttempts());
        $this->assertSame(30, $userLoginRealmConfigurationTransfer->getGlobalChallengeNumberOfAttempts());
        $this->assertSame(300, $userLoginRealmConfigurationTransfer->getGlobalTtl());
    }

    /**
     * The Back Office stores whole numbers as strings, and the time settings in minutes.
     *
     * @dataProvider provideBackOfficeSettings
     */
    public function testGetUserLoginRealmConfigurationTakesEachValueFromItsBackOfficeSetting(
        string $settingKey,
        string $storedValue,
        string $property,
        int $expectedValue
    ): void {
        // Arrange
        $securityBlockerBackofficeConfig = $this->createConfigWithBackOfficeSettings([$settingKey => $storedValue]);

        // Act
        $userLoginRealmConfigurationTransfer = $securityBlockerBackofficeConfig->getUserLoginRealmConfiguration();

        // Assert
        $this->assertSame($expectedValue, $userLoginRealmConfigurationTransfer->toArray(true, true)[$property]);
    }

    /**
     * @return array<string, array{string, string, string, int}>
     */
    public function provideBackOfficeSettings(): array
    {
        return [
            'account lock' => [SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_NUMBER_OF_FAILED_ATTEMPTS, '4', SecurityBlockerLoginRealmConfigurationTransfer::ACCOUNT_NUMBER_OF_ATTEMPTS, 4],
            'account lock counting window in minutes' => [SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_COUNTING_WINDOW, '20', SecurityBlockerLoginRealmConfigurationTransfer::ACCOUNT_TTL, 1200],
            'account lock duration in minutes' => [SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_DURATION, '10', SecurityBlockerLoginRealmConfigurationTransfer::ACCOUNT_BLOCK_FOR, 600],
            'challenge per account' => [SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_ACCOUNT_NUMBER_OF_FAILED_ATTEMPTS, '7', SecurityBlockerLoginRealmConfigurationTransfer::ACCOUNT_CHALLENGE_NUMBER_OF_ATTEMPTS, 7],
            'challenge per IP address' => [SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_IP_NUMBER_OF_FAILED_ATTEMPTS, '8', SecurityBlockerLoginRealmConfigurationTransfer::IP_CHALLENGE_NUMBER_OF_ATTEMPTS, 8],
            'challenge across all accounts' => [SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_NUMBER_OF_FAILED_ATTEMPTS, '50', SecurityBlockerLoginRealmConfigurationTransfer::GLOBAL_CHALLENGE_NUMBER_OF_ATTEMPTS, 50],
            'challenge time window across all accounts in minutes' => [SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_TIME_WINDOW, '2', SecurityBlockerLoginRealmConfigurationTransfer::GLOBAL_TTL, 120],
        ];
    }

    /**
     * @param array<string, string> $storedValues
     */
    protected function createClientWithBackOfficeSettings(array $storedValues): SecurityBlockerBackofficeClient
    {
        $securityBlockerBackofficeFactory = new SecurityBlockerBackofficeFactory();
        $securityBlockerBackofficeFactory->setConfig($this->createConfigWithBackOfficeSettings($storedValues));
        $securityBlockerBackofficeClient = new SecurityBlockerBackofficeClient();
        $securityBlockerBackofficeClient->setFactory($securityBlockerBackofficeFactory);

        return $securityBlockerBackofficeClient;
    }

    /**
     * @param array<string, string> $storedValues
     */
    protected function createConfigWithBackOfficeSettings(array $storedValues): ClientSecurityBlockerBackofficeConfig
    {
        return new class ($storedValues) extends ClientSecurityBlockerBackofficeConfig {
            /**
             * @param array<string, string> $storedValues
             */
            public function __construct(protected array $storedValues)
            {
            }

            /**
             * @param mixed|null $default
             * @param array<\Generated\Shared\Transfer\ConfigurationScopeTransfer> $configurationScopes
             */
            protected function getModuleConfig(string $key, $default = null, array $configurationScopes = []): mixed
            {
                return $this->storedValues[$key] ?? $default;
            }
        };
    }
}
