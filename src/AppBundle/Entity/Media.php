<?php

namespace AppBundle\Entity;

use AppBundle\Traits\Base;
use AppBundle\Traits\Metadata;
use AppBundle\Traits\StatusRead;
use AppBundle\Traits\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * File
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MediaRepository")
 */
class Media
{

    const FILE_TYPE_DIR = 0;
    const FILE_TYPE_FILE = 1;

    use Base,
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Media", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="dir", type="string", length=256, nullable=true)
     */
    private $dir;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=256)
     * @Assert\NotNull(message="نام پرونده مشخص نشده است")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="original_name", type="string", length=256, nullable=true)
     */
    private $originalName;

    /**
     * @var string
     *
     * @ORM\Column(name="tree", type="string", length=1024)
     */
    private $tree;

    /**
     * @var string
     *
     * @ORM\Column(name="media_type", type="integer", length=1)
     */
    private $mediaType;

    /**
     * @var string
     *
     * @ORM\Column(name="file_type", type="string", length=16, nullable=true)
     */
    private $fileType;

    /**
     * @var string
     *
     * @ORM\Column(name="mime_type", type="string", length=32, nullable=true)
     */
    private $mimeType;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="integer", length=11, nullable=true)
     */
    private $size;

    /**
     * @var integer
     *
     * @ORM\Column(name="downloads", type="integer", length=11, nullable=true)
     */
    private $downloads;

    /**
     * Media constructor.
     */
    function __construct()
    {
        $this->children = new ArrayCollection();
        $this->tree = '/';
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     * @return Media
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Media|null $parent
     * @return Media
     */
    public function setParent($parent)
    {
        if ($parent){
            $this->parent = $parent;
            $this->tree = $parent->getParent() . $parent->getId() . '/';
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     * @return Media
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param string $dir
     * @return Media
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
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
     * @param string $name
     * @return Media
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     * @return Media
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
        return $this;
    }

    /**
     * @return string
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * @return bool
     */
    public function isFile()
    {
        return ($this->mediaType == self::FILE_TYPE_FILE) ? true : false;
    }

    /**
     * @return bool
     */
    public function isDir()
    {
        return ($this->mediaType == self::FILE_TYPE_DIR) ? true : false;
    }

    /**
     * @param string $mediaType
     * @return Media
     */
    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     * @return Media
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     * @return Media
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        $name = explode('.', $this->name);
        return array_pop($name);
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     * @return Media
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string
     */
    public function getDownloads()
    {
        return $this->downloads;
    }

    /**
     * @return Media
     */
    public function incDownloads()
    {
        $this->downloads++;
        return $this;
    }

    public function getPath(){
        return implode(DIRECTORY_SEPARATOR, [$this->getDir(), $this->getName()]);
    }
}

