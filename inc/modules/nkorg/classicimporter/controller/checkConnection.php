<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class checkConnection extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();
            
            $res = is_dir($this->fpcm2Path) && is_dir($this->fpcm2Path.'/data/') && file_exists($this->fpcm2Path.'/inc/config.php') && file_exists($this->fpcm2Path.'/version.php');

            if (!$res) {
                trigger_error('FanPress CM 2.5 config file not found in "'.$this->fpcm2Path.'/inc/config.php"');
                die(0);
            }
            
            include_once $this->fpcm2Path.'/version.php';            
            if (version_compare($fpcmVersion, '2.5.0','<')) {
                die('2');
            }
            
            if (!is_object($this->initDatabase())) {
                die(0);
            }    
            
            die('1');            
        }

    }
?>