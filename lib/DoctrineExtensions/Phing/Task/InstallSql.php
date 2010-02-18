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

class InstallSql extends AbstractDoctrineTask
{
    protected $taskName = "dc2-install-sql";

    protected $platformClass = null;

    /**
     * @var string
     */
    private $installSqlFile = null;

    public function setInstallSqlFile($installSqlFile) {
        $this->installSqlFile = $installSqlFile;
    }

    /**
     * @param Configuration $cliConfig
     */
    protected function _doRun(\Doctrine\Common\Cli\Configuration $cliConfig)
    {
        if (!is_writable(dirname($this->installSqlFile))) {
            throw new \BuildException("Directory to write Install Sql File into is not writable.");
        }

        $em = $cliConfig->getAttribute('em');

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);

        $cmf = $em->getMetadataFactory();
        $classes = $cmf->getAllMetadata();

        $sql = $schemaTool->getCreateSchemaSql($classes);

        $code = "<?php\n\nreturn ".var_export($sql, true).";\n";
        file_put_contents($this->installSqlFile, $code);

        $this->log("Wrote the Array of SQL statements to create schema to file ".$this->installSqlFile);
    }
}