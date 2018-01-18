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
functions available in MySQL, Oracle, Sqlite and PostgreSQL.

| DB | Functions |
|:--:|:---------:|
| MySQL | `ACOS, AES_DECRYPT, AES_ENCRYPT, ANY_VALUE, ASCII, ASIN, ATAN, ATAN2, BINARY, BIT_COUNT, BIT_XOR, CEIL, CHAR_LENGTH, COLLATE, CONCAT_WS, CONVERT_TZ, COS, COT, COUNTIF, CRC32, DATE, DATE_FORMAT, DATEADD, DATEDIFF, DATESUB, DAY, DAYNAME, DAYOFWEEK, DAYOFYEAR, DEGREES, DIV, EXP, EXTRACT, FIELD, FIND_IN_SET, FLOOR, FROM_UNIXTIME, GREATEST, GROUP_CONCAT, HEX, HOUR, IFELSE, IFNULL, INSTR, LAST_DAY, LEAST, LOG, LOG10, LOG2, LPAD, MATCH, MD5, MINUTE, MONTH, MONTHNAME, NOW, NULLIF, PI, POWER, QUARTER, RADIANS, RAND, REGEXP, REPLACE, ROUND, RPAD, SECOND, SECTOTIME, SHA1, SHA2, SIN, SOUNDEX, STD, STDDEV, STRTODATE, STR_TO_DATE, SUBSTRING_INDEX, TAN, TIME, TIMEDIFF, TIMESTAMPADD, TIMESTAMPDIFF, TIMETOSEC, UNHEX, UNIX_TIMESTAMP, UTC_TIMESTAMP, UUID_SHORT, VARIANCE, WEEK, WEEKDAY, YEAR, YEARMONTH, YEARWEEK` |
| Oracle | `DAY, LISTAGG, MONTH, NVL, TO_CHAR, TO_DATE, TRUNC, YEAR` |
| Sqlite | `DATE, MINUTE, HOUR, DAY, WEEK, WEEKDAY, MONTH, YEAR, STRFTIME, DATE_FORMAT*, CASE WHEN THEN ELSE END, IFNULL, REPLACE, ROUND` |
| PostgreSQL | `TO_DATE, TO_CHAR, AT_TIME_ZONE, COUNT_FILTER, STRING_AGG` |

> Note: Sqlite date functions are implemented as `strftime(format, value)`.
  Sqlite only supports the [most common formats](https://www.sqlite.org/lang_datefunc.html),
  so `date_format` will convert the mysql substitutions to the closest available sqlite substitutions.
  This means `date_format(field, '%b %D %Y') -> Jan 1st 2015` becomes `strftime('%m %d %Y', field) -> 01 01 2015`.

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
