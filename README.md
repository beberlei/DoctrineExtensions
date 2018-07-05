DoctrineExtensions
==================

[![Build Status](https://img.shields.io/badge/branch-master-blue.svg)](https://github.com/beberlei/DoctrineExtensions/tree/master)
[![Build Status](https://travis-ci.org/beberlei/DoctrineExtensions.svg?branch=master)](https://travis-ci.org/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/v/beberlei/DoctrineExtensions.svg?label=stable)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/dd/beberlei/DoctrineExtensions.svg?label=⬇)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/dm/beberlei/DoctrineExtensions.svg?label=⬇)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/dt/beberlei/DoctrineExtensions.svg?label=⬇)](https://packagist.org/packages/beberlei/DoctrineExtensions)

A set of extensions to Doctrine 2 that add support for functions available in
MySQL, Oracle, PostgreSQL and SQLite.

| DB | Functions |
|:--:|:---------:|
| MySQL | `ACOS, AES_DECRYPT, AES_ENCRYPT, ANY_VALUE, ASCII, ASIN, ATAN, ATAN2, BINARY, BIT_COUNT, BIT_XOR, CAST, CEIL, CHAR_LENGTH, COLLATE, CONCAT_WS, CONVERT_TZ, COS, COT, COUNTIF, CRC32, DATE, DATE_FORMAT, DATEADD, DATEDIFF, DATESUB, DAY, DAYNAME, DAYOFWEEK, DAYOFYEAR, DEGREES, DIV, EXP, EXTRACT, FIELD, FIND_IN_SET, FLOOR, FROM_UNIXTIME, GREATEST, GROUP_CONCAT, HEX, HOUR, IFELSE, IFNULL, INET_ATON, INSTR, LAST_DAY, LEAST, LOG, LOG10, LOG2, LPAD, MATCH, MD5, MINUTE, MONTH, MONTHNAME, NOW, NULLIF, PERIOD_DIFF, PI, POWER, QUARTER, RADIANS, RAND, REGEXP, REPLACE, ROUND, RPAD, SECOND, SECTOTIME, SHA1, SHA2, SIN, SOUNDEX, STD, STDDEV, STRTODATE, STR_TO_DATE, SUBSTRING_INDEX, TAN, TIME, TIMEDIFF, TIMESTAMPADD, TIMESTAMPDIFF, TIMETOSEC, UNHEX, UNIX_TIMESTAMP, UTC_TIMESTAMP, UUID_SHORT, VARIANCE, WEEK, WEEKDAY, YEAR, YEARMONTH, YEARWEEK` |
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

```
composer require beberlei/DoctrineExtensions
```

If you want to run phpunit:

```
make test
```

If you want to run php-cs-fixer:

```
make fix  # (or make lint for a dry-run)
```

To include the DoctrineExtensions you should fire up an autoloader, for example:

```php
<?php

$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', '/path/to/extensions');
$classLoader->register();
```

You can find an example Symfony configuration for using the additional MySQL
functions in [config/mysql.yml](config/mysql.yml).
