<?php
    /**
     * IP address object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\ips;

    /**
     * IP-Adressen Objekt
     * 
     * @package fpcm.model.system
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class ipaddress extends \fpcm\model\abstracts\model {

        /**
         * IP-Adresse
         * @var string
         */
        protected $ipaddress;
        
        /**
         * Zeit der Sperrung der IP-Adresse
         * @var int
         */
        protected $iptime;

        /**
         * Benutzer, der die IP-Adresse gesperrt hat
         * @var int
         */
        protected $userid;

        /**
         * IP-Adresse für Kommentare gesperrt
         * @var bool
         */
        protected $nocomments = 1;

        /**
         * IP-Adresse für ACP-Login gesperrt
         * @var bool
         */
        protected $nologin = 0;

        /**
         * IP-Adresse für allgemeinen Zugriff gesperrt
         * @var bool
         */
        protected $noaccess = 0;

        /**
         * Konstruktor
         * @param int $id
         */
        public function __construct($id = null) {
            
            $this->table    = \fpcm\classes\database::tableIpAdresses;
            
            parent::__construct($id);
        }
        
        /**
         * Gibt gesperrte IP-Adresse zurück
         * @return string
         */
        public function getIpaddress() {
            return $this->ipaddress;
        }

        /**
         * Gibt Zeitpunkt der Sperrung zurück
         * @return int
         */
        public function getIptime() {
            return $this->iptime;
        }

        /**
         * Benutzer, der die Sperrung ausgeführt hat
         * @return int
         */
        public function getUserid() {
            return $this->userid;
        }

        /**
         * Sperrung für Kommentare
         * @return bool
         */
        public function getNocomments() {
            return $this->nocomments;
        }

        /**
         * Sperrung für ACP-Login
         * @return bool
         */
        public function getNologin() {
            return $this->nologin;
        }

        /**
         * Sperrung für allgemeinen Zugriff auf ACP & Frontend
         * @return bool
         */
        public function getNoaccess() {
            return $this->noaccess;
        }

        /**
         * Setter für zu sperrende IP
         * @param string $ipaddress
         */
        public function setIpaddress($ipaddress) {
            $this->ipaddress = $ipaddress;
        }

        /**
         * Setter für Sperrzeitpunkt
         * @param int $iptime
         */
        public function setIptime($iptime) {
            $this->iptime = $iptime;
        }

        /**
         * Setter für sperrenden Benutzer
         * @param int $userid
         */
        public function setUserid($userid) {
            $this->userid = $userid;
        }

        /**
         * Setter für Kommentar-Sperre
         * @param bool $nocomments
         */
        public function setNocomments($nocomments) {
            $this->nocomments = $nocomments;
        }

        /**
         * Setter für ACP-Login-Sperre
         * @param bool $nologin
         */
        public function setNologin($nologin) {
            $this->nologin = $nologin;
        }

        /**
         * Setter für allgemeine Zugriffsperre
         * @param bool $noaccess
         */
        public function setNoaccess($noaccess) {
            $this->noaccess = $noaccess;
        }
                        
        /**
         * Speichert einen neuen IP-Datensatz in der Datenbank
         * @return boolean
         */        
        public function save() {
            if ($this->check($this->ipaddress)) return false;
            
            $params = $this->getPreparedSaveParams();
            $params = $this->events->runEvent('ipaddressSave', $params);

            $return = false;
            if ($this->dbcon->insert($this->table, implode(',', array_keys($params)), implode(', ', $this->getPreparedValueParams()), array_values($params))) {
                $return = true;
            }
            
            $this->cache->cleanup(); 
            
            return $return; 
        }

        /**
         * nicht verfügbar
         * @return boolean
         */        
        public function update() {
            return false;         
        }
        
        /**
         * Prüft ob IP-Adresse gesperrt ist
         * @return boolean
         */
        public function check() {            
            $count = $this->dbcon->count($this->table, 'id', "ipaddress LIKE '{$this->ipaddress}'");            
            if (!$count) return false;
            
            $delim = (strpos($this->ipaddress, ':') === true) ? ':' : '.';
            
            $ipAddress = explode($delim, $ipAddress);
            
            $adresses       = array();
            $adresses[]     = implode($delim, $ipAddress);
            
            $where = array('ipaddress LIKE ?');
            $counts = count($ipAddress) - 1;
            for ($i = $counts; $i > 0; $i--) {
                $ipAddress[$i]   = '*';
                $adresses[]     = implode($delim, $ipAddress);
                $where[] = 'ipaddress LIKE ?';
            }
            
            $where = "(".implode(' OR ', $where).") AND $lockType = 1";

            $result = $this->dbcon->fetch($this->dbcon->select($this->table, 'count(id) AS counted', $where, $adresses));
            
            return $result->counted ? true : false;
        }
        
    }
