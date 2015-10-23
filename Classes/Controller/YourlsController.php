<?php
namespace Tollwerk\TwYourls\Controller;

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

/**
 * YOURLS controller
 */
class YourlsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

	/**
	 * Create and / or return a short URL
	 *
	 * @param string $url			Full URL
	 * @param string $keyword		Optional: Keyword
	 * @param string $title			Optional: Title
	 * @return string				Short URL
	 */
	public function shorturlAction($url, $keyword = '', $title = '')
	{
		// If URL shortening is enabled
		if ($this->settings['enabled']) {
			$yourlsClient	= new \Tollwerk\TwYourls\Utility\Yourls($this->settings['host'], $this->settings['user'], $this->settings['password']);
			$url			= $yourlsClient->shorturl($url, $keyword, $title);
		}

		return $url;
	}
}

