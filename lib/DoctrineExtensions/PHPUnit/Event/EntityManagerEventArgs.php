<?php
/**
 * DoctrineExtensions PHPUnit
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\PHPUnit\Event;

use \Doctrine\ORM\EntityManager,
    \Doctrine\Common\EventArgs;

class EntityManagerEventArgs extends EventArgs
{
    /**
     * @var EntityManager
     */
    private $_em;

    /**
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->_em;
    }
}