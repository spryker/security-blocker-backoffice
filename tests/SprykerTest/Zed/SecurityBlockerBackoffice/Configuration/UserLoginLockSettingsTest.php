<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\SecurityBlockerBackoffice\Configuration;

use Codeception\Test\Unit;
use Spryker\Shared\SecurityBlockerBackoffice\SecurityBlockerBackofficeConfig;
use SprykerTest\Zed\SecurityBlockerBackoffice\SecurityBlockerBackofficeConfigurationTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group SecurityBlockerBackoffice
 * @group Configuration
 * @group UserLoginLockSettingsTest
 * Add your own group annotations below this line
 */
class UserLoginLockSettingsTest extends Unit
{
    /**
     * @var array<string, array{default: string, valid: list<string>, invalid: list<string>}>
     */
    protected const array LOGIN_LOCK_SETTINGS = [
        SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_NUMBER_OF_FAILED_ATTEMPTS => ['default' => '9', 'valid' => ['1', '9', '100'], 'invalid' => ['0', '101', '-1', '2.5', 'abc', '']],
        SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_COUNTING_WINDOW => ['default' => '15', 'valid' => ['1', '15', '1440'], 'invalid' => ['0', '1441', 'abc', '']],
        SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_DURATION => ['default' => '6', 'valid' => ['1', '6', '1440'], 'invalid' => ['0', '1441', 'abc', '']],
        SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_ACCOUNT_NUMBER_OF_FAILED_ATTEMPTS => ['default' => '3', 'valid' => ['1', '3', '10'], 'invalid' => ['0', '11', '-1', '3.5', 'abc', '']],
        SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_IP_NUMBER_OF_FAILED_ATTEMPTS => ['default' => '5', 'valid' => ['0', '5', '1000'], 'invalid' => ['1001', '-1', '2.5', 'abc', '']],
        SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_NUMBER_OF_FAILED_ATTEMPTS => ['default' => '30', 'valid' => ['0', '30', '100000'], 'invalid' => ['100001', '-1', 'abc', '']],
        SecurityBlockerBackofficeConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_TIME_WINDOW => ['default' => '5', 'valid' => ['1', '5', '60'], 'invalid' => ['0', '61', 'abc', '']],
    ];

    protected SecurityBlockerBackofficeConfigurationTester $tester;

    /**
     * The settings page holds only the open tab, so no Login Lock setting can depend on the CAPTCHA switch of the CAPTCHA tab.
     *
     * @dataProvider provideLoginLockSettingKeys
     */
    public function testLoginLockSettingIsAlwaysShown(string $settingKey): void
    {
        // Act
        $dependencies = $this->tester->findConfigurationSettingDependencies($settingKey);

        // Assert
        $this->assertSame([], $dependencies);
    }

    /**
     * @dataProvider provideLoginLockSettingDefaults
     */
    public function testLoginLockSettingHasItsDefaultWhenNothingIsStored(string $settingKey, string $expectedValue): void
    {
        // Arrange
        $this->tester->haveNoStoredGlobalConfigurationValue($settingKey);

        // Act
        $value = $this->tester->getConfigurationValue($settingKey);

        // Assert
        $this->assertSame($expectedValue, (string)$value);
    }

    /**
     * @dataProvider provideValidLoginLockSettingValues
     */
    public function testLoginLockSettingAcceptsAWholeNumberInItsRange(string $settingKey, string $value): void
    {
        // Act
        $configurationValueCollectionResponseTransfer = $this->tester->saveGlobalConfigurationValue($settingKey, $value);

        // Assert
        $this->assertTrue($configurationValueCollectionResponseTransfer->getIsSuccess());
        $this->assertSame($value, (string)$this->tester->getConfigurationValue($settingKey));
    }

    /**
     * @dataProvider provideInvalidLoginLockSettingValues
     */
    public function testLoginLockSettingRejectsAnythingButAWholeNumberInItsRange(string $settingKey, string $value): void
    {
        // Act
        $configurationValueCollectionResponseTransfer = $this->tester->saveGlobalConfigurationValue($settingKey, $value);

        // Assert
        $this->assertFalse($configurationValueCollectionResponseTransfer->getIsSuccess());
        $this->assertSame(0, $configurationValueCollectionResponseTransfer->getSavedCount());
        $this->assertNotCount(0, $configurationValueCollectionResponseTransfer->getErrors());
    }

    /**
     * @return array<string, array<string>>
     */
    public function provideLoginLockSettingKeys(): array
    {
        $settingKeys = [];

        foreach (array_keys(static::LOGIN_LOCK_SETTINGS) as $settingKey) {
            $settingKeys[$settingKey] = [$settingKey];
        }

        return $settingKeys;
    }

    /**
     * @return array<string, array<string>>
     */
    public function provideLoginLockSettingDefaults(): array
    {
        $defaults = [];

        foreach (static::LOGIN_LOCK_SETTINGS as $settingKey => $settingCases) {
            $defaults[$settingKey] = [$settingKey, $settingCases['default']];
        }

        return $defaults;
    }

    /**
     * @return array<string, array<string>>
     */
    public function provideValidLoginLockSettingValues(): array
    {
        return $this->combineWithSettingKeys('valid');
    }

    /**
     * @return array<string, array<string>>
     */
    public function provideInvalidLoginLockSettingValues(): array
    {
        return $this->combineWithSettingKeys('invalid');
    }

    /**
     * @return array<string, array<string>>
     */
    protected function combineWithSettingKeys(string $casesKey): array
    {
        $cases = [];

        foreach (static::LOGIN_LOCK_SETTINGS as $settingKey => $settingCases) {
            foreach ($settingCases[$casesKey] as $value) {
                $cases[sprintf('%s: "%s"', $settingKey, $value)] = [$settingKey, $value];
            }
        }

        return $cases;
    }
}
