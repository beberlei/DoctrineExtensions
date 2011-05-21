<?php

use
	Doctrine\Common\ClassLoader,
	Doctrine\Common\Cache,
	Doctrine\ORM\Configuration,
	Doctrine\ORM\EntityManager
;

if (!isset($GLOBALS['doctrine2-path'])) {
    throw new InvalidArgumentException('Global variable "doctrine2-path" has to be set in phpunit.xml');
}

$loaderfile = $GLOBALS['doctrine2-path']."/Doctrine/Common/ClassLoader.php";
if (!file_exists($loaderfile)) {
	throw new InvalidArgumentException('Could not include Doctrine\Common\ClassLoader from "doctrine2-path".');
}
require_once($loaderfile);

$loader = new Doctrine\Common\ClassLoader("Doctrine", $GLOBALS['doctrine2-path']);
$loader->register();

$loader = new Doctrine\Common\ClassLoader("DoctrineExtensions", __DIR__."/../../lib");
$loader->register();

$loader = new Doctrine\Common\ClassLoader("Entities", realpath(__DIR__."/.."));
$loader->register();
