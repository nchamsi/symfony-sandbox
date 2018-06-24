<?php

namespace App\Entity\Sonata\Classification;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseContext as BaseContext;

/**
 * Class Context
 * @package App\Entity\Sonata\Classification
 *
 * @ORM\Table(name="sonata_classification__context")
 * @ORM\Entity()
 */
class Context extends BaseContext
{

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=100)
     */
    protected $id;

    /**
     * @return string
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
