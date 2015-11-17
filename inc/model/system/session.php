<?php
    /**
     * Session object
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\system;

    /**
     * Session Objekt
     * 
     * @package fpcm.model.system
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class session extends \fpcm\model\abstracts\model {

        /**
         * Session-ID
         * @var string
         */
        protected $sessionId;
        
        /**
         * Benutzer-ID
         * @var int
         */
        protected $userId;

        /**
         * Login-Zeit
         * @var int
         */
        protected $login;
        
        /**
         * Logout-Zeit
         * @var int
         */
        protected $logout;
        
        /**
         * Letzte Aktualisierung
         * @var int
         */
        protected $lastaction;
        
        /**
         * IP-Adresse der Session
         * @var string
         */
        protected $ip;
        
        /**
         * Existiert Session
         * @var bool
         */
        protected $sessionExists  = false;
        
        /**
         * Klassen-Eigenschaften, die nicht gespeichert werden sollen
         * @var array
         */
        protected $dbExcludes = array('sessionExists', 'currentUser', 'permissions');
        
        /**
         * Aktueller Benutzer
         * @var \fpcm\model\users\author
         */
        public $currentUser;

        /**
         * Initialisiert Session
         * @param int $init
         */
        public function __construct($init = true) {
            parent::__construct();
            
            $this->table    = \fpcm\classes\database::tableSessions;
            
            if (!is_object($this->config)) {
                $this->config = new config(false);
            }

            if ($init && !is_null(\fpcm\classes\security::getSessionCookieValue())) {                
                $this->sessionId = \fpcm\classes\security::getSessionCookieValue();            
                $this->init();
                
                if ($this->sessionExists) {                    
                    if (!defined('FPCM_USERID')) {
                        /**
                         * ID des aktuellen Benutzers, nur verfügbar wenn Session existiert
                         */
                        define('FPCM_USERID', $this->userId);
                    }
                    
                    $this->currentUser = new \fpcm\model\users\author($this->userId);
                    if ($this->lastaction <= time() - 60) {
                        $this->lastaction  = time();
                        $this->update();
                    }
                }               
            }
        }
        
        /**
         * Session-ID-String zurückgeben
         * @return string
         */
        public function getSessionId() {
            return $this->sessionId;
        }

        /**
         * ID des aktuellen Benutzers
         * @return int
         */
        public function getUserId() {
            return (int) $this->userId;
        }

        /**
         * Login-Zeit zurückgeben
         * @return int
         */
        public function getLogin() {
            return (int) $this->login;
        }

        /**
         * Logout-Zeit zurückgeben
         * @return int
         */
        public function getLogout() {
            return (int) $this->logout;
        }

        /**
         * Zeit der letzten Aktion +/- 60sec
         * @return int
         */
        public function getLastaction() {
            return (int) $this->lastaction;
        }

        /**
         * IP-Adresse des aktuellen Benutzers
         * @return string
         */
        public function getIp() {
            return $this->ip;
        }

        /**
         * Session-ID-String setzten
         * @param string $sessionId
         */
        public function setSessionId($sessionId) {
            $this->sessionId = $sessionId;
        }

        /**
         * Benutzer-ID setzten
         * @param int $userId
         */
        public function setUserId($userId) {
            $this->userId = (int) $userId;
        }

        /**
         * Login-Zeit setzten
         * @param int $login
         */
        public function setLogin($login) {
            $this->login = (int) $login;
        }

        /**
         * Logout-Zeit setzten
         * @param int $logout
         */
        public function setLogout($logout) {
            $this->logout = (int) $logout;
        }

        /**
         * Zeitpunkt letzter Aktion setzten
         * @param int $lastaction
         */
        public function setLastaction($lastaction) {
            $this->lastaction = (int) $lastaction;
        }

        /**
         * IP-Adresse setzten
         * @param string $ip
         */
        public function setIp($ip) {
            $this->ip = $ip;
        }

        /**
         * Session-Status setzten
         * @param bool $sessionExists
         */
        public function setSessionExists($sessionExists) {
            $this->sessionExists = $sessionExists;
        }
        
        /**
         * Gibt aktuellen Benutzer dieser Session zurück
         * @return \fpcm\model\users\author
         */
        public function getCurrentUser() {
            return $this->currentUser;
        }

        /**
         * Prüft, ob Session existiert
         * @return bool
         */
        public function exists() {
            return (bool) $this->sessionExists;
        }        
        
        /**
         * Speichert
         * @return void
         */
        public function save() {
            $params = $this->getPreparedSaveParams();
            $params = $this->events->runEvent('sessionCreate', $params);
            
            $value_params = $this->getPreparedValueParams();

            $return = false;
            if ($this->dbcon->insert($this->table, implode(',', array_keys($params)), implode(', ', $value_params), array_values($params))) {
                $return = true;
            }
            
            return $return;            
        }
        
        /**
         * Aktualisiert
         * @return void
         */
        public function update() {
            $params     = $this->getPreparedSaveParams();
            $fields     = array_keys($params);
            
            $params[]   = $this->getSessionId();
            $params     = $this->events->runEvent('sessionUpdate', $params);

            $return = false;
            if ($this->dbcon->update($this->table, $fields, array_values($params), 'sessionId LIKE ?')) {
                $return = true;
            }
            
            $this->init();
            
            return $return;             
        }

        /**
         * not used
         * @return void
         */
        public function delete() {
            return;
        }
        
        /**
         * Prüft ob Kombination Benutzer und Passwort existiert
         * @param string $username
         * @param string $password
         * @return bool Ja, wenn Benutzer + Passwort vorhanden ist
         */
        public function checkUser($username, $password) {
            $userList = new \fpcm\model\users\userList();            

            $userId = $userList->getUserIdByUsername($username);
            if (!$userId) {
                trigger_error('Login failed for username '.$username.'! User not found. Request was made by '.\fpcm\classes\http::getIp());
                return false;
            }
            
            $user = new \fpcm\model\users\author($userId);
            if ($user->getDisabled()) {
                trigger_error('Login failed for username '.$username.'! User is disabled. Request was made by '.\fpcm\classes\http::getIp());
                return \fpcm\model\users\author::AUTHOR_ERROR_DISABLED;
            }
            
            if (\fpcm\classes\security::createPasswordHash($password, $user->getPasswd()) == $user->getPasswd()) {
                
                $timer = time();
                
                $this->login         = $timer;
                $this->lastaction    = $timer;
                $this->logout        = 0;
                $this->userId        = $userId;
                $this->sessionId     = \fpcm\classes\security::createSessionId();
                $this->ip            = \fpcm\classes\http::getIp();
                $this->sessionExists = true;
                
                return true;
            }
            
            trigger_error('Login failed for username '.$username.'! Wrong username or password. Request was made by '.\fpcm\classes\http::getIp());
            
            return false;
            
        }
        
        /**
         * Setzt Login-Cookie
         * @return bool
         */
        public function setCookie() {       
            $expire = $this->getLogin() + $this->config->system_session_length;
            return setcookie(\fpcm\classes\security::getSessionCookieName(),$this->sessionId,$expire,'/','',false,true);
        }
                
        /**
         * Löscht Cookie
         * @return bool
         */
        public function deleteCookie() {       
            $expire = $this->getLogin() - ($this->config->system_session_length * 5);
            return setcookie(\fpcm\classes\security::getSessionCookieName(),0,$expire,'/','',false,true);
        }
        
        /**
         * Gibt gespeicherte Session-Informationen zurück
         * @return array
         */
        public function getSessions() {
            $sessions = array();
            
            $listItems = $this->dbcon->fetch($this->dbcon->select($this->table, '*', "sessionId NOT LIKE ?", array($this->sessionId)), true);
            
            if (!$listItems) return $sessions;
            
            foreach ($listItems as $listItem) {
                $sessionItem = new session(false);
                $sessionItem->createFromDbObject($listItem);
                
                $sessions[] = $sessionItem;
            }
            
            return $sessions;
        }
        
        /**
         * Sessions löschen
         * @return bool
         */
        public function clearSessions() {
            return $this->dbcon->delete($this->table, "sessionId NOT LIKE ? AND lastaction < ?", array($this->sessionId, time()));
        }

        /**
         * Inittiert Objekt mit Daten aus der Datenbank, sofern ID vergeben wurde
         */
        protected function init() {
            
            $lastaction = time() + $this->config->system_session_length;
            $data = $this->dbcon->fetch($this->dbcon->select($this->table, '*', "sessionId = ? AND logout = 0 AND lastaction <= ? ".$this->dbcon->limitQuery(0, 1), array($this->sessionId, $lastaction)));
            
            if ($data === false) {
                $this->sessionExists = false;
                return;
            }
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }            
            $this->sessionExists = true;
        }
        
    }
?>