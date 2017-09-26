<?php
    /**
     * FanPress CM 3.x
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\controller\traits\users;
    
    /**
     * Author image processing trait
     * 
     * @package fpcm\controller\traits\users\authorImages
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2017, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    trait authorImages {

        protected function uploadImage(\fpcm\model\users\author $author) {
            
            $files = \fpcm\classes\http::getFiles();

            if ($this->buttonClicked('uploadFile') && !is_null($files)) {
                $uploader = new \fpcm\model\files\fileuploader($files);
                $res = $uploader->processAuthorImageUpload($author->getImage());

                $this->cache->cleanup('authorImages', 'system');
                if ($res == true) {
                    $this->view->addNoticeMessage('SAVE_SUCCESS_UPLOADTPLFILE');
                    return true;
                }

                $this->view->addErrorMessage('SAVE_FAILED_UPLOADTPLFILE');
                return false;
            }
            
        }
        
        protected function deleteImage(\fpcm\model\users\author $author) {

            if (!$this->buttonClicked('fileDelete')) {
                return true;
            }

            $res = true;
            foreach (\fpcm\model\files\image::$allowedExts as $ext) {

                $filename = $author->getImage().'.'.$ext;
                $authorImage = new \fpcm\model\files\authorImage($filename);
                if (!$authorImage->exists()) {
                    continue;
                }

                $res = $res && $authorImage->delete();
            }
            
            $this->cache->cleanup('authorImages', 'system');
            if ($res == true) {
                $this->view->addNoticeMessage('DELETE_SUCCESS_FILEAUTHORIMG');
                return true;
            }

            $this->view->addErrorMessage('DELETE_FAILED_FILEAUTHORIMG');
            return false;
        }


    }
?>