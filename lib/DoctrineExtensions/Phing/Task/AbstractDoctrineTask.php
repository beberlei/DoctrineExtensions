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

abstract class AbstractDoctrineTask extends \Task
{
    /**
     * @var \Doctrine\Common\Cli\Configuration
     */
    static protected $cliConfig = null;

    protected $cliConfigFile = "cli-config.php";

    public function setCliConfig($cliConfig)
    {
        $this->cliConfigFile = $cliConfig;
    }

    public function main()
    {
        if (self::$cliConfig == null) {
            if (!file_exists($this->cliConfigFile)) {
                throw new \BuildException("Path to CLI Config has to be valid!");
            }

            include($this->cliConfigFile);

            if (!isset($cliConfig) || !($cliConfig instanceof \Doctrine\Common\Cli\Configuration)) {
                throw new \BuildException("Doctrine CLI Config file has to create a \$cliConfig variable");
            }

            self::$cliConfig = $cliConfig;
        }

        $this->_doRun(self::$cliConfig);
    }

    /**
     * @param Configuration $cliConfig
     * @return void
     */
    abstract protected function _doRun(\Doctrine\Common\Cli\Configuration $cliConfig);
}