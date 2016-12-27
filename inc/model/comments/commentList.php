<?php
    /**
     * FanPress CM Comment List Model
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\comments;

    /**
     * Kommentar-Listen-Objekt
     * 
     * @package fpcm.model.comments
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class commentList extends \fpcm\model\abstracts\tablelist {

        /**
         * articlelist Objekt
         * @var \fpcm\model\articles\articlelist
         * @since FPCM 3.3
         */
        protected $articleList;

        /**
         * Liste mit IDs von Artikeln, die vom aktuelle Benutzer verschrieben wurden
         * @var array
         * @since FPCM 3.3
         */
        protected $ownArticleIds = false;

        /**
         * Permission Object
         * @var \fpcm\model\system\permissions
         * @since FPCM 3.3
         */
        protected $permissions = false;
        
        /**
         * Konstruktor
         */
        public function __construct() {
            $this->table = \fpcm\classes\database::tableComments;

            if (is_object(\fpcm\classes\baseconfig::$fpcmSession) && \fpcm\classes\baseconfig::$fpcmSession->exists()) {
                $this->permissions = new \fpcm\model\system\permissions(\fpcm\classes\baseconfig::$fpcmSession->getCurrentUser()->getRoll());
            }

            parent::__construct();
        }
        
        /**
         * Liefert ein array aller Kommentare
         * @return array
         */
        public function getCommentsAll() {
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', '1=1'.$this->dbcon->orderBy(array('createtime DESC'))), true);
            return $this->createCommentResult($list);
        }
        
        /**
         * Liefert ein array mit Kommentaren die zwischen $from und $to verfasst wurden
         * @param int $from
         * @param int $to
         * @param bool $private
         * @param bool $approved
         * @param bool $spam
         * @return array
         */
        public function getCommentsByDate($from, $to, $private = 0, $approved = 1, $spam = 0) {
            
            $params  = array($from, $to, $approved, $private, $spam);
            $where   = array('createtime >= ?', 'createtime <= ?', 'approved = ?', 'private = ?', 'spammer = ?');

            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', implode(' AND ', $where).$this->dbcon->orderBy(array('createtime DESC')), $params), true);
            return $this->createCommentResult($list);
        }
        
        /**
         * Liefert ein array der Kommentare, welcher mit der Bedingung übereinstimmen
         * @param int $articleId Artikel-ID
         * @param bool $private private Kommentare ja/nein
         * @param bool $hideUnapproved genehmigte Kommentare ja/nein
         * @param bool $spam als Spam markierte Kommentare ja/nein
         * @return array
         */
        public function getCommentsByCondition($articleId, $private = 0, $hideUnapproved = 1, $spam = 0) {
            
            $params = array($articleId, $private, $spam);
            
            $where   = array('articleid = ?', 'private = ?', 'spammer = ?');

            if ($spam == -1) {
                unset($params[1], $params[2], $where[1], $where[2]);
            }
            
            if ($this->config->comments_confirm && $hideUnapproved != -1){
                $where[]  = 'approved = ?';
                $params[] = $hideUnapproved;
            }
            
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', implode(' AND ', $where).$this->dbcon->orderBy(array('createtime ASC')), $params), true);            
            return $this->createCommentResult($list);
        }
        
        /**
         * Liefert ein array der Kommentare, welcher mit der Bedingung übereinstimmen
         * @param array $conditions
         * * title => via Title-Inhalt
         * * content => via content-Inhalt
         * * user => via Benutzer
         * * category => via Category
         * * datefrom => seit Datum X.Y.Z
         * * dateto => bis Datum X.Y.Z
         * * postponed => nur geplante Artikel
         * * archived => nur archivierte Artikel
         * * pinned => nur gepinnte Artikel
         * * comment => commentare sind aktiv
         * * deleted => nur gelöschte Artikel
         * * draft => nur Entwürfe
         * * orderby => Array von Sortierungen in SQL-Syntax
         * * limit => Abfrage einschränken
         * @return array
         */
        public function getCommentsBySearchCondition(array $conditions) {
            
            $where = array('1=1');
            $valueParams = array();

            if (isset($conditions['text']) && $conditions['searchtype'] == 0) {
                $where[] = "name ".$this->dbcon->dbLike()." ?";
                $valueParams[] = "%{$conditions['text']}%";
            }

            if (isset($conditions['text']) && $conditions['searchtype'] == 0) {
                $where[] = "email ".$this->dbcon->dbLike()." ?";
                $valueParams[] = "%{$conditions['text']}%";
            }

            if (isset($conditions['text']) && $conditions['searchtype'] == 0) {
                $where[] = "website ".$this->dbcon->dbLike()." ?";
                $valueParams[] = "%{$conditions['text']}%";
            }
            
            if (isset($conditions['text'])) {
                $where[] = "text ".$this->dbcon->dbLike()." ?";
                $valueParams[] = "%{$conditions['text']}%";
            }
            
            if ($conditions['searchtype'] == 0) {
                $textWhere = array();
                $textWhere[] = '('.implode(' OR ', $where).')';
                $where = $textWhere;
            }
            
            if (isset($conditions['datefrom'])) {
                $where[] = "createtime >= ?";
                $valueParams[] = $conditions['datefrom'];
            }
            
            if (isset($conditions['dateto'])) {
                $where[] = "createtime <= ?";
                $valueParams[] = $conditions['dateto'];
            }
            
            if (isset($conditions['spam']) && $conditions['spam'] > -1) {
                $where[] = "spammer = ?";
                $valueParams[] = $conditions['spam'];
            }
            
            if (isset($conditions['private']) && $conditions['private'] > -1) {
                $where[] = "private = ?";
                $valueParams[] = $conditions['private'];
            }
            
            if (isset($conditions['approved']) && $conditions['approved'] > -1) {
                $where[] = "approved = ?";
                $valueParams[] = $conditions['approved'];
            }
            
            $combination = isset($conditions['combination']) ? $conditions['combination'] : 'AND';
            
            $eventData = $this->events->runEvent('commentsByCondition', array(
                'conditions' => $conditions,
                'where'      => $where
            ));

            $where      = $eventData['where'];

            $where = implode(" {$combination} ", $where);

            $list = $this->dbcon->fetch(
                    $this->dbcon->select(
                        $this->table, '*', $where.$this->dbcon->orderBy(array('createtime ASC')),
                        $valueParams
                    ),
                    true
            );

            return $this->createCommentResult($list);
        }
        
        /**
         * Liefert ein Array mit Kommentaren zurück
         * @param int $offset
         * @param int $limit
         * @param string $order
         * @return array
         * @since FPCM 3.1.0
         */
        public function getCommentsByLimit($offset, $limit, $order = 'DESC') {
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', 'id > 0'.$this->dbcon->orderBy(array("createtime {$order}")).$this->dbcon->limitQuery($offset, $limit)), true);
            return $this->createCommentResult($list);
        }

        /**
         * Löscht Kommentare
         * @param array $ids
         * @return bool
         */
        public function deleteComments(array $ids) {
            $this->cache->cleanup();
            return $this->dbcon->delete($this->table, 'id IN ('.implode(', ', $ids).')');
        }

        /**
         * Löscht Kommentare für einen Artikel mit übergebener/n ID(s)
         * @param int|array $article_ids
         * @return bool
         */
        public function deleteCommentsByArticle($article_ids) {
            
            if (!is_array($article_ids)) {
                $article_ids = array($article_ids);
            }

            $this->cache->cleanup();
            
            return $this->dbcon->delete($this->table, 'articleid IN ('.implode(',', $article_ids).')');
        }

        /**
         * Schaltet Genehmigt-Status um
         * @param array $ids
         * @return bool
         */
        public function toggleApprovement(array $ids) { 
            $this->cache->cleanup();  
            return $this->dbcon->reverseBool($this->table, 'approved', 'id IN ('.implode(', ', $ids).')');
        }

        /**
         * Schaltet Privat-Status um
         * @param array $ids
         * @return bool
         */
        public function togglePrivate(array $ids) {
            $this->cache->cleanup();
            return $this->dbcon->reverseBool($this->table, 'private', 'id IN ('.implode(', ', $ids).')');
        }

        /**
         * Schaltet Spam-Status um
         * @param array $ids
         * @return bool
         */
        public function toggleSpammer(array $ids) {
            $this->cache->cleanup();
            return $this->dbcon->reverseBool($this->table, 'spammer', 'id IN ('.implode(', ', $ids).')');
        }
        
        /**
         * Zählt Kommentare für alle Artikel
         * @param array $articleIds
         * @param bool $private
         * @param bool $approved
         * @param bool $spam
         * @return bool
         */
        public function countComments(array $articleIds = array(), $private = null, $approved = null, $spam = null) {            
            
            $where  = count($articleIds) ? "articleid IN (".  implode(',', $articleIds).")" : '1=1';
            $where .= is_null($private) ? '' : ' AND private = '.$private;
            $where .= is_null($approved) ? '' : ' AND approved = '.$approved;
            $where .= is_null($spam) ? '' : ' AND spammer = '.$spam;

            $articleCounts = $this->dbcon->fetch($this->dbcon->select($this->table, 'articleid, count(id) AS count', "$where GROUP BY articleid"), true);
            
            if (!count($articleCounts)) return array(0);
            
            $res = array();
            foreach ($articleCounts as $articleCount) {
                $res[$articleCount->articleid] = $articleCount->count;
            }
            return $res;
        }
        
        /**
         * Zählt Kommentare für alle Artikel, die Privat oder nicht genehmigt sind
         * @param array $articleIds
         * @return array
         */
        public function countUnapprovedPrivateComments(array $articleIds = array()) {            
            
            $where = count($articleIds) ? "articleid IN (".  implode(',', $articleIds).")" : '1=1';            
            $articleCounts = $this->dbcon->fetch($this->dbcon->select($this->table, 'articleid, count(id) AS count', "$where AND (private = 1 OR approved = 0) GROUP BY articleid"), true);
            
            if (!count($articleCounts)) return array(0);
            
            $res = array();
            foreach ($articleCounts as $articleCount) {
                $res[$articleCount->articleid] = $articleCount->count;
            }
            return $res;
        }
        
        /**
         * Zählt Kommentare anhand von Bedingung
         * @param array $condition
         * * private => nur private Kommentare
         * * unapproved => nur nicht-genehmigte Kommentare
         * * spam => Kommentare, die als Spam eingestuft wurden
         * @return int
         */
        public function countCommentsByCondition(array $condition = array()) {

            $where = null;
            
            if (isset($condition['private'])) $where = 'private = 1';
            if (isset($condition['unapproved'])) $where = 'approved = 0';
            if (isset($condition['spam'])) $where = 'spammer = 1';

            $where  = $this->events->runEvent('commentsByConditionCount', $where);

            return $this->dbcon->count($this->table, '*', $where);
        }
        
        /**
         * Gibt Zeit zurück, wenn von der aktuellen IP der letzte Kommentar geschrieben wurde
         * @return int
         */
        public function getLastCommentTimeByIP(){            
            $res = $this->dbcon->fetch($this->dbcon->select($this->table, 'createtime', 'ipaddress '.$this->dbcon->dbLike().' ?'.$this->dbcon->orderBy(array('createtime ASC')).$this->dbcon->limitQuery(0, 1), array(\fpcm\classes\http::getIp())));            
            return isset($res->createtime) ? $res->createtime : 0;
        }
        
        /**
         * Prüft ob für die in Daten eines neuen Kommentars bereits Kommentare als Spam markiert wurden
         * @param \fpcm\model\comments\comment $comment
         * @return boolean true, wenn Anzahl größer als in $this->config->comments_markspam_commentcount definiert
         */
        public function spamExistsbyCommentData(comment $comment) {            
            $where   = array('name '.$this->dbcon->dbLike().' ?', 'email '.$this->dbcon->dbLike().' ?', 'website '.$this->dbcon->dbLike().' ?', 'ipaddress '.$this->dbcon->dbLike().' ?');
            $params = array($comment->getName(), '%'.$comment->getEmail().'%', '%'.$comment->getWebsite().'%', $comment->getIpaddress());
            $count = $this->dbcon->count($this->table, 'id', implode(' OR ', $where).' AND spammer = 1', $params);
            
            return $count >= $this->config->comments_markspam_commentcount ? true : false;
            
        }

        /**
         * Führt Prüfung durch, ob Artikel bearbeitet werden kann
         * @param \fpcm\model\comments\comment $comment
         * @return boolean
         */
        public function checkEditPermissions(comment &$comment) {

            if ($this->permissions === false) {
                return true;
            }

            if (!is_array($this->ownArticleIds)) {                
                $this->articleList   = new \fpcm\model\articles\articlelist();
                $this->ownArticleIds = $this->articleList->getArticleIDsByUser(\fpcm\classes\baseconfig::$fpcmSession->getUserId());
            }

            $isAdmin     = \fpcm\classes\baseconfig::$fpcmSession->getCurrentUser()->isAdmin();
            $permEditAll = $this->permissions->check(array('comment' => 'editall'));            
            $permEditOwn = $this->permissions->check(array('comment' => 'edit'));
            
            if ($isAdmin || $permEditAll) {
                $comment->setEditPermission(true);
                return true;
            }
            
            if (!$isAdmin && !$permEditAll && $permEditOwn && in_array($comment->getArticleid(), $this->ownArticleIds)) {
                $comment->setEditPermission(true);
                return true;                
            }

            $comment->setEditPermission(false);
            return true;

        }

        /**
         * Erzeugt Listen-Result-Array
         * @param array $list
         * @return array
         */
        private function createCommentResult($list) {
            $res = array();
            
            foreach ($list as $listItem) {
                $object = new comment();
                if (!$object->createFromDbObject($listItem)) {
                    continue;
                }
                $this->checkEditPermissions($object);
                $res[$object->getId()] = $object;
            }
            
            return $res;            
        }

    }
