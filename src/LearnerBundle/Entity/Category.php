<?php
// src/LearnerBundle/Entity/Category.php
namespace LearnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class Category
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;
    /**
    * @ORM\Column(type="string", length=255)
    */
    private $name;
    /**
    * @ORM\OneToMany(targetEntity="SymfonyTalk", mappedBy="Category")
    */
    protected $symfonyTalk;

    public function __construct()
    {
        $this->symfonyTalk = new ArrayCollection();
    }

   

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add symfonyTalk
     *
     * @param \LearnerBundle\Entity\SymfonyTalk $symfonyTalk
     *
     * @return Category
     */
    public function addSymfonyTalk(\LearnerBundle\Entity\SymfonyTalk $symfonyTalk)
    {
        $this->symfonyTalk[] = $symfonyTalk;

        return $this;
    }

    /**
     * Remove symfonyTalk
     *
     * @param \LearnerBundle\Entity\SymfonyTalk $symfonyTalk
     */
    public function removeSymfonyTalk(\LearnerBundle\Entity\SymfonyTalk $symfonyTalk)
    {
        $this->symfonyTalk->removeElement($symfonyTalk);
    }

    /**
     * Get symfonyTalk
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSymfonyTalk()
    {
        return $this->symfonyTalk;
    }
}
