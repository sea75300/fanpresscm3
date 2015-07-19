<?php
    /**
     * FanPress CM UploadHandler
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    require_once dirname(dirname(dirname(__DIR__))).'/common.php';

    $config = new \fpcm\model\system\config(false);
    
    $options = array(
        'upload_dir' => \fpcm\classes\baseconfig::$uploadDir,
        'upload_url' => \fpcm\classes\baseconfig::$uploadDir,        
        'image_versions' => array(
            'thumbnail' => array(
                'upload_dir' => \fpcm\classes\baseconfig::$uploadDir.'thumbs/',
                'upload_url' => \fpcm\classes\baseconfig::$uploadDir.'thumbs/',
                'crop'       => false,
                'max_width'  => $config->file_img_thumb_width,
                'max_height' => $config->file_img_thumb_height
            )            
        )        
    );

    require __DIR__.'/UploadHandler.php';
    $upload_handler = new UploadHandler($options);
?>