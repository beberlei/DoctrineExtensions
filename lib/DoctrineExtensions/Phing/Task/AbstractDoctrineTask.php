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

abstract class AbstractDoctrineTask extends \Task
{
    /**
     * @var HelperSet
     */
    protected static $helperSet = null;

    /**
     * @var string
     */
    protected $cliConfigFile = "cli-config.php";

    /**
     * @todo   Rename to setCliConfigFile
     * @param  string $cliConfigFile
     * @return void
     */
    public function setCliConfig($cliConfigFile)
    {
        $this->cliConfigFile = $cliConfigFile;
    }

    public function main()
    {
        if (self::$helperSet === null) {
            if (!file_exists($this->cliConfigFile)) {
                throw new \BuildException(
                    "Path to CLI config file must be valid!"
                );
            }

            include($this->cliConfigFile);

            if (!isset($helperSet)) {
                throw new \BuildException(
                    "Doctrine CLI config file must create a \$helperSet"
                  . " variable."
                );
            }

            if (!$helperSet instanceof HelperSet) {
                throw new \BuildException(
                    "\$helperSet must be an instance of"
                  . "Symfony\Component\Console\Helper\HelperSet."
                );
            }

            self::$helperSet = $helperSet;
        }

        $this->_doRun(self::$helperSet);
    }

    /**
     * @param  HelperSet $helperSet
     * @return void
     */
    abstract protected function _doRun(HelperSet $helperSet);
}
