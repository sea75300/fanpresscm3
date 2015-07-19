<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class resetSystem extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $res = true;
            $db  = \fpcm\classes\baseconfig::$fpcmDatabase;            
            $res = $res && $db->delete(\fpcm\classes\database::tableAuthors, 'id != ?', array($this->session->getUserId()));
            $res = $res && $db->delete(\fpcm\classes\database::tableRoll, 'id > 3');
            $res = $res && $db->delete(\fpcm\classes\database::tablePermissions, 'rollid > 3');
            $res = $res && $db->delete(\fpcm\classes\database::tableCategories, 'id > 1');
            $res = $res && $db->delete(\fpcm\classes\database::tableArticles, 'id > 0');
            $res = $res && $db->delete(\fpcm\classes\database::tableComments, 'id > 0');

            if (!$res) {
                die('0');
            }
            
            die('1');
            
        }

    }
?>