<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTypoScriptSetup('
module.tx_backendtools {
	settings.pagebrowser {
       itemsPerPage         = 25
       insertAbove          = 0
       insertBelow          = 1
       maximumNumberOfLinks = 25
    }
}
');