<?php
namespace DoctrineExtensions\Versionable;

use Doctrine\Common\EventSubscriber,
    Doctrine\ORM\Events,
    Doctrine\ORM\Event\OnFlushEventArgs,
    Doctrine\ORM\EntityManager,
    DoctrineExtensions\Versionable\Entity\ResourceVersion;

class VersionListener implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(Events::onFlush);
    }

    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        /* @var $em Doctrine\ORM\EntityManager */
        $em = $args->getEntityManager();
        /* @var $uow Doctrine\ORM\UnitOfWork */
        $uow = $em->getUnitOfWork();

        /* @var $resourceClass Doctrine\ORM\Mapping\ClassMetadata */
        $resourceClass = $em->getClassMetadata('DoctrineExtensions\Versionable\Entity\ResourceVersion');

        foreach ($uow->getScheduledEntityUpdates() AS $entity) {
            if ($entity instanceof Versionable) {
                $entityClass = $em->getClassMetadata(get_class($entity));

                if (!$entityClass->isVersioned) {
                    throw Exception::versionedEntityRequired();
                }
                
                $entityId = $entityClass->getIdentifierValues($entity);
                if (count($entityId) == 1 && current($entityId)) {
                    $entityId = current($entityId);
                } else {
                    throw Exception::singleIdentifierRequired();
                }

                $oldValues = array_map(function($changeSetField) {
                    return $changeSetField[0];
                }, $uow->getEntityChangeSet($entity));

                $entityVersion = $entityClass->reflFields[$entityClass->versionField]->getValue($entity);

                unset($oldValues[$entityClass->versionField]);
                unset($oldValues[$entityClass->getSingleIdentifierFieldName()]);

                $resourceVersion = new ResourceVersion($entityClass->name, $entityId, $oldValues, $entityVersion);

                $em->persist( $resourceVersion );
                $uow->computeChangeSet($resourceClass, $resourceVersion);
            }
        }
    }
}