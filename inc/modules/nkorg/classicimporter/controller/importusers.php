<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class importusers extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $db = $this->initDatabase();
            
            if (!$db) die('0');
            
            $data = $db->fetch($db->select('authors', '*'), true);

            $tmp = new \fpcm\model\files\tempfile(\fpcm\modules\nkorg\classicimporter\nkorgclassicimporter::mappingUser);
            
            $ids = array();
            
            $rmfile = new \fpcm\model\files\tempfile(\fpcm\modules\nkorg\classicimporter\nkorgclassicimporter::mappingRolls);
            $rollmapping = $rmfile->getContent();
            $rollmapping = json_decode($rollmapping, true);
            
            if ($rmfile->getFilesize() > 0 && !is_array($rollmapping)) {
                trigger_error('Unable to parse user roll mapping file');
                die('0');
            }            
            
            $tabName = \fpcm\classes\baseconfig::$fpcmDatabase->getDbprefix().'_'.\fpcm\classes\database::tableArticles;
            foreach ($data as $user) {
                $author = new \fpcm\model\users\author();
                
                $author->disablePasswordSecCheck();
                
                $author->setUserName(utf8_encode($user->sysusr));
                $author->setDisplayName(utf8_encode($user->name));
                $author->setEmail(utf8_encode($user->email));
                $author->setRegistertime($user->registertime);
                
                $roll = isset($rollmapping[$user->usrlevel]) ? $rollmapping[$user->usrlevel] : 3;
                
                $author->setRoll($roll);
                $author->setPassword(utf8_encode($user->sysusr));
                $author->setUserMeta(array());

                $res = $author->save();
                
                if ($res !== true) {
                    
                    if ($res == \fpcm\model\users\author::AUTHOR_ERROR_EXISTS) {
                        trigger_error('User import failed, user already exists: '.$author->getUsername());
                    }
                    else {
                        trigger_error('Unable to import user: '.$author->getUsername());
                    }
                    
                    continue;
                }
                
                $ids[$user->id] = \fpcm\classes\baseconfig::$fpcmDatabase->getLastInsertId($tabName);
            }
            
            if (!count($ids)) {
                \fpcm\classes\logs::syslogWrite('Classic Importer: No user ids found, maybe no users imported...');
                die('0');
            }
            
            $tmp->setContent(json_encode($ids));
            $tmp->save();
                
            die('1');
        }

    }
?>