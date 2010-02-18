<?php
/**
 * Doctrine Phing Extension
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Phing\Task;

require_once "AbstractDoctrineTask.php";

class GenerateProxies extends AbstractDoctrineTask
{
    protected $taskName = "dc2-proxies";

    protected $proxyDir = null;

    public function setProxyDir($proxyDir)
    {
        $this->proxyDir = $proxyDir;
    }

    /**
     * @param Configuration $cliConfig
     */
    protected function _doRun(\Doctrine\Common\Cli\Configuration $cliConfig)
    {
        if ($this->proxyDir !== null && (!is_dir($this->proxyDir) || !is_writable($this->proxyDir))) {
            throw new \BuildException("Proxy directory is not valid or writable.");
        }

        /* @var $cliConfig \Doctrine\Common\Cli\Configuration */
        $em = $cliConfig->getAttribute('em');

        $cmf = $em->getMetadataFactory();
        $classes = $cmf->getAllMetadata();
        $factory = $em->getProxyFactory();

        if (empty($classes)) {
            $this->log('No classes to generate proxies for.');
        } else {
            $proxyDir = ($this->proxyDir != null) ? $this->proxyDir : $em->getConfiguration()->getProxyDir();

            $factory->generateProxyClasses($classes, $proxyDir);

            $this->log('Doctrine 2 proxy classes generated to: ' . $proxyDir);
        }
    }
}
