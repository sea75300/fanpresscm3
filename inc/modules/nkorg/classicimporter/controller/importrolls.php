<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class importrolls extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $db = $this->initDatabase();
            
            if (!$db) die('0');
            
            $tmp = new \fpcm\model\files\tempfile(\fpcm\modules\nkorg\classicimporter\nkorgclassicimporter::mappingRolls);
            
            $data = $db->fetch($db->select('usrlevels', '*', 'id > 3'), true);
            
            $ids = array();            
            foreach ($data as $lvl) {
                $roll = new \fpcm\model\users\userRoll();
                $roll->setRollName(utf8_encode($lvl->leveltitle));
                
                if (!$roll->save()) {
                    trigger_error('Unable to import user roll: '.$lvl->leveltitle);
                    continue;
                }
                
                $res = \fpcm\classes\baseconfig::$fpcmDatabase->fetch(\fpcm\classes\baseconfig::$fpcmDatabase->select(\fpcm\classes\database::tableRoll, 'MAX(id) as newid'));
                $ids[$lvl->id] = $res->newid;
            }
            
            if (!count($ids)) {
                fpcmLogSystem('Classic Importer: No user roll ids found, maybe no user rolls imported...');
                die('0');
            }
            
            $tmp->setContent(json_encode($ids));
            $tmp->save();
                
            die('1');
        }

    }
?>