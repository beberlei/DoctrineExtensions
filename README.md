DoctrineExtensions
==================

[![Build Status](https://img.shields.io/badge/branch-master-blue.svg)](https://github.com/beberlei/DoctrineExtensions/tree/master)
[![Build Status](https://travis-ci.org/beberlei/DoctrineExtensions.svg?branch=master)](https://travis-ci.org/beberlei/DoctrineExtensions)
[![Build Status](https://img.shields.io/badge/version-0.3-orange.svg)](https://github.com/beberlei/DoctrineExtensions/tree/0.3)
[![Travis branch](https://img.shields.io/travis/beberlei/DoctrineExtensions/0.3.svg)](https://travis-ci.org/beberlei/DoctrineExtensions)
[![Build Status](https://img.shields.io/badge/version-1.0-orange.svg)](https://github.com/beberlei/DoctrineExtensions/tree/1.0)
[![Travis branch](https://img.shields.io/travis/beberlei/DoctrineExtensions/1.0.svg)](https://travis-ci.org/beberlei/DoctrineExtensions)

[![Packagist](https://img.shields.io/packagist/dd/beberlei/DoctrineExtensions.svg)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/dm/beberlei/DoctrineExtensions.svg)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/dt/beberlei/DoctrineExtensions.svg)](https://packagist.org/packages/beberlei/DoctrineExtensions)

This package contains several extensions to Doctrine 2 that hook into the facilities of Doctrine and
offer new functionality or tools to use Doctrine 2 more efficently.


Installation
------------

To include the DoctrineExtensions you should fire up an autoloader, for example:

```php
<?php

$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', '/path/to/extensions');
$classLoader->register();
```

You can find an example configuration for using the addition MySQL functions in
Symfony2 in [mysql.yml](mysql.yml)


Legacy verisons
---------------

If you're still using Paginator, LargeCollections, Phing, PHPUnit or Versionable
behaviours available in `0.1`–`0.2`, you're welcome to use `0.3`, which brings
in a bunch of merges from various PR's over the years – but do note, **this
functionality is now available in Doctrine core, no longer supported in this
library, and was removed in 1.0**.

Whilst pull requests for bugfixes to this functionality will be considered for
0.x releases, you are encouraged to switch out your implementations and upgrade
to ~1.0.
