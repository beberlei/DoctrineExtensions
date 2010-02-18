<?php
/**
 * Whitewashing
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\PHPUnit;

require_once "PHPUnit/Extensions/Database/ITester.php";

use Doctrine\ORM\EntityManager;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection AS IDatabaseConnection;
use PHPUnit_Extensions_Database_DefaultTester AS DefaultTester;
use PHPUnit_Extensions_Database_Operation_Factory AS OperationFactory;

class DatabaseTester extends DefaultTester
{
    public function __construct(IDatabaseConnection $connection)
    {
        $this->connection = $connection;
        $this->setUpOperation = new \PHPUnit_Extensions_Database_Operation_Composite(array(
            new Operations\Truncate($connection->allowsCascading()),
            OperationFactory::INSERT()
        ));
        $this->tearDownOperation = OperationFactory::NONE();
    }
}
