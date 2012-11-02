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

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Helper\HelperSet;

require_once 'AbstractDoctrineTask.php';

/**
 * Write schema SQL to a file
 */
class InstallSql extends AbstractDoctrineTask
{
    /**
     * @var string
     */
    protected $taskName = "dc2-install-sql";

    /**
     * @var string
     */
    private $installSqlFile = null;

    /**
     * @param  string $installSqlFile
     * @return void
     */
    public function setInstallSqlFile($installSqlFile)
    {
        $this->installSqlFile = $installSqlFile;
    }

    protected function _doRun(HelperSet $helperSet)
    {
        if ($this->installSqlFile === null) {
            throw new \BuildException(
                "Schema SQL file is not set."
            );
        }

        if (!is_dir(dirname($this->installSqlFile))) {
            throw new \BuildException(
                "Schema SQL directory is not a valid directory."
            );
        }

        if (!is_writable(dirname($this->installSqlFile))) {
            throw new \BuildException(
                "Schema SQL directory is not writable."
            );
        }

        $emHelper = $helperSet->get('em');
        $em = $emHelper->getEntityManager();

        $schemaTool = new SchemaTool($em);

        $cmf = $em->getMetadataFactory();
        $classes = $cmf->getAllMetadata();

        $sql = $schemaTool->getCreateSchemaSql($classes);

        $code = sprintf(
            "<?php\n\nreturn %s;\n",
            var_export($sql, true)
        );

        file_put_contents($this->installSqlFile, $code);

        $this->log("Wrote schema SQL to file {$this->installSqlFile}");
    }
}
