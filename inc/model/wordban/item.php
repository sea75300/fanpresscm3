<?php
    /**
     * FanPress CM Word Ban Item Model
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @since FPCM 3.2.0
     */

    namespace fpcm\model\wordban;

    /**
     * Word Ban Item Object
     * 
     * @package fpcm.model.wordban
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.2.0
     */ 
    class item extends \fpcm\model\abstracts\model {
        
        /**
         * gesuchter Text
         * @var string
         */
        protected $searchtext;
        
        /**
         * Text für Ersetzung
         * @var string
         */
        protected $replacementtext;
        
        /**
         * Action-String für edit-Action
         * @var string
         */        
        protected $editAction = 'wordban/edit&itemid=';

        /**
         * Konstruktor
         */
        public function __construct($id = null) {

            $this->table = \fpcm\classes\database::tableTexts;
            
            parent::__construct($id);
        }

        /**
         * gesuchter Text zurückgeben
         * @return string
         */
        public function getSearchtext() {
            return $this->searchtext;
        }

        /**
         * Text für Ersetzung zurückgeben
         * @return string
         */
        public function getReplacementtext() {
            return $this->replacementtext;
        }

        /**
         * gesuchter Text setzten
         * @param string $searchtext
         */
        public function setSearchtext($searchtext) {
            $this->searchtext = $searchtext;
        }

        /**
         * Text für Ersetzung setzten
         * @param string $replacementtext
         */
        public function setReplacementtext($replacementtext) {
            $this->replacementtext = $replacementtext;
        }

        /**
         * Speichert Wortsperre
         * @return bool
         */
        public function save() {

            $params = $this->getPreparedSaveParams();

            $return = false;
            if ($this->dbcon->insert($this->table, implode(',', array_keys($params)), implode(', ', $this->getPreparedValueParams(count($params))), array_values($params))) {
                $return = true;
            }

            $this->cache->cleanup();
            
            return $return;     
        }

        /**
         * Aktualisiert Wortsperre
         * @return bool
         */
        public function update() {
            $params     = $this->getPreparedSaveParams();
            $fields     = array_keys($params);
            
            $params[]   = $this->getId();
            
            $return = false;
            if ($this->dbcon->update($this->table, $fields, array_values($params), 'id = ?')) {
                $return = true;
            }
            
            $this->cache->cleanup();
            
            $this->init();
            
            return $return;   
        }

    }