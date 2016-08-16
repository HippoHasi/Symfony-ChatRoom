<?php
// src/LearnerBundle/Entity/SymfonyTalk.php
namespace LearnerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class SymfonyTalk
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;
	/**
	* @Assert\NotBlank(message="Please, give a title for your talk.")
	* @ORM\Column(type="string", length=255)
	*/
	private $title;
	/**
	* @Assert\NotBlank(message="Please, select a category.")
    * @ORM\ManyToOne(targetEntity="Category", inversedBy="SymfonyTalk")
    * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
    */
	private $category;
	/**
	* @Assert\NotBlank(message="Please, write your talk here.")
	* @ORM\Column(type="text")
	*/
	private $content;
	/**
	* @ORM\Column(type="datetime", name="submit_at")
	*/
	private $submitAt;
	/**
     * @ORM\Column(type="string", length=255)
     */
    private $author;
    	/**
     * @ORM\Column(type="integer")
     */
    private $count;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Image(     
     *     minWidth = 50,
     *     minHeight = 50,
     *     maxSize = "2M",
     *     minWidthMessage = "Please note that minimum width of screenshot is 50px.",
     *     minHeightMessage ="Please note that minimum height of screenshot is 50px.",
     *     maxSizeMessage = "The file is too large. Allowed maximum size is 2MB.",
     *     mimeTypes={ "image/jpg", "image/png", "image/jpeg", "image/gif", "image/tif", "image/tiff", "image/JPG" },
     *     mimeTypesMessage = "Oops, invalid file! We support .png .jpg .gif and .tif files.")
     */
    private $screenshot;
    /**
    * @ORM\OneToMany(targetEntity="SymfonyTalkReply", mappedBy="talk")
    */
    protected $reply;

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
     * Set title
     *
     * @param string $title
     *
     * @return SymfonyTalk
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return SymfonyTalk
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set submitAt
     *
     * @param \DateTime $submitAt
     *
     * @return SymfonyTalk
     */
    public function setSubmitAt($submitAt)
    {
        $this->submitAt = $submitAt;

        return $this;
    }

    /**
     * Get submitAt
     *
     * @return \DateTime
     */
    public function getSubmitAt()
    {
        return $this->submitAt;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return SymfonyTalk
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set count
     *
     * @param integer $count
     *
     * @return SymfonyTalk
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set category
     *
     * @param \LearnerBundle\Entity\Category $category
     *
     * @return SymfonyTalk
     */
    public function setCategory(\LearnerBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \LearnerBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function setScreenshot($screenshot)
    {
        $this->screenshot = $screenshot;
        return $this;
    }
    public function getScreenshot()
    {
        return $this->screenshot;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reply = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add reply
     *
     * @param \LearnerBundle\Entity\SymfonyTalkReply $reply
     *
     * @return SymfonyTalk
     */
    public function addReply(\LearnerBundle\Entity\SymfonyTalkReply $reply)
    {
        $this->reply[] = $reply;

        return $this;
    }

    /**
     * Remove reply
     *
     * @param \LearnerBundle\Entity\SymfonyTalkReply $reply
     */
    public function removeReply(\LearnerBundle\Entity\SymfonyTalkReply $reply)
    {
        $this->reply->removeElement($reply);
    }

    /**
     * Get reply
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReply()
    {
        return $this->reply;
    }
}
