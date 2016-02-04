<?php
    /**
     * FanPress CM Word Ban Item List
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @since FPCM 3.2.0
     */

    namespace fpcm\model\wordban;

    /**
     * Word Ban Item Object List
     * 
     * @package fpcm.model.wordban
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.2.0
     */ 
    class items extends \fpcm\model\abstracts\model {
        
        /**
         * Konstruktor
         * @param int $id
         */
        public function __construct($id = null) {
            $this->table = \fpcm\classes\database::tableTexts;
            
            parent::__construct($id);
        }
        
        /**
         * Ruft Liste von Text-Sperren ab
         * @return array
         */
        public function getItems() {
            
            $list = $this->dbcon->fetch($this->dbcon->select($this->table), true);
            
            $res = array();
            foreach ($list as $item) {
                $wbItem = new item();
                if ($wbItem->createFromDbObject($item)) {                    
                    $res[$wbItem->getId()] = $wbItem;
                }                
            }
            
            return $res; 
        }

        /**
         * Löscht Wort-Sperren
         * @param array $ids
         * @return bool
         */
        public function deleteItems(array $ids) {
            
            if (!count($ids)) {
                return false;
            }
            
            $this->cache->cleanup();
            
            $ids = array_map('intval', $ids);
            return $this->dbcon->delete($this->table, 'id IN ('.implode(', ', $ids).')');
        }

        /**
         * Ersetzt gefundene Wörter/ Zeichenketten durch Ersetzungstext
         * @param string $text
         */
        public function replaceItems($text) {
            
            $itemsCache = new \fpcm\classes\cache('wordbanItems');
            $data = array('search' => array(), 'replace' => array());

            if ($itemsCache->isExpired() || !is_array($itemsCache->read())) {
                $items = $this->dbcon->fetch($this->dbcon->select($this->table), true);

                if (!is_array($items) || !count($items)) {
                    return $text;
                }

                foreach ($items as $value) {
                    $data['search']  = $value->searchtext;
                    $data['replace'] = $value->replacementtext;
                }
                
                
                $itemsCache->write($data);
                
            } else {
                $data = $itemsCache->read();
            }

            return str_replace($data['search'], $data['replace'], $text);

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