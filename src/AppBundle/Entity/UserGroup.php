<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 10/27/16
 * Time: 9:19 PM
 */

namespace AppBundle\Entity;


use AppBundle\Traits\Name;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Traits\Base;
use AppBundle\Traits\Enabled;
use AppBundle\Traits\Metadata;
use AppBundle\Traits\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Group
 *
 * @ORM\Table(name="usergroup")
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserGroupRepository")
 * @UniqueEntity("name")
 */
class UserGroup
{
    use Base,
        Name,
        Enabled,
        Timestampable,
        Metadata;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=256)
     * @Assert\NotBlank(message="عنوان گروه وارد نشده است")
     */
    private $title;

    /**
     * @var array
     *
     * @ORM\Column(name="permissions", type="json_array")
     */
    private $permissions = [];

    /**
     * UserGroup constructor.
     */
    function __construct()
    {
        $this->setCreatedAt();
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param array $permissions
     * @return $this
     */
    public function setPermissions($permissions)
    {
        if(is_array($permissions)) {
            $this->permissions = $permissions;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
