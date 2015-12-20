<?php
    /**
     * Permission object
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\system;

    /**
     * Permission handler Objekt
     * 
     * @package fpcm.model.system
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class permissions extends \fpcm\model\abstracts\model {

        /**
         * Rollen-ID
         * @var int
         */
        protected $rollId;

        /**
         * Berechtigungsdaten
         * @var array
         */
        protected $permissionData = array();
        
        /**
         * Nicht in Datenbank zu speichernde Daten
         * @var array
         */
        protected $dbExcludes = array('defaultPermissions', 'permissionSet');

        /**
         * Standard-Berechtigungsset für Anlegen einer neuen Gruppe
         * @var array
         */
        protected $defaultPermissions = array(
            'article' => array(
                'add'               => 1,
                'edit'              => 1,
                'editall'           => 0,
                'delete'            => 0,
                'archive'           => 0,
                'approve'           => 0,
                'revisions'         => 0
            ),
            'comment' => array(
                'edit'              => 1,
                'editall'           => 0,
                'delete'            => 0,
                'approve'           => 1,
                'private'           => 1
            ),
            'system' => array(
                'categories'        => 0,
                'options'           => 0,
                'users'             => 0,
                'rolls'             => 0,
                'permissions'       => 0,
                'templates'         => 0,
                'smileys'           => 0,
                'update'            => 0,
                'logs'              => 0
            ),
            'modules' => array(
                'install'           => 0,
                'uninstall'         => 0,
                'enable'            => 0,
                'configure'         => 0
            ),
            'uploads' => array(
                'add'               => 1,
                'delete'            => 0,
                'thumbs'            => 1,
                'rename'            => 0
            ),
        );

        /**
         * Standard-Berechtigungsset beim Aktualisieren der Brechtigungen
         * @var array
         */
        protected $permissionSet = array(
            'article' => array(
                'add'               => 0,
                'edit'              => 0,
                'editall'           => 0,
                'delete'            => 0,
                'archive'           => 0,
                'approve'           => 0,
                'revisions'         => 0
            ),
            'comment' => array(
                'edit'              => 0,
                'editall'           => 0,
                'delete'            => 0,
                'approve'           => 0,
                'private'           => 0
            ),
            'system' => array(
                'categories'        => 0,
                'options'           => 0,
                'users'             => 0,
                'rolls'             => 0,
                'permissions'       => 0,
                'templates'         => 0,
                'smileys'           => 0,
                'update'            => 0,
                'logs'              => 0
            ),
            'modules' => array(
                'install'           => 0,
                'uninstall'         => 0,
                'enable'            => 0,
                'configure'         => 0
            ),
            'uploads' => array(
                'add'               => 0,
                'delete'            => 0,
                'thumbs'            => 0,
                'rename'            => 0
            ),
        );

        /**
         * Konstruktor
         * @param int $rollid ID der Benutzerrolle
         * @return void
         */
        public function __construct($rollid = 0) {

            $this->table    = \fpcm\classes\database::tablePermissions;            
            parent::__construct();
            
            if (!$rollid) return;
            
            $this->rollId   = $rollid;            
            $this->init();
        }
        
        /**
         * Rollen-ID auslesen
         * @return int
         */
        function getRollId() {
            return $this->rollId;
        }

        /**
         * Berechtigungsdaten auslesen
         * @return array
         */
        function getPermissionData() {
            return json_decode($this->permissionData, true);
        }

        /**
         * Rollen-ID setzten
         * @param array $rollId
         */
        function setRollId($rollId) {
            $this->rollId = $rollId;
        }

        /**
         * Berechtigungsdaten setzten
         * @param array $permissionData
         */
        function setPermissionData(array $permissionData) {
            $this->permissionData = json_encode($permissionData);
        }

        /**
         * Berechtigungen initialisieren
         * @return void
         */
        protected function init() {
            $data = $this->dbcon->fetch($this->dbcon->select($this->table, '*', "rollid = ?", array($this->rollId)));

            if (!is_object($data)) return false;
            
            foreach ($data as $key => $value) { $this->$key = $value; }
            
            $this->permissionData = json_decode($this->permissionData, true);
        }
        
        /**
         * Speichert einen neuen Rechte-Datensatz in der Datenbank
         * @return boolean
         */        
        public function save() {
            $params = $this->getPreparedSaveParams();         
            $params = $this->events->runEvent('permissionsSave', $params);
            
            $res = $this->dbcon->insert($this->table, implode(',', array_keys($params)), '?, ?', array_values($params));
            
            $this->cache->cleanup();
            
            return $res;
        }

        /**
         * Aktualisiert einen Rechte-Datensatz in der Datenbank
         * @return boolean
         */        
        public function update() {
            $params     = $this->getPreparedSaveParams();
            $params     = $this->events->runEvent('permissionsUpdate', $params);
            
            $fields     = array_keys($params);
            
            $params[]   = $this->getRollId();

            $return     = false;
            if ($this->dbcon->update($this->table, $fields, array_values($params), 'rollId = ?')) {
                $return = true;
            }            
            
            $this->cache->cleanup();
            $this->init();
            
            return $return;            
        }
        
        /**
         * Löschen Berechtigungsdatensatz aus DB
         * @return boolean
         */
        public function delete() {
            $this->dbcon->delete($this->table, 'rollid = ?', array($this->rollId));            
            $this->cache->cleanup();
            
            return true;
        }
        
        /**
         * Prüft ob Benutzer Berechtigung hat
         * @param array $permissionArray
         * @return boolean
         */
        public function check(array $permissionArray) {                 
            $res = true;
            
            $permissionArray = $this->events->runEvent('permissionsCheck', $permissionArray);

            foreach ($permissionArray as $module => $permission) {
                if (!isset($this->permissionData[$module])) {
                    trigger_error("No permissions available  for module \"$module\"!");
                    return false;
                }
                
                if (is_array($permission)) {
                    foreach ($permission as $permissionItem) {
                        $itemCheck = isset($this->permissionData[$module][$permissionItem]) ? $this->permissionData[$module][$permissionItem] : false;
                                                
                        $check = isset($check)
                               ? ($check || $itemCheck)
                               : $itemCheck;
                    }
                } else {
                    $check  = isset($this->permissionData[$module][$permission]) ? $this->permissionData[$module][$permission] : false;                    
                }
                
                $res    = $res && $check;
            }
            
            return $res;
        }
        
        /**
         * Initialisiert Berechtigungen mit Standardwerten
         * @param int $rollId
         * @return bool
         */
        public function addDefault($rollId) {            
            $this->setRollId($rollId);
            $this->setPermissionData($this->defaultPermissions);

            return $this->save();            
        }
        
        /**
         * Gibt leeren Standard-Berechtigungsset zurück
         * @return array
         */
        public function getPermissionSet() {
            return $this->permissionSet;
        }
                
        /**
         * Gibt Array mit allen Berechtigungsdatensätzen zurück
         * @return array
         */
        public function getPermissionsAll() {           
            $datasets = $this->dbcon->fetch($this->dbcon->select($this->table, 'rollid, permissionData'));
            
            $res = array();
            foreach ($datasets as $dataset) {
                $res[$dataset->rollid] = json_decode($dataset->permissionData, true);
            }
            
            $res = $this->events->runEvent('permissionsGetAll', $res);
            
            return $res;
            
        }
        
    }
