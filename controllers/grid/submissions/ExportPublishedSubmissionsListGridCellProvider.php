<?php

/**
 * @file controllers/grid/submissions/ExportPublishedSubmissionsListGridCellProvider.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2000-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class ExportPublishedSubmissionsListGridCellProvider
 * @ingroup controllers_grid_submissions
 *
 * @brief Class for a cell provider that can retrieve labels from submissions
 */

namespace APP\controllers\grid\submissions;

use APP\facades\Repo;
use PKP\controllers\grid\DataObjectGridCellProvider;
use PKP\controllers\grid\GridHandler;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\RedirectAction;

class ExportPublishedSubmissionsListGridCellProvider extends DataObjectGridCellProvider
{
    /** @var ImportExportPlugin */
    public $_plugin;

    public $_authorizedRoles;

    public $_titleColumn;

    /**
     * Constructor
     *
     * @param null|mixed $authorizedRoles
     */
    public function __construct($plugin, $authorizedRoles = null)
    {
        $this->_plugin = $plugin;
        if ($authorizedRoles) {
            $this->_authorizedRoles = $authorizedRoles;
        }
        parent::__construct();
    }

    //
    // Template methods from GridCellProvider
    //
    /**
     * Get cell actions associated with this row/column combination
     *
     * @copydoc GridCellProvider::getCellActions()
     */
    public function getCellActions($request, $row, $column, $position = GridHandler::GRID_ACTION_POSITION_DEFAULT)
    {
        $submission = $row->getData();
        $columnId = $column->getId();
        assert($submission instanceof \APP\submission\Submission && !empty($columnId));

        switch ($columnId) {
            case 'title':
                $this->_titleColumn = $column;
                $title = $submission->getCurrentPublication()->getLocalizedTitle(null, 'html');
                if (empty($title)) {
                    $title = __('common.untitled');
                }
                $authorsInTitle = $submission->getCurrentPublication()->getShortAuthorString();
                $title = $authorsInTitle . '; ' . $title;
                return [
                    new LinkAction(
                        'itemWorkflow',
                        new RedirectAction(
                            Repo::submission()->getWorkflowUrlByUserRoles($submission)
                        ),
                        htmlspecialchars($title)
                    )
                ];
            case 'status':
                $status = $submission->getData($this->_plugin->getDepositStatusSettingName());
                $statusNames = $this->_plugin->getStatusNames();
                $statusActions = $this->_plugin->getStatusActions($submission);
                if ($status && array_key_exists($status, $statusActions)) {
                    assert(array_key_exists($status, $statusNames));
                    return [$statusActions[$status]];
                }
        }
        return parent::getCellActions($request, $row, $column, $position);
    }

    /**
     * Extracts variables for a given column from a data element
     * so that they may be assigned to template before rendering.
     *
     * @copydoc DataObjectGridCellProvider::getTemplateVarsFromRowColumn()
     */
    public function getTemplateVarsFromRowColumn($row, $column)
    {
        $submission = $row->getData();
        $columnId = $column->getId();
        assert($submission instanceof \APP\submission\Submission && !empty($columnId));

        switch ($columnId) {
            case 'id':
                return ['label' => $submission->getId()];
            case 'title':
                return ['label' => ''];
            case 'status':
                $status = $submission->getData($this->_plugin->getDepositStatusSettingName());
                $statusNames = $this->_plugin->getStatusNames();
                $statusActions = $this->_plugin->getStatusActions($submission);
                if ($status) {
                    if (array_key_exists($status, $statusActions)) {
                        $label = '';
                    } else {
                        assert(array_key_exists($status, $statusNames));
                        $label = $statusNames[$status];
                    }
                } else {
                    $label = $statusNames[EXPORT_STATUS_NOT_DEPOSITED];
                }
                return ['label' => $label];
        }
    }
}
