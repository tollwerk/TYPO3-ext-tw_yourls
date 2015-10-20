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

/**
 * YOULRS API client
 *
 * @package        tw_yourls
 */
class Yourls
{
	/**
	 * YOURLS host
	 *
	 * @var string
	 */
	protected $_host;

	/**
	 * YOURLS user
	 *
	 * @var string
	 */
	protected $_user;

	/**
	 * YOURLS password
	 *
	 * @var string
	 */
	protected $_password;
	/**
	 * YOURLS API URL
	 *
	 * string @var
	 */
	protected $_apiUrl;

	/**
	 * Constructor
	 *
	 * @param string $host
	 * @param string $user
	 * @param string $password
	 */
	public function __construct($host, $user, $password)
	{
		$this->_host = rtrim(trim($host), '/');
		$this->_user = trim($user);
		$this->_password = trim($password);

		if (!strlen($this->_host) || !preg_match("%^https?\:\/\/%i", $this->_host)) {
			throw new \InvalidArgumentException(sprintf('Invalid YOURLS host "%s"', $this->_host));
		}
		if (!strlen($this->_user) || !strlen($this->_password)) {
			$this->_user = $this->_password = '';
		}

		$this->_apiUrl = $this->_host . '/yourls-api.php';
	}

	/**
	 * Create and / or return a short URL
	 *
	 * @param string $url			Full URL
	 * @param string $keyword		Optional: Keyword
	 * @param string $title			Optional: Title
	 * @return object				Result
	 */
	public function shorturl($url, $keyword = '', $title = '')
	{
		try {
			$result = $this->_post(array(
				'url' => trim($url),
				'keyword' => trim($keyword),
				'title' => trim($title),
				'action' => 'shorturl',
			));

			if (is_object($result) && isset($result->statusCode) && (intval($result->statusCode) == 200) && isset($result->shorturl)) {
				return $result->shorturl;
			}

		} catch(\Exception $e) {}

		return $url;
	}

	/**
	 * Post a request to the YOURLS API
	 *
	 * @param array $params Parameters
	 * @return object                Result
	 */
	protected function _post(array $params)
	{
		if (empty($params['action'])) {
			throw new \InvalidArgumentException(sprintf('Invalid YOURLS API action "%s"', $params['action']));
		}

		$params['format'] = 'json';
		$params['username'] = $this->_user;
		$params['password'] = $this->_password;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_apiUrl);
		curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result
		curl_setopt($ch, CURLOPT_POST, 1);              // This is a POST request
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

		$data = curl_exec($ch);
		curl_close($ch);

		if (!curl_errno($ch)) {
			return @json_decode($data);
		} else {
			throw new \RuntimeException(curl_error($ch));
		}
	}
}