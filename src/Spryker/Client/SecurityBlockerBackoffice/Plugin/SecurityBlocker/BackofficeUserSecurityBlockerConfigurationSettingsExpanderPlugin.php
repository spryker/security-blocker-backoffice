<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SecurityBlockerBackoffice\Plugin\SecurityBlocker;

use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SecurityBlockerExtension\Dependency\Plugin\SecurityBlockerConfigurationSettingsExpanderPluginInterface;

/**
 * @method \Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeFactory getFactory()
 * @method \Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeConfig getConfig()
 * @method \Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeClientInterface getClient()
 */
class BackofficeUserSecurityBlockerConfigurationSettingsExpanderPlugin extends AbstractPlugin implements SecurityBlockerConfigurationSettingsExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands security blocker configuration settings with Backoffice user security configuration.
     *
     * @api
     *
     * @param array<string, \Generated\Shared\Transfer\SecurityBlockerConfigurationSettingsTransfer> $securityBlockerConfigurationSettingsTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\SecurityBlockerConfigurationSettingsTransfer>
     */
    public function expand(array $securityBlockerConfigurationSettingsTransfers): array
    {
        return $this->getClient()
            ->expandSecurityBlockerConfigurationsWithBackofficeUserConfiguration($securityBlockerConfigurationSettingsTransfers);
    }
}
