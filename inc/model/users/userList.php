<?php
    /**
     * FanPress CM User List Model
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\users;

    /**
     * Benutzer-Liste Objekt
     * 
     * @package fpcm.model.user
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class userList extends \fpcm\model\abstracts\model {
        
        /**
         * Konstruktor
         * @param int $id
         */
        public function __construct($id = null) {
            $this->table = \fpcm\classes\database::tableAuthors;
            
            parent::__construct($id);
        }
        
        /**
         * Liefert ein array aller Benutzer
         * @return array
         */
        public function getUsersAll() {
            $users = $this->dbcon->fetch($this->dbcon->select($this->table), true);
            
            $res = array();

            foreach ($users as $user) {
                $author = new author();
                if ($author->createFromDbObject($user)) {
                    $res[$author->getId()] = $author;
                }
            }
            
            return $res;
        }
        
        /**
         * Liefert ein array aller Benutzer-Namen
         * @return array
         */
        public function getUsersNameList() {
            $users = $this->dbcon->fetch($this->dbcon->select($this->table, 'id, displayname'), true);
            
            $res = array();

            foreach ($users as $user) {
                $res[$user->displayname] = $user->id;
            }
            
            return $res;
        }
        
        /**
         * Liefert ein array aller Benutzer-E-Mail-Adressen
         * @return array
         */
        public function getUsersEmailList() {
            $users = $this->dbcon->fetch($this->dbcon->select($this->table, 'id, email'), true);
            
            $res = array();

            foreach ($users as $user) {
                $res[$user->email] = $user->id;
            }
            
            return $res;
        }

        /**
         * Liefert ein array aller aktiven Benutzer
         * @return array
         */
        public function getUsersActive() {
            $users = $this->dbcon->fetch($this->dbcon->select($this->table,'*','disabled = 0'), true);
            
            $res = array();
            foreach ($users as $user) {
                $author = new author();
                if ($author->createFromDbObject($user)) {
                    $res[$author->getId()] = $author;
                }
            }
            
            return $res;
        }

        /**
         * Liefert ein array aller aktiven Benutzer
         * @return array
         */
        public function getUsersDisabled() {
            $users = $this->dbcon->fetch($this->dbcon->select($this->table,'*','disabled = 1'), true);
            
            $res = array();
            foreach ($users as $user) {
                $author = new author();
                if ($author->createFromDbObject($user)) {
                    $res[$author->getId()] = $author;
                }
            }
            
            return $res;
        }

        /**
         * Gibt ID für den gegebenen Benutzer zurück
         * @param string $username
         * @return int
         */
        public function getUserIdByUsername($username) {
            $result = $this->dbcon->fetch($this->dbcon->select($this->table, "id", "username ".$this->dbcon->dbLike()." ?", array($username)));
            return isset($result->id) ? $result->id : false;
        }

        /**
         * Gibt array mit Benutzern der übergebenen IDs zurück
         * @param array $ids
         * @return array
         */
        public function getUsersByIds(array $ids) {
            $users = $this->dbcon->fetch($this->dbcon->select($this->table, '*', 'id IN ('.implode(', ', $ids).') '), true);
            
            $res = array();
            foreach ($users as $user) {
                $author = new author();
                if ($author->createFromDbObject($user)) {
                    $res[$author->getId()] = $author;
                }
            }
            
            return $res;
        }
        
        /**
         * Gibt E-Mail-Adresse für übergebene Benutzer-ID zurück
         * @param int $userId
         * @return string
         */
        public function getEmailByUserId($userId) {
            $res = $this->dbcon->fetch($this->dbcon->select($this->table, 'email', 'id = ?', array($userId)));            
            return $res->email;
        }

        /**
         * mehrere Benutzer anhand von IDs löschen
         * @param array $ids
         * @return bool
         */
        public function deleteUsers(array $ids) {
            return $this->dbcon->delete($this->table, 'id IN ('.implode(',', $ids).')');
        }
        
        /**
         * Benutzer deaktivieren
         * @param array $ids
         * @return bool
         */
        public function diableUsers(array $ids) {
            return $this->dbcon->update($this->table, 'disabled', array('1'), 'id IN ('.implode(',', $ids).')');
        }
        
        /**
         * Benutzer aktivieren
         * @param array $ids
         * @return bool
         */
        public function enableUsers(array $ids) {
            return $this->dbcon->update($this->table, 'disabled', array('0'), 'id IN ('.implode(',', $ids).')');
        }
        
        /**
         * aktive Benutzer zählen
         * @return int
         */
        public function countActiveUsers() {
            return $this->dbcon->count($this->table, '*', 'disabled = 0');
        }

        /**
         * nicht verwendet
         * @return void
         */
        public function save() {
            return;
        }

        /**
         * nicht verwendet
         * @return void
         */
        public function update() {
            return;
        }

        /**
         * nicht verwendet
         * @return void
         */
        public function delete() {
            return;
        }

    }
