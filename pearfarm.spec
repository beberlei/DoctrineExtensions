<?php

$spec = Pearfarm_PackageSpec::create(array(Pearfarm_PackageSpec::OPT_BASEDIR => dirname(__FILE__)))
             ->setName('DoctrineExtensions')
             ->setChannel('beberlei.pearfarm.org')
             ->setSummary('PHPUnit and Sql-Sniffer extensions to Doctrine 2')
             ->setDescription('PHPUnit and Sql-Sniffer extensions to Doctrine 2')
             ->setReleaseVersion('0.0.1')
             ->setReleaseStability('alpha')
             ->setApiVersion('0.0.1')
             ->setApiStability('alpha')
             ->setLicense(Pearfarm_PackageSpec::LICENSE_BSD)
             ->addExcludeFiles(array('.gitignore', 'package.xml', 'pearfarm.spec'))
             ->setDependsOnPHPVersionMin('5.3.1')
             ->setNotes('Initial release.')
             ->addMaintainer('lead', 'Benjamin Eberlei', 'beberlei', 'kontakt@beberlei.de')
             ->addGitFiles();
