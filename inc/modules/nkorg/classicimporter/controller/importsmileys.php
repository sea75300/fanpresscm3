<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class importsmileys extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $db = $this->initDatabase();
            
            if (!$db) die('0');
            
            $data = $db->fetch($db->select('smilies', '*'), true);
            
            foreach ($data as $value) {
                
                $smiley = new \fpcm\model\files\smiley();
                $smiley->setSmileycode($value->sml_code);
                $smiley->setFilename($value->sml_filename);
                
                if ($smiley->exists() || !$smiley->save()) {
                    trigger_error('Unable to create smiley entry in database or smiley already exists.');
                    continue;
                }
                
                $src = $this->fpcm2Path.'/img/smilies/'.$value->sml_filename;
                
                if (!file_exists($src)) continue;

                $dest = \fpcm\classes\baseconfig::$smileyDir.$value->sml_filename;
                
                if (!copy($src, $dest)) {
                    trigger_error("Unable to copy smiley file {$src} to {$dest}...");
                }
            }
                
            die('1');
        }

    }
?>