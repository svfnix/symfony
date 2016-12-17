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
        $this->roles = array();
        $this->groups = new ArrayCollection();
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
     * @Assert\NotBlank(message="آدرس ایمیل معتبر نمی باشد")
     * @Assert\Email
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
     * @Assert\NotBlank(message="رمز عبور معتبر نمی باشد")
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
     * @Assert\NotBlank(message="نام و نام خانوادگی را وارد نمایید")
     * @ORM\Column(name="name", type="string", length=128, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="شماره موبایل را وارد نمایید")
     * @ORM\Column(name="mobile", type="string", length=16, nullable=true)asswd
     *
     * @Assert\Regex(pattern="/^09[0-9]{9}$/", message="شماره وارد شده معتبر نمی باشد")
     */
    private $mobile;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json_array")
     */
    private $roles;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\UserGroup", cascade={"persist"})
     * @ORM\JoinTable(name="users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_group_id", referencedColumnName="id")}
     *      )
     */
    private $groups;

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
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param $role
     *
     * @return User
     */
    public function addRoles($role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(){
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Add group
     *
     * @param UserGroup $group
     * @return User
     */
    public function addGroup(UserGroup $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove group
     * @param UserGroup $group
     */
    public function removeGroup(UserGrou $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
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
            $this->name,
            $this->mobile,
            $this->roles,
            $this->groups,
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
            $this->name,
            $this->mobile,
            $this->roles,
            $this->groups,
            ) = unserialize($serialized);
    }
}
