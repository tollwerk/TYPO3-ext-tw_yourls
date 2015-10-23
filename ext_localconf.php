<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Register 'Yourls' frontend plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Tollwerk.' . $_EXTKEY,
	'Yourls',
	array(
		'Yourls' => 'shorturl',
	),
	array(
		'Yourls' => 'shorturl'
	)
);

// Enables eID calls for the YOURLS requests (like /index.php?eID=yourls)
 $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['yourls'] = 'EXT:tw_yourls/Classes/Eid/Yourls.php';