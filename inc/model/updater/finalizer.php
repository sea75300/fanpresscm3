<?php
    /**
     * System update finalizer object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\updater;

    /**
     * System Update Finalizer Objekt
     * 
     * @package fpcm\model\updater
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class finalizer extends \fpcm\model\abstracts\model {
        
        /**
         * Initialisiert System Update
         * @param int $init
         */
        public function __construct() {
            parent::__construct();
            
            $this->dbcon  = new \fpcm\classes\database();
            $this->config = new \fpcm\model\system\config(false, false);
        }
        
        /**
         * Führt abschließende Update-Schritte aus
         * @return bool
         */
        public function runUpdate() {
            $res = true &&
                   $this->createTables() &&
                   $this->alterTables() &&
                   $this->removeSystemOptions() &&
                   $this->addSystemOptions() &&
                   $this->updateSystemOptions() &&
                   $this->updatePermissions() &&
                   $this->checkFilesystem() &&
                   $this->updateVersion() &&
                   $this->optimizeTables();
            
            $crypt = new \fpcm\classes\crypt();
            $res = true && $crypt->initCrypt();

            $this->config->setMaintenanceMode(false);

            return $res;
        }
        
        /**
         * aktualisiert Versionsinfos in Datenbank
         * @return bool
         */
        private function updateVersion() {
            include_once \fpcm\classes\baseconfig::$versionFile;
            $this->config->setNewConfig(array('system_version' => $fpcmVersion));
            return $this->config->update();            
        }
        
        /**
         * aktualisiert Berechtigungen
         * @return boolean
         */
        private function updatePermissions() {

            $res = true;
            
            $permission = new \fpcm\model\system\permissions();
            $data = $permission->getPermissionsAll();

            foreach ($data as $groupId => &$permissions) {
                
                if (!isset($permissions['article']['revisions'])) {
                    $permissions['article']['revisions'] = $groupId < 3 ? 1 : 0;
                }
                
                if (!isset($permissions['article']['authors'])) {
                    $permissions['article']['authors'] = $groupId < 2 ? 1 : 0;
                }
                
                if (!isset($permissions['system']['logs'])) {
                    $permissions['system']['logs'] = $groupId < 2 ? 1 : 0;
                }
                
                if (!isset($permissions['system']['crons'])) {
                    $permissions['system']['crons'] = $groupId < 2 ? 1 : 0;
                }
                
                if (!isset($permissions['system']['backups'])) {
                    $permissions['system']['backups'] = $groupId < 2 ? 1 : 0;
                }
                
                if (!isset($permissions['system']['wordban'])) {
                    $permissions['system']['wordban'] = $groupId < 3 ? 1 : 0;
                }
                
                if (!isset($permissions['system']['ipaddr'])) {
                    $permissions['system']['ipaddr'] = $groupId < 2 ? 1 : 0;
                }
                
                if (!isset($permissions['uploads']['visible'])) {
                    $permissions['uploads']['visible'] = 1;
                }

                $permission->setPermissionData($permissions);
                $permission->setRollId($groupId);
                $res = $res && $permission->update();
            }
            
            return $res;            
        }

        /**
         * neue System-Optionen bei Update erzeugen
         * @return bool
         */
        private function addSystemOptions() {

            $yatdl = new \fpcm\model\system\yatdl(\fpcm\classes\baseconfig::$dbStructPath.'06config.yml');
            $yatdl->parse();

            $data = $yatdl->getArray();

            if (!isset($data['defaultvalues']['rows']) || !count($data['defaultvalues']['rows'])) {
                return true;
            }

            $res = true;
            foreach ($data['defaultvalues']['rows'] as $option) {
                $res = $res && $this->config->add($option['config_name'], $option['config_value']);
            }

            return $res;

        }
        
        /**
         * System-Optionen bei Update aktualisieren
         * @return bool
         */
        private function updateSystemOptions() {
            
            $res = true;

            $newconf = [];
            if (!is_array($this->config->twitter_data)) {
                $newconf['twitter_data'] = array(
                    'consumer_key'    => '',
                    'consumer_secret' => '',
                    'user_token'      => '',
                    'user_secret'     => ''
                );
                
                $newconf['twitter_data'] = json_encode($newconf['twitter_data']);
            }
            
            if (!is_array($this->config->twitter_events)) {
                $newconf['twitter_events'] = array('create' => 0, 'update' => 0);
                $newconf['twitter_events'] = json_encode($newconf['twitter_events']);
            }

            if (!isset($this->config->smtp_settings['addr'])) {
                $newconf['smtp_settings']         = $this->config->smtp_settings;
                $newconf['smtp_settings']['addr'] = '';
                $newconf['smtp_settings']         = json_encode($newconf['smtp_settings']);
            }

            if (count($newconf)) {
                $this->config->setNewConfig($newconf);
                $res = $res && $this->config->update();
            }
            
            return $res;
        }
        
        /**
         * System-Optionen bei Update aktualisieren
         * @return bool
         */
        private function removeSystemOptions() {
            
            if ($this->config->files_img_thumb_minwidth === false && $this->config->files_img_thumb_minheight === false) {
                return true;
            }
            
            $res = true;
            $res = $res && $this->config->remove('files_img_thumb_minwidth');
            $res = $res && $this->config->remove('files_img_thumb_minheight');
            
            return $res;
        }
        
        /**
         * Änderungen an Tabellen-Struktur vornehmen
         * @return bool
         */
        private function alterTables() {

            $res = true;

            if ($this->checkVersion('3.3.0-a1') && (!method_exists($this->dbcon, 'getDbtype') || $this->dbcon->getDbtype() == 'mysql')) {
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableComments, 'ADD INDEX', '( `name` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableComments, 'ADD INDEX', '( `email` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableComments, 'ADD INDEX', '( `website` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableComments, 'ADD INDEX', '( `private` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableComments, 'ADD INDEX', '( `approved` )', '', false); 
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableComments, 'ADD INDEX', '( `spammer` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableComments, 'ADD INDEX', '( `createtime` )', '', false);
                
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableCronjobs, 'ADD UNIQUE', '( `cjname` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableCronjobs, 'ADD INDEX', '( `lastexec` )', '', false);
            }

            if ($this->checkVersion('3.3.0-rc6') && (!method_exists($this->dbcon, 'getDbtype') || $this->dbcon->getDbtype() == 'mysql')) {
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableConfig, 'ADD UNIQUE', '( `config_name` )', '', false);
            }

            if (method_exists($this->dbcon, 'getDbtype') && $this->checkVersion('3.3.0-rc6') && $this->dbcon->getDbtype() == 'pgsql') {

                $data =   'CREATE INDEX '.$this->dbcon->getDbprefix().'_comments_name ON '.$this->dbcon->getDbprefix().'_comments USING btree (name);'
                        . 'CREATE INDEX '.$this->dbcon->getDbprefix().'_comments_email ON '.$this->dbcon->getDbprefix().'_comments USING btree (email);'
                        . 'CREATE INDEX '.$this->dbcon->getDbprefix().'_comments_website ON '.$this->dbcon->getDbprefix().'_comments USING btree (website);'
                        . 'CREATE INDEX '.$this->dbcon->getDbprefix().'_comments_private ON '.$this->dbcon->getDbprefix().'_comments USING btree (private);'
                        . 'CREATE INDEX '.$this->dbcon->getDbprefix().'_comments_approved ON '.$this->dbcon->getDbprefix().'_comments USING btree (approved);'
                        . 'CREATE INDEX '.$this->dbcon->getDbprefix().'_comments_spammer ON '.$this->dbcon->getDbprefix().'_comments USING btree (spammer);'
                        . 'CREATE INDEX '.$this->dbcon->getDbprefix().'_comments_createtime ON '.$this->dbcon->getDbprefix().'_comments USING btree (createtime);'

                        . 'CREATE UNIQUE INDEX '.$this->dbcon->getDbprefix().'_cronjobs_cjname ON '.$this->dbcon->getDbprefix().'_cronjobs USING btree (cjname);'
                        . 'CREATE INDEX '.$this->dbcon->getDbprefix().'_cronjobs_lastexec ON '.$this->dbcon->getDbprefix().'_cronjobs USING btree (lastexec);'
                
                        . 'CREATE UNIQUE INDEX '.$this->dbcon->getDbprefix().'_config_config_name ON '.$this->dbcon->getDbprefix().'_config USING btree (config_name);';

                $path = \fpcm\classes\baseconfig::$tempDir.'indices.sql';
                file_put_contents($path, $data);

                $res = $res && $this->dbcon->execSqlFile($path);
                
                unlink($path);
            }
            
            if (!method_exists($this->dbcon, 'checkTableStructure')) {
                return $res;
            }

            $files = \fpcm\classes\database::getTableFiles();
            foreach ($files as $file) {
                $this->dbcon->checkTableStructure(basename($file, '.yml'));
            }
            
            if ($this->checkVersion('3.4.0-b2')) {
                $res = $res && $this->dbcon->insert(\fpcm\classes\database::tableCronjobs, "cjname, lastexec, execinterval", "'removeRevisions', 0, 2419200");                
            }
            
            if ($this->checkVersion('3.4.0-b5')) {
                $this->dbcon->createIndex(\fpcm\classes\database::tableRevisions, 'hashsum_idx', 'hashsum');
            }
            
            if ($this->checkVersion('3.4.0-b6', '=')) {
                $this->dbcon->alter(\fpcm\classes\database::tableFiles, 'DROP', 'subfolder', '', false);
            }
            
            if ($this->checkVersion('3.5.0')) {
                $this->dbcon->update(\fpcm\classes\database::tableTexts, array('replacetxt'), array(1), 'replacetxt = 0');
            }

            return $res;
        }
        
        /**
         * Neue Tabelle erzeugen
         * @return bool
         */
        private function createTables() {

            $res = true;
            
            if ($this->checkVersion('3.3.0-a4')) {
                
                if (method_exists($this->dbcon, 'execYaTdl')) {
                    $res = $res && $this->dbcon->execYaTdl(\fpcm\classes\baseconfig::$dbStructPath.'15revisions.yml');
                }
                else {
                    $res = $res && $this->execYaTdl(\fpcm\classes\baseconfig::$dataDir.'dbstruct/15revisions.yml');                    
                }
                
                $this->convertRevisions();
            }

            return $res;
        }
        
        /**
         * Prüfung von Dateisystem-Strukturen
         * @return bool
         */
        private function checkFilesystem() {

            $fbPath = \fpcm\classes\loader::libGetFileUrl('fancybox');
            
            $files = [
                \fpcm\classes\baseconfig::$viewsDir.'logs/cronjobs.php',
                \fpcm\classes\baseconfig::$viewsDir.'articles/lists/cronjobs.php',
                \fpcm\classes\baseconfig::$jsPath.'editor_comments.js',
                \fpcm\classes\baseconfig::$incDir.'lib/jquery/jquery-2.2.0.min.js',
                \fpcm\classes\baseconfig::$incDir.'lib/jquery/jquery-3.1.0.min.js',
                $fbPath.'blank.gif',
                $fbPath.'fancybox_loading.gif',
                $fbPath.'fancybox_loading@2x.gif',
                $fbPath.'fancybox_overlay.png',
                $fbPath.'fancybox_sprite.png',
                $fbPath.'fancybox_sprite@2x.png',
                $fbPath.'jquery.fancybox.css',
                $fbPath.'jquery.fancybox.pack.js'
            ];

            foreach ($files as $file) {

                if (!file_exists($file)) continue;
                unlink($file);

            }
            
            \fpcm\model\files\ops::deleteRecursive(dirname(\fpcm\classes\loader::libGetFilePath('spinjs', 'spin.min.js')));
            
            return true;
        }
        
        /**
         * Führt Optimierung der Datenbank-Tabellen durch
         * @since FPCM 3.3
         * @return boolean
         */
        private function optimizeTables() {

            if (!method_exists($this->dbcon, 'optimize')) {
                return true;
            }

            $tables   = [];
            $tables[] = \fpcm\classes\database::tableArticles;
            $tables[] = \fpcm\classes\database::tableAuthors;
            $tables[] = \fpcm\classes\database::tableCategories;
            $tables[] = \fpcm\classes\database::tableComments;
            $tables[] = \fpcm\classes\database::tableConfig;
            $tables[] = \fpcm\classes\database::tableCronjobs;
            $tables[] = \fpcm\classes\database::tableFiles;
            $tables[] = \fpcm\classes\database::tableIpAdresses;
            $tables[] = \fpcm\classes\database::tableModules;
            $tables[] = \fpcm\classes\database::tablePermissions;
            $tables[] = \fpcm\classes\database::tableRoll;
            $tables[] = \fpcm\classes\database::tableSessions;
            $tables[] = \fpcm\classes\database::tableSmileys;
            $tables[] = \fpcm\classes\database::tableTexts;
            $tables[] = \fpcm\classes\database::tableRevisions;
            
            $tables = $this->events->runEvent('updaterAddOptimizeTables', $tables);
            foreach ($tables as $table) {
                $this->dbcon->optimize($table);
            }

            return true; 
        }

        /**
         * Prüft System-Version auf bestimmten Wert
         * @param string $version
         * @param string $option
         * @return bool
         * @since FPCM 3.2
         */
        private function checkVersion($version, $option = '<') {
            return version_compare($this->config->system_version, $version, $option);
        }

        /**
         * Revisionen von Dateisystem nach DB-Tabelle konvertieren
         * @return boolean
         * @since FPCM 3.3
         */
        private function convertRevisions() {

            $revsPath = \fpcm\classes\baseconfig::$revisionDir.'article';
            $revisionFiles = glob($revsPath.'*/*.php');
            
            if (!$revisionFiles || !count($revisionFiles)) {
                return true;
            }

            foreach ($revisionFiles as $revisionFile) {
                
                $articleId   = (int) substr(basename(dirname($revisionFile)), 7);
                $revisionIdx = (int) substr(basename($revisionFile), 3, -4);
                $revision    = new \fpcm\model\files\revision($revisionIdx, $revsPath.$articleId.'/');

                if (!$revision->exists()) {
                    continue;;
                }

                $newRevision = new \fpcm\model\articles\revision();
                $newRevision->setArticleId($articleId);
                $newRevision->setRevisionIdx($revisionIdx);
                $newRevision->setContent($revision->getContent());
                if (!$newRevision->save()) {
                    trigger_error("Revision conversion failure for revision {$revisionIdx} of article {$articleId}");
                    continue;
                }
            }
            
            return true;

        }

                /**
         * nicht genutzt
         * @return void
         */
        public function save() {
            return;
        }

        /**
         * nicht genutzt
         * @return void
         */
        public function update() {
            return;
        }

        /**
         * nicht genutzt
         * @return void
         */
        public function delete() {
            return;
        }

        /**
         * nicht genutzt
         * @return void
         */
        public function exists() {
            return;
        }        
        
    }
?>