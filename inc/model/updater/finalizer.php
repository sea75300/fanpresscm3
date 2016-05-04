<?php
    /**
     * System update finalizer object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\updater;

    /**
     * System Update Finalizer Objekt
     * 
     * @package fpcm.model.updater
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class finalizer extends \fpcm\model\abstracts\model {
        
        /**
         * Initialisiert System Update
         * @param int $init
         */
        public function __construct() {
            parent::__construct();
            
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
                   $this->addSystemOptions() &&
                   $this->updateSystemOptions() &&
                   $this->updatePermissions() &&
                   $this->checkFilesystem() &&
                   $this->updateVersion();
            
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
                
                if (!isset($permissions['system']['logs'])) {
                    $permissions['system']['logs'] = $groupId < 2 ? 1 : 0;
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
            
            $res = true;
            $res = $res && $this->config->add('comments_markspam_commentcount', 2);
            $res = $res && $this->config->add('system_loginfailed_locked', 5);
            $res = $res && $this->config->add('system_editor_fontsize', '12pt');
            $res = $res && $this->config->add('articles_acp_limit', 100);
            $res = $res && $this->config->add('system_updates_devcheck', (defined('FPCM_UPDATER_DEVCHECK') ? (int) FPCM_UPDATER_DEVCHECK : 0) );
            $res = $res && $this->config->add('system_updates_emailnotify', (defined('FPCM_UPDATE_CRONNOTIFY_EMAIL') ? (int) FPCM_UPDATE_CRONNOTIFY_EMAIL : 1) );
            
            return $res;

        }
        
        /**
         * System-Optionen bei Update aktualisieren
         * @return bool
         */
        private function updateSystemOptions() {
            
            $res = true;

            $newconf = array();
            if (count($newconf)) {
                $this->config->setNewConfig($newconf);
                $res = $res && $this->config->update();
            }
            
            return $res;
        }
        
        /**
         * Änderungen an Tabellen-Struktur vornehmen
         * @return bool
         */
        private function alterTables() {
            $res = true;
            
            if ($this->checkVersion('3.0.4')) {
                $res = $res && $this->dbcon->insert(\fpcm\classes\database::tableCronjobs, "`id`, `cjname`, `lastexec`", "7, 'dbBackup', 0");                
            }
            
            if ($this->checkVersion('3.1.4')) {
                $res = $res && $this->dbcon->insert(\fpcm\classes\database::tableCronjobs, "`id`, `cjname`, `lastexec`", "8, 'fileindex', 0");                
            }
            
            if ($this->checkVersion('3.1.0-rc1')) {
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableArticles, 'ADD', '`imagepath`', 'TEXT NOT NULL');
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableArticles, 'ADD INDEX', '( `title` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableArticles, 'ADD INDEX', '( `categories` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableArticles, 'ADD INDEX', '( `createuser` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableArticles, 'ADD INDEX', '( `createtime` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableArticles, 'ADD INDEX', '( `pinned` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableArticles, 'ADD INDEX', '( `postponed` )', '', false); 
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableArticles, 'ADD INDEX', '( `deleted` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableArticles, 'ADD INDEX', '( `approval` )', '', false);
                $res = $res && $this->dbcon->alter(\fpcm\classes\database::tableArticles, 'ADD INDEX', '( `draft` )', '', false);
            }
            
            if ($this->checkVersion('3.2.0-dev')) {
                
                if (method_exists($this->dbcon, 'getDbtype') && $this->dbcon->getDbtype() == 'pgsql') {
                    $res = $res && $this->dbcon->alter(
                        \fpcm\classes\database::tableCronjobs, 'ADD', '"execinterval"', '  BIGINT', false
                    );                    
                }
                else {
                    $res = $res && $this->dbcon->alter(
                        \fpcm\classes\database::tablePermissions, 'CHANGE', '`permissionData`', '`permissiondata` BLOB NOT NULL', false
                    );
                    $res = $res && $this->dbcon->alter(
                        \fpcm\classes\database::tablePermissions, 'CHANGE', '`rollId`', '`rollid` bigint(20) NOT NULL', false
                    );
                    $res = $res && $this->dbcon->alter(
                        \fpcm\classes\database::tableCategories, 'CHANGE', '`iconPath`', '`iconpath` text NOT NULL', false
                    );
                    $res = $res && $this->dbcon->alter(
                        \fpcm\classes\database::tableSessions, 'CHANGE', '`userId`', '`userid` BIGINT( 20 ) NOT NULL ', false
                    );
                    $res = $res && $this->dbcon->alter(
                        \fpcm\classes\database::tableSessions, 'CHANGE', '`sessionId`', '`sessionid` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ', false
                    );
                    $res = $res && $this->dbcon->alter(
                        \fpcm\classes\database::tableCronjobs, 'ADD', '`execinterval`', '  BIGINT( 20 ) NOT NULL', false
                    );
                }
                
                $rows = array(
                    'anonymizeIps'      => 2419200,
                    'clearLogs'         => 2419200,
                    'clearTemp'         => 604800,
                    'fmThumbs'          => 604800,
                    'postponedArticles' => 600,
                    'updateCheck'       => 86400,
                    'dbBackup'          => 604800,
                    'fileindex'         => 86400
                );
                
                foreach ($rows as $key => $value) {
                    $res = $res && $this->dbcon->update(\fpcm\classes\database::tableCronjobs, array('execinterval'), array($value, $key), "cjname = ? AND execinterval = 0");
                }
                
            }

            return $res;
        }
        
        /**
         * Neue Tabelle erzeugen
         * @return bool
         */
        private function createTables() {
            $res = true;
            
            if ($this->checkVersion('3.2.0-dev')) {
                
                $path = (method_exists($this->dbcon, 'getDbtype')
                      ? \fpcm\classes\baseconfig::$dbStructPath.$this->dbcon->getDbtype().'/14texts.sql'
                      : \fpcm\classes\baseconfig::$dataDir.'dbstruct/mysql/14texts.sql');                
                
                if (method_exists($this->dbcon, 'execSqlFile')) {
                    $res  = $res && $this->dbcon->execSqlFile($path);
                } else {
                    $sql = file_get_contents($path);
                    $sql = str_replace('{{dbpref}}', $this->dbcon->getDbprefix(), $sql);
                    $res = $res && $this->dbcon->exec($sql);
                }

            }
            
            return $res;
        }
        
        /**
         * Prüfung von Dateisystem-Strukturen
         * @return bool
         */
        private function checkFilesystem() {

            if (is_dir(\fpcm\classes\baseconfig::$dataDir.'dbstruct')) {
                \fpcm\model\files\ops::deleteRecursive(\fpcm\classes\baseconfig::$dataDir.'dbstruct');
            }
            
            if (file_exists(\fpcm\classes\baseconfig::$jsPath.'backupmgr.js')) {
                unlink(\fpcm\classes\baseconfig::$jsPath.'backupmgr.js');
            }
            
            $libPath = \fpcm\classes\loader::libGetFilePath('jquery', 'jquery-2.1.4.min.js');
            if ($libPath) {
                unlink($libPath);
            }
            
            $libPath = dirname(\fpcm\classes\loader::libGetFilePath('tinymce4', 'tinymce.min.js')).'/';
            if ($libPath === '/') {
                return true;
            }

            $paths = array(
                '/themes',
                '/plugins/advlist',
                '/plugins/anchor',
                '/plugins/autolink',
                '/plugins/autoresize',
                '/plugins/charmap',
                '/plugins/code',
                '/plugins/colorpicker',
                '/plugins/fullscreen',
                '/plugins/hr',
                '/plugins/image',
                '/plugins/imagetools',
                '/plugins/importcss',
                '/plugins/insertdatetime',
                '/plugins/link',
                '/plugins/lists',
                '/plugins/media',
                '/plugins/nonbreaking',
                '/plugins/searchreplace',
                '/plugins/table',
                '/plugins/textcolor',
                '/plugins/textpattern',
                '/plugins/visualchars',
                '/plugins/wordcount',
            );
            
            foreach ($paths as $path) {
                if (is_dir($libPath.$path)) \fpcm\model\files\ops::deleteRecursive($libPath.$path);
            }

            if (is_dir($libPath.'/readme.md')) {
                unlink($libPath.'/readme.md');
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