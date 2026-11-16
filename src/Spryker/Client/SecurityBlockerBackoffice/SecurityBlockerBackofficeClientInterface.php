<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SecurityBlockerBackoffice;

interface SecurityBlockerBackofficeClientInterface
{
    /**
     * Specification:
     * - Expands security blocker configuration settings with Backoffice user security configuration.
     *
     * @api
     *
     * @param array<string, \Generated\Shared\Transfer\SecurityBlockerConfigurationSettingsTransfer> $securityBlockerConfigurationSettingsTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\SecurityBlockerConfigurationSettingsTransfer>
     */
    public function expandSecurityBlockerConfigurationsWithBackofficeUserConfiguration(array $securityBlockerConfigurationSettingsTransfers): array;

    /**
     * Specification:
     * - Expands the login realm configurations with the user realm, indexed by `SecurityBlockerBackofficeConfig::LOGIN_REALM_USER`.
     * - Takes the thresholds from `SecurityBlockerBackofficeConfig::getUserLoginRealmConfiguration()`.
     *
     * @api
     *
     * @param array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer> $securityBlockerLoginRealmConfigurationTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer>
     */
    public function expandSecurityBlockerLoginRealmConfigurationsWithUserLoginRealmConfiguration(array $securityBlockerLoginRealmConfigurationTransfers): array;
}
