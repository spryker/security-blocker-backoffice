<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\SecurityBlockerBackoffice;

use Codeception\Actor;
use Generated\Shared\Transfer\ConfigurationValueCollectionRequestTransfer;
use Generated\Shared\Transfer\ConfigurationValueCollectionResponseTransfer;
use Generated\Shared\Transfer\ConfigurationValueDeletionTransfer;
use Generated\Shared\Transfer\ConfigurationValueRequestTransfer;
use Generated\Shared\Transfer\ConfigurationValueTransfer;
use ReflectionProperty;
use Spryker\Shared\Configuration\Reader\AbstractConfigurationValueResolver;
use Spryker\Zed\Configuration\Business\ConfigurationFacadeInterface;
use Spryker\Zed\Locale\LocaleDependencyProvider;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
 */
class SecurityBlockerBackofficeConfigurationTester extends Actor
{
    use _generated\SecurityBlockerBackofficeConfigurationTesterActions;

    protected const string SCOPE_GLOBAL = 'global';

    protected const string LOCALE_NAME = 'en_US';

    /**
     * A rejected value is answered with a translated message, and the translator reads the current locale.
     */
    public function saveGlobalConfigurationValue(string $settingKey, string $value): ConfigurationValueCollectionResponseTransfer
    {
        $this->resetResolvedConfigurationValueCache();
        $this->setDependency(LocaleDependencyProvider::LOCALE_CURRENT, static::LOCALE_NAME);

        return $this->getConfigurationFacade()->saveConfigurationValues(
            (new ConfigurationValueCollectionRequestTransfer())->addConfigurationValue(
                (new ConfigurationValueTransfer())
                    ->setSettingKey($settingKey)
                    ->setScope(static::SCOPE_GLOBAL)
                    ->setValue($value),
            ),
        );
    }

    public function haveNoStoredGlobalConfigurationValue(string $settingKey): void
    {
        $this->resetResolvedConfigurationValueCache();
        $this->getConfigurationFacade()->saveConfigurationValues(
            (new ConfigurationValueCollectionRequestTransfer())->addDeletionKey(
                (new ConfigurationValueDeletionTransfer())
                    ->setSettingKey($settingKey)
                    ->setScope(static::SCOPE_GLOBAL),
            ),
        );
    }

    public function getConfigurationValue(string $settingKey): mixed
    {
        $this->resetResolvedConfigurationValueCache();

        return $this->getConfigurationFacade()->getConfigurationValue(
            (new ConfigurationValueRequestTransfer())->setKey($settingKey),
        );
    }

    /**
     * @return array<mixed>|null `null` when the setting does not exist.
     */
    public function findConfigurationSettingDependencies(string $settingKey): ?array
    {
        foreach ($this->getConfigurationFacade()->getAllConfigurationSettings() as $configurationSettingTransfer) {
            if ($configurationSettingTransfer->getKey() === $settingKey) {
                return $configurationSettingTransfer->getDependencies();
            }
        }

        return null;
    }

    protected function getConfigurationFacade(): ConfigurationFacadeInterface
    {
        return $this->getLocator()->configuration()->facade();
    }

    /**
     * The resolved values are cached per process and a save does not invalidate them, so without the reset a test reads
     * the value an earlier test of the same run resolved.
     */
    protected function resetResolvedConfigurationValueCache(): void
    {
        (new ReflectionProperty(AbstractConfigurationValueResolver::class, 'resolvedValueCache'))->setValue(null, []);
    }
}
