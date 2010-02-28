<?php
namespace DoctrineExtensions\Versionable\Entity;

/**
 * @Entity
 * @Table(name="dc_versionable_resources")
 */
class ResourceVersion
{
    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;

    /** @Column(name="resource_name", type="string") */
    private $resourceName;

    /** @Column(name="resource_id", type="string") */
    private $resourceId;

    /** @Column(name="versioned_data", type="array") */
    private $versionedData;

    /** @Column(name="snapshot_version_id", type="integer") */
    private $version;

    /** @Column(name="snapshot_date", type="datetime") */
    private $snapshotDate;

    public function __construct($resourceName, $entityId, $versionedData, $entityVersion)
    {
        $this->resourceName     = $resourceName;
        $this->resourceId       = $entityId;
        $this->versionedData    = $versionedData;
        $this->version          = $entityVersion;
        $this->snapshotDate     = new \DateTime("now");
    }

    public function getId() {
        return $this->id;
    }

    public function getResourceName() {
        return $this->resourceName;
    }

    public function getResourceId() {
        return $this->resourceId;
    }

    public function getVersionedData($key = null) {
        if ($key !== null) {
            return $this->versionedData[$key];
        } else {
            return $this->versionedData;
        }
    }

    public function getVersion() {
        return $this->version;
    }

    public function getSnapshotDate() {
        return $this->snapshotDate;
    }
}