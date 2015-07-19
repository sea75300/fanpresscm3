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
        }
        
        /**
         * Führt abschließende Update-Schritte aus
         * @return bool
         */
        public function runUpdate() {
            $res = true &&
                   $this->alterTables() &&
                   $this->createTables() &&
                   $this->addSystemOptions() &&
                   $this->updateSystemOptions() &&
                   $this->updatePermissions() &&
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
            $res = $res && $this->config->add('system_maintenance', false);
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
            return $res;
        }
        
        /**
         * Neue Tabelle erzeugen
         * @return bool
         */
        private function createTables() {
            $res = true;
            return $res;
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