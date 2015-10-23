<?php

namespace Tollwerk\TwYourls\Utility;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Joschi Kuphal <joschi@tollwerk.de>, tollwerk GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * YOULRS client feature
 *
 * @package        tw_yourls
 */
class Yourls
{

	/**
	 * configuration
	 *
	 * @var \array
	 */
	protected $_configuration;

	/**
	 * bootstrap
	 *
	 * @var \TYPO3\CMS\Extbase\Core\Bootstrap
	 */
	protected $_bootstrap;

	/**
	 * Generates the output
	 *
	 * @return \string        from action
	 */
	public function run()
	{
		return $this->_bootstrap->run('', $this->_configuration);
	}

	/**
	 * Constructor
	 *
	 * Initialize the frontendn engine and Extbase
	 */
	public function __construct()
	{
		// Initialize the frontend engine
		$this->_initTSFE();

		/** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

		/** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
		$configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');

		// Initialize the Extbase configuration
		$this->_configuration = array(
			'pluginName' => 'Yourls',
			'vendorName' => 'Tollwerk',
			'extensionName' => 'TwYourls',
			'controller' => 'Yourls',
			'action' => 'shorturl',
			'mvc' => array(
				'requestHandlers' => array(
					'TYPO3\CMS\Extbase\Mvc\Web\FrontendRequestHandler' => 'TYPO3\CMS\Extbase\Mvc\Web\FrontendRequestHandler'
				)
			),
			'settings' => $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
				'TwYourls', 'Yourls')
		);

		$_POST['tx_twyourls_yourls']['action'] = 'shorturl'; // set action
		$_POST['tx_twyourls_yourls']['controller'] = 'Yourls'; // set controller

		$this->_bootstrap = new \TYPO3\CMS\Extbase\Core\Bootstrap();
	}

	/**
	 * Initialize a frontend engine
	 */
	protected function _initTSFE()
	{
		$GLOBALS['TSFE'] = $tsfe = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController',
			$GLOBALS['TYPO3_CONF_VARS'], GeneralUtility::_GP('id') ?: 1, '');
		/** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $tsfe */
		$tsfe->connectToDB();
		$tsfe->initFEuser();
		\TYPO3\CMS\Core\Core\Bootstrap::getInstance()->loadCachedTca();
		$tsfe->determineId();
		$tsfe->initTemplate();
		$tsfe->getConfigArray();
		// Get linkVars, absRefPrefix, etc
		\TYPO3\CMS\Frontend\Page\PageGenerator::pagegenInit();
	}
}

echo GeneralUtility::makeInstance('Tollwerk\\TwYourls\\Utility\\Yourls')->run();
