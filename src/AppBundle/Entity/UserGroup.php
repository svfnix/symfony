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

/**
 * Group
 *
 * @ORM\Table(name="user_group")
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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=256, nullable=true)
     */
    private $title;

    /**
     * @var array
     *
     * @ORM\Column(name="permissions", type="json_array")
     */
    private $permissions = array();

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
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @param $permission
     * @return $this
     */
    public function addPermission($permission)
    {
        $this->permissions[] = $permission;

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
