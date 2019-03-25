<?php
namespace App\Doctrine;


use Doctrine\ORM\Mapping as ORM;

trait CreateAndUpdateAction
{
    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if (empty($this->createdAt)) {
            $this->setCreatedAt(new \DateTime());
        }
        if (empty($this->updatedAt)) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
