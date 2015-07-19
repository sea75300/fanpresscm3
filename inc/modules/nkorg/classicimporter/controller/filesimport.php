<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class filesimport extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $filename = $this->getRequestVar('file');
            $id       = $this->getRequestVar('id');            
            
            $db = $this->initDatabase();
            
            if (!$db) die('0');
            
            $file = $db->fetch($db->select('uploads', '*', "id = {$id} AND filename = '{$filename}'"));

            if (!$file) {
                usleep(1500);
                die('0');
            }
            
            $img = new \fpcm\model\files\image($file->filename);
            $img->setFiletime($file->uploadtime);
            $img->setUserid($file->uploaderid);
            
            if (!$img->save()) {
                usleep(1500);
                die('0');
            }
            
            $src  = $this->fpcm2Path.'/data/upload/'.$file->filename;
            $dest = \fpcm\classes\baseconfig::$uploadDir.$file->filename;
            
            if (!file_exists($src)) {
                trigger_error("Unable to copy smiley file {$src} to {$dest}, source file not found...");
                die('0');
            }
            
            if (file_exists($dest)) {
                trigger_error("Unable to copy smiley file {$src} to {$dest}, destination file already exists...");
                die('0');
            }
            
            if (!copy($src, $dest)) {
                trigger_error("Unable to copy smiley file {$src} to {$dest}...");
                die('0');
            }                        
            
            sleep(1);
            die('1');
            
        }

    }
?>