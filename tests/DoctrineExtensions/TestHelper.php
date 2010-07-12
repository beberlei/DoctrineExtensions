<?php

if (!isset($GLOBALS['doctrine2-path'])) {
    throw new InvalidArgumentException('Global variable "doctrine2-path" has to be set in phpunit.xml');
}

$loaderfile = $GLOBALS['doctrine2-path']."/vendor/doctrine-common/lib/Doctrine/Common/ClassLoader.php";
if (!file_exists($loaderfile)) {
    throw new InvalidArgumentException('Could not include Doctrine\Common\ClassLoader from "doctrine2-path".');
}
require_once($loaderfile);

$loader = new Doctrine\Common\ClassLoader("Doctrine\Common", $GLOBALS['doctrine2-path'] . "/vendor/doctrine-common/lib/");
$loader->register();

$loader = new Doctrine\Common\ClassLoader("Doctrine\DBAL", $GLOBALS['doctrine2-path'] . "/vendor/doctrine-dbal/lib/");
$loader->register();

$loader = new Doctrine\Common\ClassLoader("Doctrine\ORM", $GLOBALS['doctrine2-path']);
$loader->register();

$loader = new Doctrine\Common\ClassLoader("DoctrineExtensions", __DIR__."/../../lib");
$loader->register();
