<?php
    /**
     * FanPress CM Article List Model
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\articles;

    /**
     * Artikelliste
     * 
     * @package fpcm.model.articles
     * @abstract
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    class articlelist extends \fpcm\model\abstracts\model {

        /**
         * Konstruktor
         * @param int $id
         */
        public function __construct($id = null) {
            $this->table = \fpcm\classes\database::tableArticles;
            
            parent::__construct($id);
        }
        
        /**
         * Gibt Liste mit allen nicht gelöschten Artikeln zurück
         * @param bool $monthIndex Liste mit Monatsindex zurückgeben
         * @param array $limits Anzahl der zurückgegebenen Artikel einschränken array(Start,Anzahl)
         * @param bool $countOnly Verfügbare Artikel nur zählen
         * @return array
         */
        public function getArticlesAll($monthIndex = false, array $limits = array(), $countOnly = false) {
            $where = 'draft = 0 AND deleted = 0'.$this->dbcon->orderBy(array('createtime DESC'));
            
            if ($countOnly) return (int) $this->dbcon->count($this->table, 'id', $where);
            
            if (count($limits)) $where .= $this->dbcon->limitQuery($limits[0], $limits[1]);
            
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', $where), true);
            return $this->createListResult($list, $monthIndex);
        }
        
        /**
         * Gibt Liste mit allen aktiven Artikeln zurück
         * @param bool $monthIndex Liste mit Monatsindex zurückgeben
         * @param array $limits Anzahl der zurückgegebenen Artikel einschränken array(Start,Anzahl)
         * @param bool $countOnly Verfügbare Artikel nur zählen
         * @return array
         */        
        public function getArticlesActive($monthIndex = false, array $limits = array(), $countOnly = false) {
            $where = 'draft = 0 AND archived = 0 AND deleted = 0'.$this->dbcon->orderBy(array('createtime DESC'));
            
            if ($countOnly) return (int) $this->dbcon->count($this->table, 'id', $where);
            
            if (count($limits)) $where .= $this->dbcon->limitQuery($limits[0], $limits[1]);
            
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', $where), true);
            return $this->createListResult($list, $monthIndex);           
        }

        /**
         * Gibt Liste mit allen archivierten Artikeln zurück
         * @param bool $monthIndex Liste mit Monatsindex zurückgeben
         * @param array $limits Anzahl der zurückgegebenen Artikel einschränken array(Start,Anzahl)
         * @param bool $countOnly Verfügbare Artikel nur zählen
         * @return array
         */        
        public function getArticlesArchived($monthIndex = false, array $limits = array(), $countOnly = false) {
            $where = 'archived = 1 AND deleted = 0'.$this->dbcon->orderBy(array('createtime DESC'));
            
            if ($countOnly) return (int) $this->dbcon->count($this->table, 'id', $where);
            
            if (count($limits)) $where .= $this->dbcon->limitQuery($limits[0], $limits[1]);
            
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', $where), true);
            return $this->createListResult($list, $monthIndex);           
        }
        
        /**
         * Gibt Liste mit allen Artikeln zurück, welche automatisch freigeschalten werden sollen
         * @param bool $monthIndex
         * @return array
         */        
        public function getArticlesPostponed($monthIndex = false) {
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', 'postponed = 1 AND approval = 0 AND createtime <= ? AND deleted = 0 AND draft = 0'.$this->dbcon->orderBy(array('createtime DESC')), array(time())), true);
            return $this->createListResult($list, $monthIndex);            
        }
        
        /**
         * Gibt Liste mit Artikel-IDs zurück, welche automatisch freigeschalten werden sollen
         * @return array
         */        
        public function getArticlesPostponedIDs() {
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, 'id', 'postponed = 1 AND approval = 0 AND createtime <= ? AND deleted = 0 AND draft = 0'.$this->dbcon->orderBy(array('createtime DESC')), array(time())), true);
            
            $ids = array();
            foreach ($list as $item) {
                $ids[] = (int) $item->id;
            }
            
            return $ids;
        }
        
        /**
         * Gibt Liste mit allen gelöschten Artikeln zurück (Papierkorb)
         * @param bool $monthIndex
         * @return array
         */        
        public function getArticlesDeleted($monthIndex = false) {
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', 'deleted = 1'.$this->dbcon->orderBy(array('createtime DESC'))), true);
            return $this->createListResult($list, $monthIndex);            
        }
        
        /**
         * Gibt Liste mit allen gelöschten Artikeln zurück (Papierkorb)
         * @param bool $monthIndex
         * @return array
         */        
        public function getArticlesDraft($monthIndex = false) {
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', 'draft = 1 AND deleted = 0'.$this->dbcon->orderBy(array('createtime DESC'))), true);
            return $this->createListResult($list, $monthIndex);            
        }
        
        /**
         * Gibt Liste von Artikeln anhand einer Bedingung zurück
         * @param array $conditions
         * * ids => Artikel-IDs
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
         * @param bool $monthIndex
         * @return array
         */      
        public function getArticlesByCondition(array $conditions, $monthIndex = false) {

            $where = array();
            $valueParams = array();
            
            if (isset($conditions['ids'])) {
                $where[] = "id IN (".implode(', ', $conditions['ids']).")";
                unset($conditions['ids']);
            }
            
            if (isset($conditions['title'])) {
                $where[] = "title LIKE ?";
                $valueParams[] = "%{$conditions['title']}%";
            }
            
            if (isset($conditions['content'])) {
                $where[] = "content LIKE ?";
                $valueParams[] = "%{$conditions['content']}%";
            }
            
            if (isset($conditions['user'])) {
                $where[] = "createuser = ?";
                $valueParams[] = $conditions['user'];
            }
            
            if (isset($conditions['category'])) {
                $where[] = "(categories LIKE ? OR categories LIKE ? OR categories LIKE ?)";
                $valueParams[] = "%{$conditions['category']}%";
                $valueParams[] = "%{$conditions['category']},";
                $valueParams[] = ",{$conditions['category']}%";
            }
            
            if (isset($conditions['datefrom'])) {
                $where[] = "createtime >= ?";
                $valueParams[] = $conditions['datefrom'];
            }
            
            if (isset($conditions['dateto'])) {
                $where[] = "createtime <= ?";
                $valueParams[] = $conditions['dateto'];
            }

            if (isset($conditions['postponed'])) {
                $where[] = "postponed = ?";
                $valueParams[] = $conditions['postponed'];
            }

            if (isset($conditions['archived'])) {
                $where[] = "archived = ?";
                $valueParams[] = $conditions['archived'];
            }

            if (isset($conditions['pinned'])) {
                $where[] = "pinned = ?";
                $valueParams[] = $conditions['pinned'];
            }

            if (isset($conditions['comments'])) {
                $where[] = "comments = ?";
                $valueParams[] = $conditions['comments'];
            }
            
            if (isset($conditions['deleted'])) {
                $where[] = "deleted = ?";
                $valueParams[] = $conditions['deleted'];
            } else {
                $where[] = "deleted = 0";
            }
            
            if (isset($conditions['draft']) && $conditions['draft'] > -1) {
                $where[] = "draft = ?";
                $valueParams[] = $conditions['draft'];
            } elseif (!isset($conditions['draft'])) {
                $where[] = "draft = 0";
            }
            
            if (isset($conditions['approval']) && $conditions['approval'] > -1) {
                $where[] = "approval = ?";
                $valueParams[] = $conditions['approval'];
            } elseif (!isset($conditions['approval'])) {
                $where[] = "approval = 0";
            }
            
            $where = implode(' AND ', $where);

            $where2 = array();
            $where2[] = $this->dbcon->orderBy( ((isset($conditions['orderby'])) ? $conditions['orderby'] : array($this->config->articles_sort.' '.$this->config->articles_sort_order)) );
            
            if (isset($conditions['limit'])) {
                $where2[] = $this->dbcon->limitQuery($conditions['limit'][0], $conditions['limit'][1]);
            }
            unset($conditions['limit'], $conditions['orderby']);
            
            $where .= ' '.implode(' ', $where2);
            
            $list = $this->dbcon->fetch($this->dbcon->select($this->table, '*', $where, array_values($valueParams)), true);
            
            return $this->createListResult($list, $monthIndex);
        }
        
        /**
         * Löscht Artikel oder verschiebt sie in Papierkorb
         * @param array $ids
         * @return bool
         */
        public function deleteArticles(array $ids) {   
            $where = 'id IN ('.implode(', ', $ids).')';
            
            if ($this->config->articles_trash) {
                $res = $this->dbcon->update($this->table, array('deleted', 'pinned'), array(1,0), $where);
            } else {
                $res = $this->dbcon->delete($this->table, $where);
            }

            if ($res) {
                $commentList = new \fpcm\model\comments\commentList();
                $commentList->deleteCommentsByArticle($ids);
            }

            $this->cache->cleanup();
            
            return $res;
        }
        
        /**
         * Stellt Artikel aus Papierkorb wieder her
         * @param array $ids
         * @return bool
         */
        public function restoreArticles(array $ids) {
            if (!$this->config->articles_trash) return false;
            $this->cache->cleanup();
            return $this->dbcon->update($this->table, array('deleted'), array(0), 'id IN ('.implode(', ', $ids).') AND deleted = 1');
        }
        
        /**
         * Veröffentlicht Article, die freigeschlaten werden sollen
         * @param array $ids
         * @return bool
         */
        public function publishPostponedArticles(array $ids) {
            $this->cache->cleanup();
            return $this->dbcon->update($this->table, array('postponed'), array(0), 'id IN ('.implode(', ', $ids).') AND postponed = 1 AND approval = 0 AND deleted = 0 AND draft = 0');
        }
        
        /**
         * Leert Papierkorb
         * @param array $ids
         * @return bool
         */
        public function emptyTrash() {
            if (!$this->config->articles_trash) return false;
            return $this->dbcon->delete($this->table, 'deleted = 1');
        }
        
        /**
         * Archiviert Artikel
         * @param array $ids
         * @return bool
         */
        public function archiveArticles(array $ids) {   
            $values = array(
                'archived' => 1,
                'pinned'  => 0
            );
            
            $res = $this->dbcon->update($this->table, array_keys($values), array_values($values), 'id IN ('.implode(', ', $ids).') AND deleted = 0');

            return $res;
        }
        
        /**
         * Wechselt Kommentar-Aktiv-Status von Artikeln
         * @param array $ids
         * @return bool
         */
        public function toggleComments(array $ids) {
            $this->cache->cleanup();
            return $this->dbcon->reverseBool($this->table, 'comments', 'id IN ('.implode(', ', $ids).')');
        }
        
        /**
         * Wechselt Freigeben-Status von Artikeln
         * @param array $ids
         * @return bool
         */
        public function toggleApproval(array $ids) {
            $this->cache->cleanup();            
            return $this->dbcon->reverseBool($this->table, 'approval', 'id IN ('.implode(', ', $ids).')');
        }
        
        /**
         * Wechselt Pinned-Status von Artikeln
         * @param array $ids
         * @return bool
         */
        public function togglePinned(array $ids) {
            $this->cache->cleanup();
            return $this->dbcon->reverseBool($this->table, 'pinned', 'id IN ('.implode(', ', $ids).') AND deleted = 0 AND archived = 0');
        }
        
        /**
         * Gibt Artikel-Anzahl für jeden Benutzer zurück
         * @param array $userIds
         * @return array
         */
        public function countArticlesByUsers(array $userIds = array()) {
            $where = count($userIds) ? "createuser IN (".  implode(',', $userIds).")" : '1=1';
            $articleCounts = $this->dbcon->fetch($this->dbcon->select($this->table, 'createuser, count(id) AS count', "$where AND deleted = 0 GROUP BY createuser"), true);
            
            $res = array();
            if (!count($articleCounts)) return $res;
            
            foreach ($articleCounts as $articleCount) {
                $res[$articleCount->createuser] = (int) $articleCount->count;
            }
            
            return $res;
        }
        
        /**
         * Zählt Artikel anhand von Bedingung
         * @param array $condition
         * * active => nur aktive Artikel
         * * archived => nur archivierte Artikel
         * * deleted => nur gelöschte Artikel
         * * category => nur Artikel der Kategorie
         * @return int
         */
        public function countArticlesByCondition(array $condition = array()) {

            $where = 'id > 0';
            
            if (isset($condition['category'])) {
                $valueParams[] = "categories LIKE '{$condition['category']}'";
                $valueParams[] = "categories LIKE '%;{$condition['category']}'";
                $valueParams[] = "categories LIKE '{$condition['category']};%'";
                
                $where .= '('.implode(' OR ', $valueParams).')';
            }
            if (isset($condition['drafts'])) $where   .= ' AND draft = 1';
            if (isset($condition['active'])) $where   .= ' AND archived = 0 AND draft = 0';
            if (isset($condition['archived'])) $where .= ' AND archived = 1 AND draft = 0';
            if (isset($condition['deleted'])) {
                $where  .= ' AND deleted = 1';
            } else {
                $where .= ' AND deleted = 0';
            }
            
            return $this->dbcon->count($this->table, '*', $where);
        }
        
        /**
         * Gibt Liste mit Artikel-IDs für übergebenen Benutzer zurück
         * @param int $userId
         * @return array
         */        
        public function getArticleIDsByUser($userId) {
            $articles = $this->dbcon->fetch($this->dbcon->select($this->table, 'id', "createuser = ? AND deleted = 0", array($userId)), true);
            
            $res = array();
            if (!count($articles)) return $res;
            
            foreach ($articles as $article) {
                $res[] = (int) $article->id;
            }
            
            return $res;
        }

        /**
         * Erzeugt Listen-Result-Array
         * @param array $list
         * @param bool $monthIndex
         * @return array
         */
        private function createListResult($list, $monthIndex) {
            $res = array();
            foreach ($list as $item) {
                $article = new article();
                if ($article->createFromDbObject($item)) {                    
                    if ($monthIndex) {
                        $index = mktime(0, 0, 0, date('m', $article->getCreatetime()), 1, date('Y', $article->getCreatetime()));
                        $res[$index][$article->getId()] = $article;
                    } else {
                        $res[$article->getId()] = $article;
                    }
                    
                    
                }                
            }
            
            return $res;             
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
