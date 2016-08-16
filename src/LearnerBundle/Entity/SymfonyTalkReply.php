<?php
// src/LearnerBundle/Entity/SymfonyTalkReply.php
namespace LearnerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class SymfonyTalkReply
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;
	/**
	* @Assert\NotBlank(message="Please, write your reply here.")
	* @ORM\Column(type="text")
	*/
	private $content;
	/**
	* @ORM\Column(type="datetime", name="reply_at")
	*/
	private $replyAt;
	/**
     * @ORM\Column(type="string", length=255)
     */
    private $author;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Image(     
     *     minWidth = 50,
     *     maxWidth = 800,
     *     minHeight = 20,
     *     maxHeight = 600,
     *     minWidthMessage = "Please note that minimum width of screenshot is 50px.",
     *     maxWidthMessage = "Please note that maximum width of screenshot is 800px.",
     *     minHeightMessage ="Please note that minimum height of screenshot is 20px.",
     *     maxHeightMessage = "Please note that maximum height of screenshot is 600px.",
     *     mimeTypes={ "image/jpg", "image/png", "image/jpeg", "image/gif", "image/tif", "image/tiff", "image/JPG" },
     *     mimeTypesMessage = "Oops, invalid file! We support .png .jpg .gif and .tif files.")
     */
    private $screenshot;
    /**
    * @ORM\ManyToOne(targetEntity="SymfonyTalk", inversedBy="reply")
    * @ORM\JoinColumn(name="talk_id", referencedColumnName="id")
    */
	private $talk;


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
     * @return SymfonyTalkReply
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
     * Set replyAt
     *
     * @param \DateTime $replyAt
     *
     * @return SymfonyTalkReply
     */
    public function setReplyAt($replyAt)
    {
        $this->replyAt = $replyAt;

        return $this;
    }

    /**
     * Get replyAt
     *
     * @return \DateTime
     */
    public function getReplyAt()
    {
        return $this->replyAt;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return SymfonyTalkReply
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
     * Set talk
     *
     * @param \LearnerBundle\Entity\SymfonyTalk $talk
     *
     * @return SymfonyTalkReply
     */
    public function setTalk(\LearnerBundle\Entity\SymfonyTalk $talk = null)
    {
        $this->talk = $talk;

        return $this;
    }

    /**
     * Get talk
     *
     * @return \LearnerBundle\Entity\SymfonyTalk
     */
    public function getTalk()
    {
        return $this->talk;
    }
}
