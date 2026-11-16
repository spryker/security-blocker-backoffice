<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SecurityBlockerBackoffice\Expander;

use Spryker\Client\SecurityBlockerBackoffice\SecurityBlockerBackofficeConfig;

class UserLoginRealmConfigurationExpander implements UserLoginRealmConfigurationExpanderInterface
{
    public function __construct(protected SecurityBlockerBackofficeConfig $securityBlockerBackofficeConfig)
    {
    }

    /**
     * @param array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer> $securityBlockerLoginRealmConfigurationTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer>
     */
    public function expand(array $securityBlockerLoginRealmConfigurationTransfers): array
    {
        $securityBlockerLoginRealmConfigurationTransfer = $this->securityBlockerBackofficeConfig->getUserLoginRealmConfiguration();
        $securityBlockerLoginRealmConfigurationTransfers[$securityBlockerLoginRealmConfigurationTransfer->getRealmOrFail()] = $securityBlockerLoginRealmConfigurationTransfer;

        return $securityBlockerLoginRealmConfigurationTransfers;
    }
}
