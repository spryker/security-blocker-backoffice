<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SecurityBlockerBackoffice\Plugin\SecurityBlocker;

use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SecurityBlockerExtension\Dependency\Plugin\SecurityBlockerLoginRealmConfigurationExpanderPluginInterface;

/**
 * @method \Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeFactory getFactory()
 * @method \Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeConfig getConfig()
 * @method \Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeClientInterface getClient()
 */
class UserSecurityBlockerLoginRealmConfigurationExpanderPlugin extends AbstractPlugin implements SecurityBlockerLoginRealmConfigurationExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands the login realm configurations with the user realm, which every login surface of a user shares:
     *   Back Office, Merchant Portal, Merchant Portal agent, Yves agent and Backend API.
     *
     * @api
     *
     * @param array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer> $securityBlockerLoginRealmConfigurationTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer>
     */
    public function expand(array $securityBlockerLoginRealmConfigurationTransfers): array
    {
        return $this->getClient()
            ->expandSecurityBlockerLoginRealmConfigurationsWithUserLoginRealmConfiguration($securityBlockerLoginRealmConfigurationTransfers);
    }
}
