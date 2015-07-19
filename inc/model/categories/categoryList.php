<?php
    /**
     * FanPress CM Category List Model
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\categories;

    /**
     * Kategorie-Listen-Objekt
     * 
     * @package fpcm.model.categories
     * @abstract
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    class categoryList extends \fpcm\model\abstracts\model {
        
        /**
         * Konstruktor
         */
        public function __construct() {
            $this->table = \fpcm\classes\database::tableCategories;
            
            parent::__construct();
        }
        
        /**
         * Liefert ein array aller Kategorien
         * @return array
         */
        public function getCategoriesAll() {
            $list = $this->dbcon->fetch($this->dbcon->select($this->table), true);
            
            $res = array();
            
            foreach ($list as $listItem) {
                $object = new category();
                if ($object->createFromDbObject($listItem)) {
                    $res[$object->getId()] = $object;
                }
            }
            
            return $res;
        }

        /**
         * Liefert ein array aller Kategorien, auf welche die angegebene Gruppe zugreifen darf
         * @param int $groupId
         * @return array
         */
        public function getCategoriesByGroup($groupId) {
            $list = $this->dbcon->fetch($this->dbcon->select($this->table,'*','groups LIKE ?', array($groupId)), true);
            
            $res = array();
            
            foreach ($list as $listItem) {
                $object = new category();
                if ($object->createFromDbObject($listItem)) {
                    $res[$object->getId()] = $object;
                }
            }
            
            return $res;
        }

        /**
         * Liefert ein array aller Kategorien, auf die der aktuelle Benutzer zugreifen darf
         * @return array
         */
        public function getCategoriesCurrentUser() {
            
            $session = new \fpcm\model\system\session();
            
            $currentUserGroup = $session->getCurrentUser()->getRoll();
            
            $list = $this->dbcon->fetch($this->dbcon->select($this->table,'*',"groups LIKE '%$currentUserGroup%'"), true);
            
            $res = array();
            
            foreach ($list as $listItem) {
                $object = new category();
                if ($object->createFromDbObject($listItem)) {
                    $res[$object->getId()] = $object;
                }
            }
            
            return $res;
        }
        
        /**
         * Liefert ein array aller Kategorie-Namen
         * @return array
         */
        public function getCategoriesNameListCurrent() {
            $categoryies = $this->getCategoriesCurrentUser();
            
            $res = array();

            foreach ($categoryies as $category) {
                $res[$category->getName()] = $category->getId();
            }
            
            return $res;
        }

        /**
         * Prüft ob Kategorie existiert
         * @param string $name
         * @return bool
         */
        public function categorieExists($name) {
            $result = $this->dbcon->count($this->table,"id", "name LIKE ?", array($name));
            return ($result > 0) ? true : false;
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
