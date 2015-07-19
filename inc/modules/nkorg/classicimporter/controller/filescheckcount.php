<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class filescheckcount extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $db = $this->initDatabase();
            
            if (!$db) die('0');
            
            $res = $db->fetch($db->select('uploads'), true);
            die(json_encode($res));          
        }

    }
?>