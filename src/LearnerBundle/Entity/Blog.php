<?php
// src/LearnerBundle/Entity/Blog.php
namespace LearnerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class Blog
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;
	/**
	* @Assert\NotBlank(message="您此刻的想法...")
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
     * @ORM\Column(type="simple_array", nullable=true)
     * @Assert\Image(     
     *     minWidth = 50,
     *     minHeight = 50,
     *     maxSize = "2M",
     *     minWidthMessage = "图片最小宽度不能小于 50px.",
     *     minHeightMessage ="图片最小高度不能小于 50px.",
     *     maxSizeMessage = "不好意思！图片不能大于 2M 噢！",
     *     mimeTypes={ "image/jpg", "image/png", "image/jpeg", "image/gif", "image/tif", "image/tiff", "image/JPG" },
     *     mimeTypesMessage = "Oops, invalid file! We support .png .jpg .gif and .tif files.")
     */
    private $pics;
    /**
    * @ORM\OneToMany(targetEntity="BlogReply", mappedBy="blog")
    */
    protected $reply;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reply = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set content
     *
     * @param string $content
     *
     * @return Blog
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
     * @return Blog
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
     * @return Blog
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
     * @return Blog
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
     * Set pics
     *
     * @param array $pics
     *
     * @return Blog
     */
    public function setPics($pics)
    {
        $this->pics = $pics;

        return $this;
    }

    /**
     * Get pics
     *
     * @return array
     */
    public function getPics()
    {
        return $this->pics;
    }
  

    /**
     * Add reply
     *
     * @param \LearnerBundle\Entity\BlogReply $reply
     *
     * @return Blog
     */
    public function addReply(\LearnerBundle\Entity\BlogReply $reply)
    {
        $this->reply[] = $reply;

        return $this;
    }

    /**
     * Remove reply
     *
     * @param \LearnerBundle\Entity\BlogReply $reply
     */
    public function removeReply(\LearnerBundle\Entity\BlogReply $reply)
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
