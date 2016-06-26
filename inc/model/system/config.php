<?php
    /**
     * Configuration object
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\system;
    
    
    /**
     * System config Objekt
     * 
     * @property string $system_version Version
     * @property string $system_email E-Mail_Adresse
     * @property string $system_url Frontend-Url
     * @property string $system_lang Sprache
     * @property string $system_dtmask Date-Time-Maske
     * @property bool   $system_comments_enabled Kommentare aktiv
     * @property int    $system_session_length ACP-Session Länge
     * @property bool   $system_mode Frontend-Modus (0 = iframe, 1= phpinclude)
     * @property string $system_css_path Pfad zur CSS-Datei
     * @property bool   $system_show_share Share-Buttons anzeigen
     * @property string $system_timezone Zeitzone
     * @property int    $system_cache_timeout Cache-Timeout
     * @property bool   $system_loader_jquery jQuery in Frontend laden
     * @property bool   $system_editor aktiver Editor (0 = TinyMCE, 1= HTML)
     * @property int    $system_editor_fontsize Standard-Schriftgröße im Editor
     * @property bool   $system_maintenance Wartungsmodusaktiv
     * @property int    $system_loginfailed_locked Anzahl fehlgeschlagener Login-Versuche, nach denen Login temporär gesperrt wird
     * @property int    $system_updates_devcheck Entwickler-Versionen bei Update-Prüfung anzeigen
     * @property bool   $system_updates_emailnotify E-Mail-Benachrichtigung über Updates
     * 
     * @property bool   $articles_revisions Revisionen aktiv
     * @property bool   $articles_trash Papierkorb aktiv
     * @property int    $articles_limit Artikel pro Seite im Fronend
     * @property string $articles_template_active aktives Template für Artikel-Liste
     * @property string $article_template_active aktives Template für Artikel-Einzel-Ansicht
     * @property bool   $articles_archive_show Archiv-Link anzeigen
     * @property string $articles_sort Sortierung der Artikel im Frontend
     * @property string $articles_sort_order Reihenfolge der Sortierung der Artikel im Frontend
     * @property bool   $articles_rss RSS-Feed ist aktiv
     * @property int    $articles_acp_limit Anzahl an Artikeln in der ACP-Liste
     * 
     * @property string $comments_template_active aktives Kommentar-Template
     * @property int    $comments_flood Sperre zwischen zwei Kommentaren
     * @property bool   $comments_email_optional E-Mail muss beim Kommentar-Schreiben angegegebn werden
     * @property bool   $comments_confirm Kommentare müssen freigegeben werden
     * @property string $comments_antispam_question Spam-Captcha-Frage
     * @property string $comments_antispam_answer Spam-Captcha-Antwort
     * @property int    $comments_notify wohin sollen Benachrichtigung bei neuem Kommentar gehen (0 = nur globale E-MailAdresse, 1 = nur Author, 2 = beide)
     * @property int    $comments_markspam_commentcount Anzahl an Spam deklarierter vorhandener Kommentare, über der ein ein neuer Kommentar automatisch als Spam markiert wird
     * 
     * @property int    $file_img_thumb_width Breite der Thumbnails
     * @property int    $file_img_thumb_height Höhe der Thumbnails
     * @property bool   $file_uploader_new jQuery-Uploader aktiv
     * 
     * @property array  $twitter_data Daten für Twitter-Verbindung
     * @property array  $twitter_events Events, wenn Tweets erzeugt werden sollen
     * 
     * @package fpcm.model.system
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class config extends \fpcm\model\abstracts\model {

        /**
         * Neue Konfiguration
         * @var array
         */        
        protected $newConfig = array();
        
        /**
         * this->data cachen
         * @var bool
         */
        protected $useCache  = true;

        /**
         * Konstruktor
         * @param bool $initUserSettings Benutzereinstellungen laden
         * @param bool $useCache Configuration aus Cache laden
         * @return boolean
         */
        function __construct($initUserSettings = true, $useCache = true) {
            
            $this->table    = \fpcm\classes\database::tableConfig;
            $this->dbcon    = \fpcm\classes\baseconfig::$fpcmDatabase;
            $this->events   = \fpcm\classes\baseconfig::$fpcmEvents;
            $this->cache    = new \fpcm\classes\cache('config');
            $this->useCache = $useCache;
            
            if (\fpcm\classes\baseconfig::installerEnabled()) return false;
            
            $this->init();
            
            if ($initUserSettings) {
                $this->setUserSettings();
            }            
        }
        
        /**
         * Speichert neue Konfiguration
         * @param array $newConfig
         */
        public function setNewConfig(array $newConfig) {
            $this->newConfig = $newConfig;
        }        

        /**
         * not used
         * @return boolean
         */
        public function save() {
            return false;
        }
        
        /**
         * not used
         * @return boolean
         */
        public function delete() {
            return false;
        }

        /**
         * Konfiguration aktualisieren
         * @return boolean
         */
        public function update() {
            if (!count($this->newConfig)) return false;

            $params = $this->events->runEvent('configUpdate', $this->newConfig);

            foreach ($params as $key => $value) {
                if (!isset($this->data[$key]) && !\fpcm\classes\baseconfig::installerEnabled()) continue;      
                if (!$this->dbcon->update($this->table, array('config_value'), array($value, $key), "config_name ".$this->dbcon->dbLike()." ?")) {
                    trigger_error('Unable to update config '.$key);
                }
            }

            $this->refresh();
            
            return true;            
        }
        
        /**
         * Neuen Config-Key erzeugen
         * @param string $keyname
         * @param string $keyvalue
         * @return boolean
         */
        public function add($keyname, $keyvalue) {
            if (isset($this->data[$keyname])) return -1;

            $keyvalue = is_array($keyvalue) ? json_encode($keyvalue) : $keyvalue;
            $res = $this->dbcon->insert($this->table, 'config_name, config_value', '?, ?', array($keyname, $keyvalue));
            
            $this->refresh();
            
            return $res;
        }
        
        /**
         * Config Key löschen
         * @param string $keyname
         * @return boolean
         */
        public function remove($keyname) {
            if (!isset($this->data[$keyname])) return false;

            $res = $this->dbcon->delete($this->table, "config_name ".$this->dbcon->dbLike()." ?", array($keyname));
            
            $this->refresh();
            
            return $res;
        }
        
        /**
         * Überschreibt systemweite Einstellungen mit Benutzer-Einstellungen
         * @return void
         */
        public function setUserSettings() {

            if (!defined('FPCM_USERID') || !FPCM_USERID) return false;

            $cache2 = new \fpcm\classes\cache($this->cacheName.'_user'.FPCM_USERID);
            
            $userData = $cache2->read();
            
            if ($cache2->isExpired() || !$this->useCache || !is_array($userData)) {
                $userData = $this->dbcon->fetch($this->dbcon->select(\fpcm\classes\database::tableAuthors, 'id, usrmeta', 'id = ?', array(FPCM_USERID)));
                $userData = json_decode($userData->usrmeta, true);

                if (!is_array($userData)) return false;                    
                
                $cache2->write($userData, $this->system_cache_timeout);
            }

            foreach ($userData as $key => $value) {
                $this->data[$key] = $value;
            }
            
            if ($this->system_lang != \fpcm\classes\baseconfig::$fpcmLanguage->getLangCode()) {
                \fpcm\classes\baseconfig::$fpcmLanguage = new \fpcm\classes\language($this->system_lang);                
            }
        }
        
        /**
         * Wartungsmodus aktivieren
         * @param bool $mode
         * @return bool
         */
        public function setMaintenanceMode($mode) {
            $this->newConfig = array('system_maintenance' => (int) $mode);
            return $this->update();
        }

        /**
         * Inittiert Objekt mit Daten aus der Datenbank
         */
        protected function init() {
            
            if (\fpcm\classes\baseconfig::installerEnabled()) return false;
            
            if ($this->cache->isExpired() || !$this->useCache) {
                $configData = $this->dbcon->fetch($this->dbcon->select($this->table), true);
                foreach ($configData as $data) {
                    $this->data[$data->config_name] = $data->config_value;
                }

                $this->data['twitter_data'] = json_decode($this->data['twitter_data'], true);
                $this->data['twitter_events'] = json_decode($this->data['twitter_events'], true);

                $this->cache->write($this->data, $this->data['system_cache_timeout']);
                
                return;
            }
            
            $this->data = $this->cache->read();
        }
        
        /**
         * Config-Refresh
         */
        private function refresh() {
            $this->cache->cleanup();
            $this->init();            
        }
        
    }
