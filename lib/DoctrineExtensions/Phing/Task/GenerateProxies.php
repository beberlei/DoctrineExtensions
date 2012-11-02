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

use Symfony\Component\Console\Helper\HelperSet;

require_once 'AbstractDoctrineTask.php';

/**
 * Generate classes proxies to a given directory
 */
class GenerateProxies extends AbstractDoctrineTask
{
    /**
     * @var string
     */
    protected $taskName = "dc2-proxies";

    /**
     * @var string
     */
    protected $proxyDir = null;

    /**
     * @param  string $proxyDir
     * @return void
     */
    public function setProxyDir($proxyDir)
    {
        $this->proxyDir = $proxyDir;
    }

    protected function _doRun(HelperSet $helperSet)
    {
        $emHelper = $helperSet->get('em');
        $em = $emHelper->getEntityManager();

        $cmf = $em->getMetadataFactory();
        $classes = $cmf->getAllMetadata();
        $factory = $em->getProxyFactory();

        if (empty($classes)) {
            $this->log('No classes to generate proxies for.');
        } else {
            $proxyDir = ($this->proxyDir !== null)
                      ? $this->proxyDir
                      : $em->getConfiguration()->getProxyDir();

            if ($proxyDir === null) {
                throw new \BuildException(
                    "Proxy directory is not set."
                );
            }

            if (!is_dir($proxyDir)) {
                throw new \BuildException(
                    "Proxy directory is not a valid directory."
                );
            }

            if (!is_writable($proxyDir)) {
                throw new \BuildException(
                    "Proxy directory is not writable."
                );
            }

            $factory->generateProxyClasses($classes, $proxyDir);

            $this->log("Doctrine 2 proxy classes generated to {$proxyDir}");
        }
    }
}
