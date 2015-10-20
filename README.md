TYPO3 extension tw_yourls
===============================

Simple API client for the [YOURLS URL Shortener](http://yourls.org). 


Documentation
-------------

Sorry, no real documentation yet, but the usage is very simple. Please ensure to have [a working YOURLS installation](http://yourls.org/#Install) before you try to configure and use the extension.

* Install the extension (GitHub only at the moment, no TER release yet)
* Add the extension's TypoScript to your main template
* Edit the extension's constants in the constant editor
	* YOURLS host
	* YOURLS API username
	* YOURLS API password
* Make a request to your frontend using `type=1920` and providing the URL to be shortened as parameter `tx_twyourls[url]`, e.g.
  
```
http://example.com/index.php?type=1920&tx_twyourls[url]=http%3A%2F%2Fexample.com
```

* You may optionally pass the parameters `tx_twyourls[title]` and `tx_twyourls[keyword]` (see the [`shorturl` YOURLS documentation](http://yourls.org/#apiusage)).
* The request will return the shortened URL (or the original URL in case of an error)

Requirements
------------

* So far tested with TYPO3 CMS 7.4 only, but should probably work with other versions too


Release history
---------------

#### v0.1.0
*	Initial release 

Legal
-----

Copyright © 2015 tollwerk® GmbH / Joschi Kuphal <joschi@tollwerk.de> / [@jkphl](https://twitter.com/jkphl).
Licensed under the terms of the MIT license.