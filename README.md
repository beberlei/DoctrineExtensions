DoctrineExtensions
==================

[![Build Status](https://img.shields.io/badge/branch-master-blue.svg)](https://github.com/Dukecity/DoctrineExtensions/tree/master)
[![Build Status](https://github.com/Dukecity/DoctrineExtensions/workflows/Tests/badge.svg)](https://github.com/Dukecity/DoctrineExtensions/actions)
[![Packagist](https://img.shields.io/packagist/v/Dukecity/doctrineextensions.svg?label=stable)](https://packagist.org/packages/Dukecity/doctrineextensions)
[![Packagist](https://img.shields.io/packagist/dd/Dukecity/doctrineextensions.svg?label=⬇)](https://packagist.org/packages/Dukecity/doctrineextensions)
[![Packagist](https://img.shields.io/packagist/dm/Dukecity/doctrineextensions.svg?label=⬇)](https://packagist.org/packages/Dukecity/doctrineextensions)
[![Packagist](https://img.shields.io/packagist/dt/Dukecity/doctrineextensions.svg?label=⬇)](https://packagist.org/packages/Dukecity/doctrineextensions)

A set of extensions to Doctrine 2 that add support for functions available in
MySQL, Oracle, PostgreSQL and SQLite.

| DB | Functions |
|:--:|:---------:|
| MySQL | `ACOS, ADDTIME, AES_DECRYPT, AES_ENCRYPT, ANY_VALUE, ASCII, ASIN, ATAN, ATAN2, BINARY, BIT_COUNT, BIT_XOR, CAST, CEIL, CHAR_LENGTH, COLLATE, CONCAT_WS, CONV, CONVERT_TZ, COS, COT, COUNTIF, CRC32, DATE, DATE_FORMAT, DATEADD, DATEDIFF, DATESUB, DAY, DAYNAME, DAYOFWEEK, DAYOFYEAR, DEGREES, DIV, EXP, EXTRACT, FIELD, FIND_IN_SET, FLOOR, FORMAT, FROM_BASE64, FROM_UNIXTIME, GREATEST, GROUP_CONCAT, HEX, HOUR, IFELSE, IFNULL, INET_ATON, INET_NTOA, INET6_ATON, INET6_NTOA, INSTR, IS_IPV4, IS_IPV4_COMPAT, IS_IPV4_MAPPED, IS_IPV6, JSON_CONTAINS, JSON_DEPTH, JSON_LENGTH, LAG, LAST_DAY, LAST_INSERT_ID, LEAD, LEAST, LOG, LOG10, LOG2, LPAD, MAKEDATE, MATCH, MD5, MINUTE, MONTH, MONTHNAME, NOW, NULLIF, OVER, PERIOD_DIFF, PI, POWER, QUARTER, RADIANS, RAND, REGEXP, REGEXP_REPLACE, REPLACE, ROUND, RPAD, SECOND, SECTOTIME, SHA1, SHA2, SIN, SOUNDEX, STD, STDDEV, STRTODATE, STR_TO_DATE, SUBSTRING_INDEX, TAN, TIME, TIMEDIFF, TIMESTAMPADD, TIMESTAMPDIFF, TIMETOSEC, TRUNCATE, UNHEX, UNIX_TIMESTAMP, UTC_TIMESTAMP, UUID_SHORT, VARIANCE, WEEK, WEEKDAY, WEEKOFYEAR, YEAR, YEARMONTH, YEARWEEK` |
| Oracle | `CEIL, DAY, FLOOR, HOUR, LISTAGG, MINUTE, MONTH, NVL, SECOND, TO_CHAR, TO_DATE, TRUNC, YEAR` |
| SQLite | `CASE WHEN THEN ELSE END, DATE, DATE_FORMAT*, DAY, HOUR, IFNULL, JULIANDAY, MINUTE, MONTH, REPLACE, ROUND, SECOND, STRFTIME, WEEK, WEEKDAY, YEAR` |
| PostgreSQL | `AGE, AT_TIME_ZONE, COUNT_FILTER, DATE, DATE_PART, DATE_TRUNC, DAY, EXTRACT, GREATEST, HOUR, ILIKE, LEAST, MINUTE, MONTH, QUARTER, REGEXP_REPLACE, SECOND, STRING_AGG, TO_CHAR, TO_DATE, YEAR` |

> Note: SQLite date functions are implemented as `strftime(format, value)`.
  SQLite only supports the [most common formats](https://www.sqlite.org/lang_datefunc.html),
  so `date_format` will convert the mysql substitutions to the closest available SQLite substitutions.
  This means `date_format(field, '%b %D %Y') -> Jan 1st 2023` becomes `strftime('%m %d %Y', field) -> 01 01 2023`.

Installation
------------

To install this library, run the command below and you will get the latest
version:

```sh
composer require beberlei/doctrineextensions
```

If you want to run phpunit:

```sh
composer run test
```

If you want to run php-cs-fixer:

```sh
composer run lint
```

Usage
-----

If you are using DoctrineExtensions with Symfony read [How to Register custom DQL Functions](https://symfony.com/doc/current/doctrine/custom_dql_functions.html).

You can find example Symfony configuration for using DoctrineExtensions custom DQL functions in [config](config).

If you are using DoctrineExtensions standalone, you might want to fire up the autoloader:

```php
<?php

$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', '/path/to/extensions');
$classLoader->register();
```
For more information check out the documentation of [Doctrine DQL User Defined Functions](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/dql-user-defined-functions.html).

Notes
-----

- MySQL `DATE_ADD` is available in DQL as `DATEADD(CURRENT_DATE(), 1, 'DAY')`
- MySQL `DATE_SUB` is available in DQL as `DATESUB(CURRENT_DATE(), 1, 'DAY')`
- MySQL `IF` is available in DQL as `IFELSE(field > 0, 'true', 'false')`

Troubleshooting
---------------

Issues are disabled on this repository, if a custom DQL function that you want isn't provided, or does not support the arguments you want to pass, pull requests are open and we would love to have your contributions.
