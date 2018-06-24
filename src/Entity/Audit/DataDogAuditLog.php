<?php

namespace App\Entity\Audit;

use DataDog\AuditBundle\Entity\Association;
use Doctrine\ORM\Mapping as ORM;

use DataDog\AuditBundle\Entity\AuditLog as BaseAuditLog;

/**
 * @ORM\Entity
 * @ORM\Table(name="audit_logs")
 */
class DataDogAuditLog
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(length=12)
     */
    private $action;

    /**
     * @ORM\Column(length=128)
     */
    private $tbl;

    /**
     * @ORM\OneToOne(targetEntity="DataDog\AuditBundle\Entity\Association")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;

    /**
     * @ORM\OneToOne(targetEntity="DataDog\AuditBundle\Entity\Association")
     */
    private $target;

    /**
     * @ORM\OneToOne(targetEntity="DataDog\AuditBundle\Entity\Association")
     */
    private $blame;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $diff;

    /**
     * @ORM\Column(type="datetime")
     */
    private $loggedAt;

    public function getId()
    {
        return $this->id;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getTbl()
    {
        return $this->tbl;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getBlame()
    {
        return $this->blame;
    }

    public function getDiff()
    {
        return $this->diff;
    }

    public function getLoggedAt()
    {
        return $this->loggedAt;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function setTbl(string $tbl): self
    {
        $this->tbl = $tbl;

        return $this;
    }

    public function setDiff($diff): self
    {
        $this->diff = $diff;

        return $this;
    }

    public function setLoggedAt(\DateTimeInterface $loggedAt): self
    {
        $this->loggedAt = $loggedAt;

        return $this;
    }

    public function setSource(Association $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function setTarget(?Association $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function setBlame(?Association $blame): self
    {
        $this->blame = $blame;

        return $this;
    }
}
