<?php
// src/LearnerBundle/Entity/BlogReply.php
namespace LearnerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class BlogReply
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
    * @ORM\ManyToOne(targetEntity="Blog", inversedBy="reply")
    * @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
    */
	private $blog;



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
     * @return BlogReply
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
     * @return BlogReply
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
     * @return BlogReply
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
     * Set blog
     *
     * @param \LearnerBundle\Entity\Blog $blog
     *
     * @return BlogReply
     */
    public function setBlog(\LearnerBundle\Entity\Blog $blog = null)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return \LearnerBundle\Entity\Blog
     */
    public function getBlog()
    {
        return $this->blog;
    }
}
