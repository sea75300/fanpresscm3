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
     * Benutzerrollen-Liste Objekt
     * 
     * @package fpcm.model.user
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class userRollList extends \fpcm\model\abstracts\model {

        /**
         * Konstruktor
         */
        public function __construct() {
            $this->table = \fpcm\classes\database::tableRoll;
            
            parent::__construct();
        }
        
        /**
         * Liefert ein array aller Benutzer-Rollen
         * @return array
         */
        public function getUserRolls() {
            $rolls = $this->dbcon->fetch($this->dbcon->select($this->table), true);
            
            $res = array();                       
            foreach ($rolls as $roll) {
                $userRoll = new userRoll();
                if ($userRoll->createFromDbObject($roll)) {
                    $res[$userRoll->getId()] = $userRoll;
                }
            }
            
            return $res;
        }
        
        /**
         * Liefert Array mit Benutzerrollen für gegebenes IDs
         * @param array $ids
         * @return array
         */
        public function getUserRollsByIds(array $ids) {
            
            $ids = array_map('intval', $ids);
            $rolls = $this->dbcon->fetch($this->dbcon->select($this->table, '*', 'id IN ('.  implode(',', $ids).')'), true);
            
            $res = array();                       
            foreach ($rolls as $roll) {
                $userRoll = new userRoll();
                if ($userRoll->createFromDbObject($roll)) {
                    $res[$userRoll->getId()] = $userRoll;
                }
            }
            
            return $res;
        }
        
        /**
         * Liefert ein array aller Benutzer-Rollen mit übersetzen Texten
         * @return array
         */
        public function getUserRollsTranslated() {
            $rollList = array();
            foreach ($this->getUserRolls() as $roll) {
                $descr = $this->language->translate($roll->getRollName());
                $descr = $descr ? $descr : $roll->getRollName();
                
                $rollList[$descr] = $roll->getId();
            }
            
            return $rollList;
        }
        
        /**
         * Übersetzte Rollen zurückgeben
         * @param array $ids
         * @return array
         */
        public function getRollsbyIdsTranslated(array $ids) {
            $rollList = array();
            foreach ($this->getUserRollsByIds($ids) as $roll) {
                $descr = $this->language->translate($roll->getRollName());
                $descr = is_null($descr) ? $roll->getRollName() : $descr;
                
                $rollList[$descr] = $roll->getId();
            }
            
            return $rollList;         
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
