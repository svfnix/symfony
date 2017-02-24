<?php

namespace AppBundle\Twig\Extensions;

use AppBundle\Entity\Media;
use Fisharebest\ExtCalendar\GregorianCalendar;
use Fisharebest\ExtCalendar\PersianCalendar;
use Liip\ImagineBundle\Templating\ImagineExtension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;
use Twig_Filter;
use Twig_Function;

/**
 * Created by PhpStorm.
 * User: svf
 * Date: 12/5/16
 * Time: 12:30 AM
 */
class AppExtension extends Twig_Extension
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new Twig_Filter('pnum', [$this, 'pnum']),
            new Twig_Filter('enum', [$this, 'enum']),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_Function('grid_column', [$this, 'grid_column']),
            new Twig_Function('node_icon', [$this, 'node_icon'])
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }

    /**
     * @param $input
     * @return mixed
     */
    public function pnum($input)
    {

        $input = str_replace('1', '۱', $input);
        $input = str_replace('2', '۲', $input);
        $input = str_replace('3', '۳', $input);
        $input = str_replace('4', '۴', $input);
        $input = str_replace('5', '۵', $input);
        $input = str_replace('6', '۶', $input);
        $input = str_replace('7', '۷', $input);
        $input = str_replace('8', '۸', $input);
        $input = str_replace('9', '۹', $input);
        $input = str_replace('0', '۰', $input);

        return $input;

    }

    /**
     * @param $input
     * @return mixed
     */
    public function enum($input)
    {
        $input = str_replace('۱', '1', $input);
        $input = str_replace('۲', '2', $input);
        $input = str_replace('۳', '3', $input);
        $input = str_replace('۴', '4', $input);
        $input = str_replace('۵', '5', $input);
        $input = str_replace('۶', '6', $input);
        $input = str_replace('۷', '7', $input);
        $input = str_replace('۸', '8', $input);
        $input = str_replace('۹', '9', $input);
        $input = str_replace('۰', '0', $input);

        return $input;

    }

    /**
     * @param $node
     * @param int $width
     * @param int $height
     * @return string
     */
    public function node_icon(Media $node, $width=96, $height=96)
    {

        if($node->isDir()){
            return '/assets/images/folder.png';
        }

        switch ($node->getExtension()){
            case 'pdf':
                return '/assets/images/pdf.png';
                break;

            case 'doc':
            case 'docx':
                return '/assets/images/word.png';
                break;

            case 'xls':
            case 'xlsx':
                return '/assets/images/excel.png';
                break;

            case 'ppt':
            case 'pptx':
                return '/assets/images/powerpoint.png';
                break;

            case 'bmp':
            case 'gif':
                return '/assets/images/image.png';
                break;
        }

        switch ($node->getFileType()){
            case 'image':

                $ext = new ImagineExtension(
                    $this->container->get('liip_imagine.cache.manager')
                );

                return $ext->filter(
                    implode(DIRECTORY_SEPARATOR, [
                        $this->container->getParameter('upload_dir'),
                        $node->getPath()
                    ]), 'thumb_small');

                break;

            case 'audio':
                return '/assets/images/audio.png';
                break;

            case 'video':
                return '/assets/images/video.png';
                break;

            case 'document':
                return '/assets/images/document.png';
                break;

            default:
                return '/assets/images/rest.png';
                break;
        }
    }

    /**
     * @param $name
     * @param $title
     * @param $filters
     * @return string
     */
    public function grid_column($name, $title, $filters){
        if($filters['order_by'] == $name){
            return $title . ' <i class="fa fa-caret-'.(($filters['sort'] == 'asc') ? 'up' : 'down').'"></i>';
        }

        return $title;
    }

}