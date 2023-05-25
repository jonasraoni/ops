<?php

/**
 * @file classes/migration/upgrade/v3_4_0/I8929_AddForeignKeys.php
 *
 * Copyright (c) 2023 Simon Fraser University
 * Copyright (c) 2023 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class I8929_AddForeignKeys
 *
 * @brief Describe upgrade/downgrade operations for introducing foreign key definitions to existing database relationships.
 */

namespace APP\migration\upgrade\v3_4_0;

class I8929_AddForeignKeys extends \PKP\migration\upgrade\v3_4_0\I8929_AddForeignKeys
{
    protected function getContextTable(): string
    {
        return 'servers';
    }

    protected function getContextKeyField(): string
    {
        return 'server_id';
    }

    protected function getContextSettingsTable(): string
    {
        return 'server_settings';
    }
}
