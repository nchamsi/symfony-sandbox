<?php

namespace App\Entity\Sonata\Classification;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseTag as BaseTag;

/**
 * Class Tag
 * @package App\Entity\Sonata\Classification
 *
 * @ORM\Table(name="sonata_classification__tag")
 * @ORM\Entity()
 *
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(
 *          name="slug",
 *          column=@ORM\Column(
 *              name     = "slug",
 *              type     = "string",
 *               length   = 100
 *          )
 *      )
 * })
 */
class Tag extends BaseTag
{

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
