<?php

    namespace fpcm\model\articles;

    /**
     * NEW Article revision object for storage in database
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.articles
     * @since FPCM 3.3
     */ 
    class revision extends \fpcm\model\abstracts\model {
        
        /**
         * Article id
         * @var string
         */
        protected $article_id  = 0;
        
        /**
         * Revision number
         * @var string
         */
        protected $revision_idx = 0;      
        
        /**
         * Article data store din revision
         * @var array
         */
        protected $content = '';

        /**
         * Konstruktor
         * @param int $articleId
         * @param int $revisionIdx
         */
        public function __construct($articleId = 0, $revisionIdx = 0) {

            $this->article_id   = (int) $articleId;
            $this->revision_idx = (int) $revisionIdx;

            $this->table = \fpcm\classes\database::tableRevisions;
            parent::__construct();

            if (!$this->article_id || !$this->revision_idx) {
                return true;
            }

            $this->init();
        }

        /**
         * Artikel ID zurückgeben
         * @return int
         */
        public function getArticleId() {
            return (int) $this->article_id;
        }

        /**
         * Revisionszeit-Index zurückgeben
         * @return int
         */
        public function getRevisionIdx() {
            return (int) $this->revision_idx;
        }
                
        /**
         * Artikel-COntent aus Revision zurückgeben
         * @return array
         */
        public function getContent() {

            $data = json_decode($this->content, true);
            if (!is_array($data)) {
                return array();
            }

            return $data;

        }

        /**
         * Artikel ID setzen
         * @return int
         */
        public function setArticleId($articleId) {
            $this->article_id = (int) $articleId;
        }

        /**
         * Revisionszeit-Index setzen
         * @return int
         */
        public function setRevisionIdx($revisionIdx) {
            $this->revision_idx = (int) $revisionIdx;
        }
        
        /**
         * Content aus artikel speichern
         * @param array $content
         */
        public function setContent(array $content) {
            $this->content = json_encode($content);
        }
        
        /**
         * Speichert eine neue Revision in der Datenbank
         * @return int
         */        
        public function save() {

            $params = $this->getPreparedSaveParams();
            if (!$this->dbcon->insert(
                        $this->table,
                        implode(',', array_keys($params)),
                        implode(', ', $this->getPreparedValueParams(count($params))),
                        array_values($params)
                    )
                ) {
                return false;
            }
            
            $this->id = $this->dbcon->getLastInsertId();
            return $this->id ? true : false;

        }

        /**
         * Revision kann nicht verändert werden
         * @return boolean
         */        
        public function update() {
            return false;            
        }
        
        /**
         * Löscht Revision in der Datenbank
         * @return bool
         */
        public function delete() {

            return $this->dbcon->delete(
                $this->table,
                'article_id = ? AND revision_idx = ?',
                array($this->article_id, $this->revision_idx)
            );

        }

        /**
         * Inittiert Objekt mit Daten aus der Datenbank
         */
        protected function init() {
            
            $result = $this->dbcon->select(
                $this->table,
                'article_id, revision_idx, content', 
                'article_id = ? AND revision_idx = ?',
                array($this->article_id, $this->revision_idx)
            );

            $object = $this->dbcon->fetch($result);
            if (!$object) {
                trigger_error('Failed to load data for object of type "'.get_class($this).'" with given id '.$this->id.'!');
                return false;
            }
            
            $this->objExists = true;
            $this->createFromDbObject($object);
            
            return true;
        }

    }