<?php
    /**
     * FanPress CM Article Model
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\articles;

    /**
     * Artikel Objekt
     * 
     * @package fpcm.model.articles
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    class article extends \fpcm\model\abstracts\model {
        
        /**
         * News-Titel
         * @var string
         */
        protected $title            = '';
        
        /**
         * News-Text
         * @var string
         */
        protected $content          = '';      
        
        /**
         * Kategorien
         * @var array
         */
        protected $categories       = array();
        
        /**
         * Status: Entwurf
         * @var int
         */
        protected $draft            = 0;
        
        /**
         * Status: archiviert
         * @var int
         */
        protected $archived         = 0;
        
        /**
         * Status: gepinnt
         * @var int
         */
        protected $pinned           = 0;
        
        /**
         * Status: automatisch freischalten
         * @var int
         */
        protected $postponed        = 0;
        
        /**
         * Status: gelöscht
         * @var int
         */
        protected $deleted          = 0;
        
        /**
         * Kommentare aktiv
         * @var int
         */
        protected $comments         = 1;
        
        /**
         * Artikel muss freigegeben werden
         * @var int
         */
        protected $approval         = 0;
        
        /**
         * Pfad zum Artikel-Bild
         * @var string
         * @since FPCM 3.1.0
         */
        protected $imagepath        = '';

        /**
         * Veröffentlichungszeit
         * @var int
         */
        protected $createtime       = 0;
        
        /**
         * Author
         * @var int
         */
        protected $createuser       = 0;
        
        /**
         * Zeitpunkt der letzten Änderung
         * @var int
         */
        protected $changetime       = 0;
        
        /**
         * Benutzer der letzten Änderung
         * @var int
         */
        protected $changeuser       = 0;
        
        /**
         *MD5 Pfad
         * @var string
         */
        protected $md5path          = '';
        
        /**
         * richtiges Löschen erzwingen
         * @var int
         */
        protected $forceDelete      = 0;

        /**
         * Auszuschließende Elemente beim in save/update
         * @var array
         */
        protected $dbExcludes = array('defaultPermissions', 'forceDelete');
        
        /**
         * Action-String für edit-Action
         * @var string
         */        
        protected $editAction = 'articles/edit&articleid=';
        
        /**
         * Wortsperren-Liste
         * @var \fpcm\model\wordban\items
         * @since FPCM 3.2.0
         */
        protected $wordbanList;

        /**
         * Konstruktor
         * @param int $id
         */
        public function __construct($id = null) {
            $this->table = \fpcm\classes\database::tableArticles;
            $this->wordbanList = new \fpcm\model\wordban\items();
            
            parent::__construct($id);
        }
        
        /**
         * Gibt Artikel- zurück
         * @return string
         */
        public function getTitle() {
            return $this->title;
        }

        /**
         * Gibt Artikel-Inhalt zurück
         * @return strig
         */
        public function getContent() {
            return $this->content;
        }

        /**
         * Gibt Artikel-Kategorie-IDs zurück
         * @return array
         */
        public function getCategories() {
            if (!is_array($this->categories)) {
                $this->categories = json_decode($this->categories, true);
            }
            
            return $this->categories;
        }

        /**
         * Gibt Artikel-Entwurf-Status zurück
         * @return bool
         */
        public function getDraft() {
            return $this->draft;
        }

        /**
         * Gibt Artikel-archiviert-Status zurück
         * @return bool
         */
        public function getArchived() {
            return $this->archived;
        }

        /**
         * Gibt Artikel-gepinnt-Status zurück
         * @return bool
         */
        public function getPinned() {
            return $this->pinned;
        }

        /**
         * Gibt Artikel-geplant-Status zurück
         * @return bool
         */
        public function getPostponed() {
            return $this->postponed;
        }

        /**
         * Gibt Artikel-gelöscht-Status zurück
         * @return bool
         */
        public function getDeleted() {
            return $this->deleted;
        }

        /**
         * Gibt Artikel-Erstellungszeitpunkt zurück
         * @return int
         */
        public function getCreatetime() {
            return $this->createtime;
        }

        /**
         * Gibt Artikel-Author-ID zurück
         * @return int
         */
        public function getCreateuser() {
            return $this->createuser;
        }

        /**
         * Gibt Zeitpunkt der letzten Änderung zurück
         * @return int
         */
        public function getChangetime() {
            return $this->changetime;
        }

        /**
         * Gibt Benutzer-ID zurück, von dem letzte Änderung durchgeführt wurde
         * @return int
         */
        public function getChangeuser() {
            return $this->changeuser;
        }

        /**
         * Gibt Artikel-Kommentare aktiv-Status zurück
         * @return bool
         */
        public function getComments() {
            return $this->comments;
        }
        
        /**
         * Gibt Artikel-MD5-Pfad zurück
         * @return string
         */
        public function getMd5path() {
            return $this->md5path;
        }
        
        /**
         * Gibt Artikel-muss freigeschaltet werden-Status zurück
         * @return bool
         */
        public function getApproval() {
            return $this->approval;
        }
        
        /**
         * Gibt Pfad zum Artikel-Bild zurück
         * @return string
         * @since FPCM 3.1.0
         */
        public function getImagepath() {
            return $this->imagepath;
        }
                
        /**
         * Ttiel setzten
         * @param string $title
         */
        public function setTitle($title) {
            $this->title = strip_tags($title, '<b><strong><i><em><u><span><br>');
        }

        /**
         * Inhalt setzten
         * @param string $content
         */
        public function setContent($content) {
            $this->content = $content;
        }

        /**
         * Kategorien setzten
         * @param array $categories
         */
        public function setCategories(array $categories) {
            $this->categories = json_encode($categories);
        }

        /**
         * Entwurf-Status setzten
         * @param bool $draft
         */
        public function setDraft($draft) {
            $this->draft = (int) $draft;
        }

        /**
         * archiviert Status setzten
         * @param bool $archived
         */
        public function setArchived($archived) {
            $this->archived = (int) $archived;
        }

        /**
         * gepinnt Status
         * @param bool $pinned
         */
        public function setPinned($pinned) {
            $this->pinned = (int) $pinned;
        }

        /**
         * Geplant-Status setzten
         * @param bool $postponed
         */
        public function setPostponed($postponed) {
            $this->postponed = (int) $postponed;
        }

        /**
         * Gelöscht Status setzten
         * @param bool $deleted
         */
        public function setDeleted($deleted) {
            $this->deleted = (int) $deleted;
        }

        /**
         * Zeitpunk der Erzeugung setzten
         * @param int $createtime
         */
        public function setCreatetime($createtime) {
            $this->createtime = (int) $createtime;
        }

        /**
         * Benutzer der Erzeugung setzten
         * @param int $createuser
         */
        public function setCreateuser($createuser) {
            $this->createuser = (int) $createuser;
        }

        /**
         * Zeitpunk der letzten Änderung setzten
         * @param int $changetime
         */
        public function setChangetime($changetime) {
            $this->changetime = (int) $changetime;
        }

        /**
         * Benutzer der letzten Änderung setzten
         * @param int $changeuser
         */
        public function setChangeuser($changeuser) {
            $this->changeuser = (int) $changeuser;
        }

        /**
         * Kommentar-aktiv-Status setzten
         * @param bool $comments
         */
        public function setComments($comments) {
            $this->comments = (int) $comments;
        }

        /**
         * Freigabe-Status setzten
         * @param bool $approval
         */
        public function setApproval($approval) {
            $this->approval = (int) $approval;
        }
        
        /**
         * Setzt Pfad zum Artikel-Bild
         * @param string $imagepath
         * @since FPCM 3.1.0
         */
        public function setImagepath($imagepath) {
            $this->imagepath = $imagepath;
        }
        
        /**
         * Artikel vollständig löschen erzwingen
         * @param bool $forceDelete
         */   
        public function setForceDelete($forceDelete) {
            $this->forceDelete = $forceDelete;
        }

        /**
         * MD5-Pfad setztne
         * @param string $str
         */
        public function setMd5path($str) {
            $this->md5path = md5($str);
        }

        /**
         * Liefert Pfad des Artikel-Revisionsverzeichnisses zurück
         * @return string
         */
        public function getRevisionsFolder() {
            return \fpcm\classes\baseconfig::$revisionDir."article{$this->id}/";
        }
        
        /**
         * schönen URL-Pfad zurückgeben
         * @return string
         */
        public function getArticleNicePath() {
            return strtolower(str_replace(array('_', ' ', '.', '!', '?', ':', ';'), '-', $this->title));
        }
        
        /**
         * Gibt Direkt-Link zum Artikel zurück
         * @return string
         */
        public function getArticleLink() {
            if (!$this->config->system_mode) {
                return \fpcm\classes\baseconfig::$rootPath.'index.php?module=fpcm/article&id='.$this->id;
            }
            
            return $this->config->system_url.'?module=fpcm/article&id='.$this->id;
        }
        
        /**
         * Erzeugt Short-Link zum Artikel zurück
         * @return string
         */
        public function getArticleShortLink() {
            
            $shortenerUrl = 'http://is.gd/create.php?format=simple&url='.urlencode($this->getArticleLink());
            
            if (!\fpcm\classes\baseconfig::canConnect()) return $shortenerUrl;

            $remote = fopen($shortenerUrl, 'r');
            
            if (!$remote) return $shortenerUrl;

            $url = fgetss($remote);
            
            return $this->events->runEvent('articleShortLink', array('artikellink' => urlencode($this->getArticleLink()), 'url' => $url))['url'];
        }
        
        /**
         * Liefert <img>-Tag für Artikel-Image zurück
         * @return string
         * @since FPCM 3.1.0
         */
        public function getArticleImage() {
            
            if (!trim($this->imagepath)) {
                return '';
            }
            
            return "<img class=\"fpcm-pub-article-image\" src=\"{$this->imagepath}\" alt=\"{$this->title}\" title=\"{$this->title}\">";
        }

        /**
         * Speichert eine neuen Artikel in der Datenbank
         * @return int
         */        
        public function save() {

            $this->removeBannedTexts();

            $params = $this->getPreparedSaveParams();
            $params = $this->events->runEvent('articleSave', $params);

            if (!$this->dbcon->insert($this->table, implode(',', array_keys($params)), implode(', ', $this->getPreparedValueParams(count($params))), array_values($params))) {
                return false;
            }
            
            $this->id = $this->dbcon->getLastInsertId();
            
            $this->cache->cleanup();

            if ($this->config->twitter_events['create'] && !$this->approval && !$this->postponed && !$this->draft && !$this->deleted && !$this->archived) {
                $this->createTweet();
            }
            
            $this->events->runEvent('articleSaveAfter', $this->id);
            
            return $this->id;
        }

        /**
         * Aktualisiert einen Artikel in der Datenbank
         * @return boolean
         */        
        public function update() {            

            $this->removeBannedTexts();

            $params     = $this->getPreparedSaveParams();
            $fields     = array_keys($params);
            
            $params[]   = $this->getId();
            $params     = $this->events->runEvent('articleUpdate', $params);

            $return = false;
            if ($this->dbcon->update($this->table, $fields, array_values($params), 'id = ?')) {
                $return = true;
            }
            
            $this->cache->cleanup();             
            $this->init();

            if ($this->config->twitter_events['update'] && !$this->approval && !$this->postponed && !$this->draft && !$this->deleted && !$this->archived) {
                $this->createTweet();
            }
            
            $this->events->runEvent('articleUpdateAfter', $this->id);
            
            return $return;            
        }
        
        /**
         * Löscht News in der Datenbank
         * @return bool
         */
        public function delete() {
            $this->deleteRevisions(array_keys($this->getRevisions()));

            $commentList = new \fpcm\model\comments\commentList();
            $commentList->deleteCommentsByArticle($this->id);

            if ($this->config->articles_trash && !$this->forceDelete) {
                $this->cache->cleanup();
                $this->deleted = 1;
                
                return $this->update();
            }
            
            return parent::delete();
        }

        /**
         * Erzeugt eine Revision des Artikels
         * @param int $timer
         * @return boolean
         */
        public function createRevision($timer = 0) {

            if (!is_dir($this->getRevisionsFolder())) {
                mkdir($this->getRevisionsFolder());
            }
            
            $content = $this->getPreparedSaveParams();            
            $content = $this->events->runEvent('createRevision', $content);
            
            if (!$timer) $timer = $this->changetime;
            
            $revision = new \fpcm\model\files\revision($timer, $this->getRevisionsFolder(), json_encode($content));
            
            if (!$revision->save()) {
                trigger_error('Unable to create article revision');
                return false;
            }
            
            return true;
        }
        
        /**
         * Gib Revisionen des Artikels zurück
         * @param bool $full Soll die Revision ganz zurückgegebn werden oder nur Titel
         * @return array
         */
        public function getRevisions($full = false) {
            
            $revisionFiles = glob($this->getRevisionsFolder().'*.php');
            
            if (!$revisionFiles || !count($revisionFiles)) return array();
            
            $revisionFiles = $this->events->runEvent('getRevisionsBefore', $revisionFiles);            
            
            $revisions = array();
            foreach ($revisionFiles as $revisionFile) {
                $revData = json_decode(file_get_contents($revisionFile), true);
                $revTime = (int) substr(basename($revisionFile), 3, -4);
                
                if (!is_array($revData) || !$revTime) continue;
                $revisions[$revTime] = $full ? $revData : $revData['title'];
            }
            
            $revisions = $this->events->runEvent('getRevisionsAfter', array('full' => $full, 'revisions' => $revisions))['revisions'];
            
            krsort($revisions);
            
            return $revisions;
            
        }

        /**
         * Lädt Revision eines Artikels
         * @param int $revisionTime Revisions-ID
         * @return boolean
         */
        public function getRevision($revisionTime) {
            
            $revision = new \fpcm\model\files\revision($revisionTime, $this->getRevisionsFolder());
            
            if (!$revision->exists()) return false;
            
            $revision = $this->events->runEvent('getRevision', $revision);
            
            foreach ($revision->getContent() as $key => $value) {                
                $this->$key = $value;                
            }            
            
            return true;            
        }
        
        /**
         * Stellt Revision eines Artikels wieder her
         * @param int $revisionTime Revisions-ID
         * @return boolean
         */
        public function restoreRevision($revisionTime) {
            if (!$this->createRevision(time())) return false;
            $this->getRevision($revisionTime);
            return $this->update();            
        }
        
        /**
         * Löscht Revisionen
         * @param array $revisionList Liste von Revisions-IDs
         * @return boolean
         */
        public function deleteRevisions(array $revisionList) {

            $revisionList = array_intersect(array_keys($this->getRevisions()), array_map('intval', $revisionList));
            
            $resFailed = 0;
            
            foreach ($revisionList as $revisionTime) {
                $revision = new \fpcm\model\files\revision($revisionTime, $this->getRevisionsFolder());
                if (!$revision->delete()) $resFailed++;
            }
            
            return $resFailed ? false : true;
        }
        
        /**
         * Erzeugt einen Tweet bei Twitter, wenn Verbindung aktiv und Events ausgewählt
         * @return boolean
         */
        public function createTweet() {

            if (!\fpcm\classes\baseconfig::canConnect() || (!$this->config->twitter_events['create'] && !$this->config->twitter_events['update'])) {
                return false;
            }

            /* @var $eventResult article */
            $eventResult = $this->events->runEvent('articleCreateTweet', $this);

            $author  = new \fpcm\model\users\author($eventResult->getCreateuser());
            
            $tpl = new \fpcm\model\pubtemplates\tweet();
            $tpl->setReplacementTags(array(
                '{{headline}}'  => $eventResult->getTitle(),
                '{{author}}'    => $author->getDisplayname(),
                '{{date}}'      => date($this->config->system_dtmask),
                '{{permaLink}}' => $eventResult->getArticleLink(),
                '{{shortLink}}' => $eventResult->getArticleShortLink()
            ));
            
            $twitter = new \fpcm\model\system\twitter();
            return $twitter->updateStatus($tpl->parse());
        }
        
        /**
         * Bereitet Daten für Speicherung in Datenbank vor
         * @param boolean $ignoreEditor
         * @return boolean
         */
        public function prepareDataSave($ignoreEditor = false) {
            if (!$this->config->system_editor && !$ignoreEditor) return false;
            
            $this->replaceBr();
            $this->content = str_replace(array('<br>', '<br />', '<br/>'), '', $this->content);
            $this->content = nl2br($this->content, false);
            
            $search  = array('p', 'ul', 'li', 'table', 'tr', 'th', 'td', 'div', 'blockquote', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6');
            array_map(array($this, 'replaceDirtyTags'), $search);

            return true;
        }
        
        /**
         * Bereitet Daten nach Laden aus Datenbank vor
         * @return boolean
         */
        public function prepareDataLoad() {
            if (!$this->config->system_editor) return false;

            $this->replaceBr();
            
            return true;
        }
        
        /**
         * Ersetzt <br>, <br /> bzw. <br/> durch Leerzeichen
         */
        private function replaceBr() {
            $this->content = str_replace(array('<br>', '<br />', '<br/>'), '', $this->content);
        }
        
        /**
         * Ersetzt "kaputte" HTML-Tag-Kombinationen in Zusammenhang mit automatischen <br>-Tags beim Speichern
         * @param string $htmlTag
         */
        private function replaceDirtyTags($htmlTag) {
            $search = array("<{$htmlTag}><br>", "<{$htmlTag}><br/>", "<{$htmlTag}><br />");
            $this->content = str_replace($search, "<{$htmlTag}>", $this->content);
            
            $search = array("</{$htmlTag}><br>", "</{$htmlTag}><br/>", "</{$htmlTag}><br />");
            $this->content = str_replace($search, "</{$htmlTag}>", $this->content);
        }
        
        /**
         * Führt Ersetzung von gesperrten Texten in Artikel-Daten durch
         * @return boolean
         * @since FPCM 3.2.0
         */
        private function removeBannedTexts() {

            $this->title     = $this->wordbanList->replaceItems($this->title);
            $this->content   = $this->wordbanList->replaceItems($this->content);
            $this->imagepath = $this->wordbanList->replaceItems($this->imagepath);
            
            return true;
        }
    }