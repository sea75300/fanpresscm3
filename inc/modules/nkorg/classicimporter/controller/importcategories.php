<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class importcategories extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $db = $this->initDatabase();
            
            if (!$db) die('0');
            
            $data = $db->fetch($db->select('categories', '*'), true);

            $tmp = new \fpcm\model\files\tempfile(\fpcm\modules\nkorg\classicimporter\nkorgclassicimporter::mappingCategories);
            
            $rmfile = new \fpcm\model\files\tempfile(\fpcm\modules\nkorg\classicimporter\nkorgclassicimporter::mappingRolls);
            $rollmapping = $rmfile->getContent();
            $rollmapping = json_decode($rollmapping, true);
            
            if ($rmfile->getFilesize() > 0 && !is_array($rollmapping)) {
                trigger_error('Unable to parse user roll mapping file');
                die('0');
            }             
            
            $ids = array();            
            foreach ($data as $cat) {
                
                $category = new \fpcm\model\categories\category();
                $category->setName(utf8_encode($cat->catname));
                $category->setIconPath(utf8_encode($cat->icon_path));
                $group = isset($rollmapping[$cat->minlevel]) ? $rollmapping[$cat->minlevel] : 1;
                $category->setGroups($group);

                $res = $category->save();
                
                if (!$res) {
                    trigger_error('Unable to import category "'.utf8_encode($cat->catname).'", maybe it already exists. Continue...');
                    continue;
                }
                
                $ids[$cat->id] = \fpcm\classes\baseconfig::$fpcmDatabase->getLastInsertId();
            }
            
            if (!count($ids)) {
                \fpcm\classes\logs::syslogWrite('Classic Importer: No category ids found, maybe no categories imported...');
                die('0');
            }
            
            $tmp->setContent(json_encode($ids));
            $tmp->save();
                
            die('1');
        }

    }
?>