<?php
// src/LearnerBundle/Entity/User.php
namespace LearnerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
/**
* @ORM\Entity
* @UniqueEntity(fields="email", message="Email is already taken")
* @UniqueEntity(fields="username", message="Username is already taken")
*/
class User implements UserInterface, \Serializable
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;
	/**
	* @Assert\NotBlank()
	* @Assert\Email()
	* @ORM\Column(type="string", length=255)
	*/
	private $email;
	/**
	* @Assert\NotBlank()
    * @Assert\Length(min=6, max=12, minMessage="Username must be 6-12 characters long", 
    *     maxMessage="Your username must be 6-12 characters long")
	* @ORM\Column(type="string", length=255)
	*/
	private $username;
	/**
	* @Assert\NotBlank()
	* @Assert\Length(min=6, max = 4096, minMessage="Password must be at least 6 characters long")
	*/
	private $plainPassword;

	/**
	* @ORM\Column(type="string", length=64)
	*/
	private $password;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Image(     
     *     minWidth = 50,
     *     minHeight = 50,
     *     maxSize = "2M",
     *     minWidthMessage = "Please note that minimum width of image is 50px.",
     *     minHeightMessage ="Please note that minimum height of image is 50px.",
     *     maxSizeMessage = "The file is too large. Allowed maximum size is 2MB.",
     *     mimeTypes={ "image/jpg", "image/png", "image/jpeg", "image/gif", "image/tif", "image/tiff", "image/JPG" },
     *     mimeTypesMessage = "Oops, invalid file! We support .png .jpg .gif and .tif files.")
     */
    private $avatar;
	/**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

	public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

	public function getEmail()
	{
		return $this->email;
	}
	public function setEmail($email)
	{
		$this->email = $email;
	}
	public function getUsername()
	{
		return $this->username;
	}
	public function setUsername($username)
	{
		$this->username = $username;
	}
	public function getPlainPassword()
	{
		return $this->plainPassword;
	}
	public function setPlainPassword($password)
	{
		$this->plainPassword = $password;
	}
	public function setPassword($password)
	{
		$this->password = $password;
	}
	public function getPassword()
    {
        return $this->password;
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

//below methods are from the 'Entity Provider'(load security users) 
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // all passwords must be hashed with a salt, but bcrypt does it internally, so this function returns null.
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }    

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
