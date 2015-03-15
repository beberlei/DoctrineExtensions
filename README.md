DoctrineExtensions
==================

[![Build Status](https://img.shields.io/badge/branch-master-blue.svg)](https://github.com/beberlei/DoctrineExtensions/tree/master)
[![Build Status](https://travis-ci.org/beberlei/DoctrineExtensions.svg?branch=master)](https://travis-ci.org/beberlei/DoctrineExtensions)
[![Build Status](https://img.shields.io/badge/version-1.0-orange.svg)](https://github.com/beberlei/DoctrineExtensions/tree/1.0)
[![Travis branch](https://img.shields.io/travis/beberlei/DoctrineExtensions/1.0.svg)](https://travis-ci.org/beberlei/DoctrineExtensions)
[![Build Status](https://img.shields.io/badge/version-0.3-orange.svg)](https://github.com/beberlei/DoctrineExtensions/tree/0.3)
[![Travis branch](https://img.shields.io/travis/beberlei/DoctrineExtensions/0.3.svg)](https://travis-ci.org/beberlei/DoctrineExtensions)

[![Packagist](https://img.shields.io/packagist/v/beberlei/DoctrineExtensions.svg?label=stable)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/vpre/beberlei/DoctrineExtensions.svg?label=unstable)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/dd/beberlei/DoctrineExtensions.svg?label=⬇)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/dm/beberlei/DoctrineExtensions.svg?label=⬇)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/dt/beberlei/DoctrineExtensions.svg?label=⬇)](https://packagist.org/packages/beberlei/DoctrineExtensions)

A set of extensions to Doctrine 2 that add support for additional query
functions available in MySQL and Oracle.

| DB | Functions |
|:--:|:---------:|
| MySQL | `ACOS, ASIN, ATAN, ATAN2, BINARY, CHAR_LENGTH, CONCAT_WS, COS, COT, COUNTIF, CRC32, DATE, DATE_FORMAT, DATEADD, DATEDIFF, DAY, DAYNAME, DEGREES, FIELD, FIND_IN_SET, GROUP_CONCAT, HOUR, IFELSE, IFNULL, LAST_DAY, MATCH_AGAINST, MD5, MINUTE, MONTH, MONTHNAME, NULLIF, PI, POWER, QUARTER, RADIANS, RAND, REGEXP, REPLACE, ROUND, SECOND, SHA1, SHA2, SIN, SOUNDEX, STD, STRTODATE, TAN, TIME, TIMESTAMPADD, TIMESTAMPDIFF, UUID_SHORT, WEEK, WEEKDAY, YEAR` |
| Oracle | `DAY, MONTH, NVL, TODATE, TRUNC, YEAR` |


Installation
------------

To install this library, run the command below and you will get the latest
version:

```sh
composer require beberlei/DoctrineExtensions
```

If you want to run the tests:

```sh
vendor/bin/phpunit
```

To include the DoctrineExtensions you should fire up an autoloader, for example:

```php
<?php

$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', '/path/to/extensions');
$classLoader->register();
```

You can find an example configuration for using the additional MySQL functions
in Symfony2 in [config/mysql.yml](config/mysql.yml).


Legacy versions
---------------

If you're still using Paginator, LargeCollections, Phing, PHPUnit or Versionable
behaviours available in `0.1`–`0.3`, you're welcome to use `0.3` – but do note,
**this functionality is now available in Doctrine core, no longer supported in
this library, and was removed in 1.0**.

Whilst pull requests for bugfixes to this functionality will be considered for
0.x releases, you are encouraged to switch out your implementations and upgrade
to ~1.0.
