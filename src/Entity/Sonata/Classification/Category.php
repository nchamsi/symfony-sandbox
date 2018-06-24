<?php
namespace App\Entity\Sonata\Classification;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCategory as BaseCategory;

/**
 * Class Category
 * @package App\Entity\Sonata\Classification
 *
 * @ORM\Table(name="sonata_classification__category")
 * @ORM\Entity()
 */
class Category extends BaseCategory {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
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
