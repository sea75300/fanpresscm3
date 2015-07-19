<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class articlescheckcount extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $db = $this->initDatabase();
            
            if (!$db) die('0');
            
            $res = $db->fetch($db->select('newsposts', 'id, titel, writtentime'), true);
            
            $res = array_map(array($this, 'utf8'), $res);
            
            $tempData = array();
            foreach ($res as $np) {
                $hash = md5(html_entity_decode(htmlspecialchars_decode(utf8_encode($np->titel))).'#'.$np->writtentime);
                $tempData[$hash] = $np->id;
            }
            
            $articleTempData = new \fpcm\model\files\tempfile('articleimportdata', json_encode($tempData));
            $articleTempData->save();
            
            die(json_encode($res));          
        }
        
        protected function utf8($row) {
            $row->titel = html_entity_decode(utf8_encode($row->titel));            
            return $row;
        }

    }
?>