<?php

namespace AppBundle\Service;

use AppBundle\Entity\Media;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class UploaderService
{
    /**
     * @var Request $request
     */
    private $request;

    /**
     * @var EntityManager $em
     */
    private $em;

    /**
     * @var User owner
     */
    private $owner;

    /**
     * @var string $rootDir
     */
    private $rootDir;

    /**
     * @var string $dir
     */
    private $dir;

    /**
     * @var array $allow
     */
    private $allow;

    /**
     * @var array $extensions
     */
    private $extensions;


    /**
     * UploaderService constructor.
     *
     * @param RequestStack $requestStack
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     * @param $dir
     */
    function __construct(RequestStack $requestStack, EntityManager $em, TokenStorage $tokenStorage, $dir)
    {

        $this->request = $requestStack->getCurrentRequest();
        $this->em = $em;

        $this->owner = $tokenStorage->getToken()->getUser();
        $this->dir = $dir;

        $this->allow = [
            'image' => false,
            'audio' => false,
            'video' => false,
            'document' => false,
            'rest' => false
        ];

        $this->extensions = [
            'image' => ['png', 'jpe', 'jpeg', 'jpg', 'gif', 'bmp'],
            'audio' => ['mp3', 'wav'],
            'video' => ['mp4', 'mpg', 'mov', 'mkv', '3gp'],
            'document' => ['pdf', 'htm', 'html', 'txt', 'ods', 'odt', 'doc', 'rtf', 'xls', 'ppt'],
            'rest' => ['zip', 'rar']
        ];

        return $this;
    }

    /**
     * @param UploadedFile $file
     * @return bool
     */
    private function isValidFile(UploadedFile $file)
    {
        $extensions = [];

        if($this->allow['image']){
            $extensions = array_merge($extensions, $this->extensions['image']);
        }

        if($this->allow['audio']){
            $extensions = array_merge($extensions, $this->extensions['audio']);
        }

        if($this->allow['video']){
            $extensions = array_merge($extensions, $this->extensions['video']);
        }

        if($this->allow['document']){
            $extensions = array_merge($extensions, $this->extensions['document']);
        }

        if($this->allow['rest']){
            $extensions = array_merge($extensions, $this->extensions['rest']);
        }

        if(in_array($file->guessExtension(), $extensions)){
            return true;
        }

        return false;
    }

    /**
     * @param $extension
     * @return int|string
     */
    private function getFileType($extension)
    {
        foreach ($this->extensions as $key => $val){
            if(in_array($extension, $val)){
                return $key;
            }
        }
    }

    /**
     * @param User $owner
     * @return UploaderService
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return UploaderService
     */
    public function allowImage()
    {
        $this->allow['image'] = true;
        return $this;
    }

    /**
     * @return UploaderService
     */
    public function allowAudio()
    {
        $this->allow['audio'] = true;
        return $this;
    }

    /**
     * @return UploaderService
     */
    public function allowVideo()
    {
        $this->allow['video'] = true;
        return $this;
    }

    /**
     * @return UploaderService
     */
    public function allowDocument()
    {
        $this->allow['document'] = true;
        return $this;
    }

    /**
     * @return UploaderService
     */
    public function allowRest()
    {
        $this->allow['rest'] = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function allowAll()
    {
        $this->allow = [
            'image' => true,
            'audio' => true,
            'video' => true,
            'document' => true,
            'rest' => true
        ];

        return $this;
    }

    /**
     * @param $parent
     * @param $field
     * @return Media|bool
     */
    public function upload($parent, $field)
    {
        if($this->request->isMethod('post')){

            if($this->request->files->has($field)){

                $file = $this->request->files->get($field);
                if($file->isValid() && $this->isValidFile($file)){

                    $media_dir = implode(DIRECTORY_SEPARATOR, [$this->owner->getId(), date('Y'), date('m')]);
                    $full_dir = implode(DIRECTORY_SEPARATOR, [ '.', $this->dir, $media_dir]);

                    $fs = new Filesystem();
                    $fs->mkdir($full_dir);

                    $media = new Media();
                    $media->setMediaType(Media::FILE_TYPE_FILE);
                    $media->setCreatedAt();
                    $media->setParent($parent);
                    $media->setDir($media_dir);
                    $media->setName('FILE_' . uniqid() . '.' . $file->guessExtension());
                    $media->setOriginalName($file->getClientOriginalName());
                    $media->setMimeType($file->getMimeType());
                    $media->setFileType($this->getFileType($file->guessExtension()));
                    $media->setSize($file->getSize());
                    $media->setOwner($this->owner);

                    $file->move($full_dir, $media->getName());

                    $this->em->persist($media);
                    $this->em->flush();

                    return $media;
                }
            }

        }

        return false;
    }
}