<?php
namespace AppBundle\Entity\Classification;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCategory as BaseCategory;

/**
 * Class Category
 * @package AppBundle\Entity\Classification
 *
 * @ORM\Table(name="sonata_classification__category")
 * @ORM\Entity()
 */
class Category extends BaseCategory {

    /**
     * @var guid
     *
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
