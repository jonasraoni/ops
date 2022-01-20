<?php

/**
 * @file plugins/importexport/native/NativeImportExportDeployment.inc.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2000-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class NativeImportExportDeployment
 * @ingroup plugins_importexport_native
 *
 * @brief Class configuring the native import/export process to this
 * application's specifics.
 */

import('lib.pkp.plugins.importexport.native.PKPNativeImportExportDeployment');

class NativeImportExportDeployment extends PKPNativeImportExportDeployment {

	//
	// Deployment items for subclasses to override
	//
	/**
	 * Get the submission node name
	 * @return string
	 */
	function getSubmissionNodeName() {
		return 'preprint';
	}

	/**
	 * Get the submissions node name
	 * @return string
	 */
	function getSubmissionsNodeName() {
		return 'preprints';
	}

	/**
	 * Get the representation node name
	 */
	function getRepresentationNodeName() {
		return 'preprint_galley';
	}

	/**
	 * Get the schema filename.
	 * @return string
	 */
	function getSchemaFilename() {
		return 'native.xsd';
	}

	/**
	 * @see PKPNativeImportExportDeployment::getObjectTypes()
	 */
	protected function getObjectTypes() {
		$objectTypes = parent::getObjectTypes();
		AppLocale::requireComponents(LOCALE_COMPONENT_APP_EDITOR);
		$objectTypes = $objectTypes + array(
				ASSOC_TYPE_JOURNAL => __('context.context'),
				ASSOC_TYPE_SECTION => __('section.section'),
				ASSOC_TYPE_PUBLICATION => __('common.publication'),
		);

		return $objectTypes;
	}
}


