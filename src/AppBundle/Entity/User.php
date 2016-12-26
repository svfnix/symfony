<?php

namespace AppBundle\Entity;

use AppBundle\Entity\UserGroup;
use AppBundle\Traits\Base;
use AppBundle\Traits\Enabled;
use AppBundle\Traits\Metadata;
use AppBundle\Traits\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="این آدرس ایمیل قبلا در سیستم ثبت شده است")
 */
class User implements AdvancedUserInterface, \Serializable
{

    use Base,
        Enabled,
        Timestampable,
        Metadata;

    function __construct()
    {
        $this->usergroups = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=32, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, unique=true)
     * @Assert\NotBlank(groups={"add", "update"}, message="آدرس ایمیل معتبر نمی باشد")
     * @Assert\Email(groups={"add", "update"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=64)
     */
    protected $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     * @Assert\NotBlank(groups={"add"}, message="رمز عبور معتبر نمی باشد")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="reset_password_token", type="string", length=64, nullable=true)
     */
    private $resetPasswordToken;

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=128, nullable=true)
     * @Assert\NotBlank(groups={"add", "update"}, message="نام و نام خانوادگی را وارد نمایید")
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=16, nullable=true)
     *
     * @Assert\NotBlank(groups={"add", "update"}, message="شماره موبایل را وارد نمایید")
     * @Assert\Regex(groups={"add", "update"}, pattern="/^09[0-9]{9}$/", message="شماره وارد شده معتبر نمی باشد")
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=32)
     * @Assert\NotBlank(groups={"add", "update"}, message="نقشی انتخاب نشده است")
     */
    private $role;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\UserGroup", cascade={"persist"})
     * @ORM\JoinTable(name="user_usergroup",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="usergroup_id", referencedColumnName="id", onDelete="cascade")}
     *      )
     */
    private $usergroups;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $salt
     * @return User
     */
    public function setSalt($salt){
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return $this
     */
    public function generateSalt(){
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);

        return $this;
    }

    /**
     * @return string
     */
    public function getSalt(){

        if(empty($this->salt)){
            $this->generateSalt();
        }

        return $this->salt;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $resetPasswordToken
     * @return User
     */
    public function setResetPasswordToken($resetPasswordToken)
    {
        $this->resetPasswordToken = $resetPasswordToken;

        return $this;
    }

    /**
     * @return array
     */
    public function getResetPasswordToken()
    {
        return $this->resetPasswordToken;
    }

    /**
     * @param $fullname
     * @return User
     *
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param string $mobile
     *
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {

        return [$this->role];
    }

    /**
     * @return string
     */
    public function getRole()
    {

        return $this->role;
    }

    /**
     * Add UserGroup
     *
     * @param \AppBundle\Entity\UserGroup $usergroup
     * @return User
     */
    public function addUsergroup(UserGroup $usergroup)
    {
        $this->usergroups[] = $usergroup;

        return $this;
    }

    /**
     * Remove UserGroup
     * @param \AppBundle\Entity\UserGroup $usergroup
     * @return $this
     */
    public function removeUsergroup(UserGroup $usergroup)
    {
        $this->usergroups->removeElement($usergroup);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsergroups()
    {
        return $this->usergroups;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->getEnabled();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->enabled,
            $this->username,
            $this->email,
            $this->salt,
            $this->password,
            $this->resetPasswordToken,
            $this->fullname,
            $this->mobile,
            $this->role,
            $this->usergroups,
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->enabled,
            $this->username,
            $this->email,
            $this->salt,
            $this->password,
            $this->resetPasswordToken,
            $this->fullname,
            $this->mobile,
            $this->role,
            $this->usergroups,
            ) = unserialize($serialized);
    }
}
