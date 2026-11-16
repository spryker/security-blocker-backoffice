<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SecurityBlockerBackoffice;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\SecurityBlockerBackoffice\Expander\BackofficeConfigurationSettingsExpander;
use Spryker\Client\SecurityBlockerBackoffice\Expander\BackofficeConfigurationSettingsExpanderInterface;
use Spryker\Client\SecurityBlockerBackoffice\Expander\UserLoginRealmConfigurationExpander;
use Spryker\Client\SecurityBlockerBackoffice\Expander\UserLoginRealmConfigurationExpanderInterface;

/**
 * @method \Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeConfig getConfig()
 */
class SecurityBlockerBackofficeFactory extends AbstractFactory
{
    public function createBackofficeConfigurationSettingsExpander(): BackofficeConfigurationSettingsExpanderInterface
    {
        return new BackofficeConfigurationSettingsExpander(
            $this->getConfig(),
        );
    }

    public function createUserLoginRealmConfigurationExpander(): UserLoginRealmConfigurationExpanderInterface
    {
        return new UserLoginRealmConfigurationExpander($this->getConfig());
    }
}
