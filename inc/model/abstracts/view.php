<?php
    /**
     * Allgemeines View Objekt
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\abstracts;
    
    /**
     * View basis model
     * 
     * @package fpcm.model.abstracts
     * @abstract
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    abstract class view extends \fpcm\model\abstracts\staticModel {

        /**
         * Pfad zur View
         * @var string
         */
        protected $viewPath = '';
        
        /**
         * Name zur View
         * @var string
         */
        protected $viewName = '';
        
        /**
         * Pfad + Datename zur View
         * @var string
         */
        protected $viewFile = '';

        /**
         * View-Variablen
         * @var array
         */
        protected $viewVars       = array();
        
        /**
         * View-Javascript-Dateien
         * @var array
         */
        protected $viewJsFiles    = array();
        
        /**
         * View-CSS-Dateien
         * @var array
         */
        protected $viewCssFiles   = array();

        /**
         * View-Message-Informationen
         * @var array
         */
        protected $messages       = array();
        
        /**
         * View-Javascript-Variablen
         * @var array
         */
        protected $jsvars         = array();
        
        /**
         * View Filelib
         * @var \fpcm\model\system\fileLib
         */
        protected $fileLib        = null;
        
        /**
         * Erfolgt Aufruf durch mobile Endgerät aufgerufen
         * @var bool
         */
        protected $isMobile       = false;
        
        /**
         * Module-View-Type
         * @var string
         */
        protected $moduleViewType     = 'acp';

        /**
         * Konstruktor
         * @param string $viewName View-Name, ohne Endung .php
         * @param string $viewPath View-Pfad unterhalb von core/views/
         */
        function __construct($viewName = '', $viewPath = '') {
            parent::__construct();
            if (!$this->viewPath) {
                $this->viewPath = \fpcm\classes\baseconfig::$viewsDir.$viewPath;                
            }

            if (!empty($viewName)) $this->viewName = $viewName.'.php';
            
            $this->fileLib = new \fpcm\model\system\fileLib();
            
            $className = explode('\\', get_class($this));
            call_user_func(array($this, 'initFileLib'.ucfirst(array_pop($className))));
            
            include_once \fpcm\classes\loader::libGetFilePath('mobile_detect', 'Mobile_Detect.php');
            
            $mobileDetect   = new \Mobile_Detect();
            $this->isMobile = $mobileDetect->isMobile();
            
        }
        
        /**
         * ACP-Dateilibrary initialisieren
         */
        private function initFileLibAcp() {
            
            if (is_object($this->language)) {
                $this->jsvars = array(
                    'fpcmQuickLinks'       => $this->language->translate('GLOBAL_QUICKLINKS'),
                    'fpcmOpenProfile'      => $this->language->translate('PROFILE_MENU_OPENPROFILE'),
                    'fpcmLogout'           => $this->language->translate('LOGOUT_BTN'),
                    'fpcmConfirmMessage'   => $this->language->translate('CONFIRM_MESSAGE'),
                    'fpcmAjaxErrorMessage' => $this->language->translate('AJAX_REQUEST_ERROR'),
                    'fpcmClose'            => $this->language->translate('GLOBAL_CLOSE'),
                    'fpcmYes'              => $this->language->translate('GLOBAL_YES'),
                    'fpcmNo'               => $this->language->translate('GLOBAL_NO'),
                    'fpcmNewWindow'        => $this->language->translate('GLOBAL_OPENNEWWIN')
                );
            }
            
            
            $this->viewCssFiles = $this->fileLib->getCsslib();
            $this->viewJsFiles  = $this->fileLib->getJslib();
        }
        
        /**
         * Dateilibrary für Modul-View initialisieren in Abhängzigkeiten von übergebenem Typ
         */
        private function initFileLibModule() {
            call_user_func(array($this, 'initFileLib'.ucfirst($this->moduleViewType)));
        }

        /**
         * Öffentliche Dateilibrary initialisieren
         */
        private function initFileLibPub() {
            $this->viewCssFiles = $this->fileLib->getCssPubliclib();
            $this->viewJsFiles  = $this->fileLib->getJsPubliclib();
        }
        
        /**
         * Dateilibrary in AJAX-View initialisieren
         */
        private function initFileLibAjax() {
            $this->viewCssFiles = array();
            $this->viewJsFiles  = array();
        }
        
        /**
         * Dateilibrary in Error-View initialisieren
         */
        private function initFileLibError() {
            $this->viewCssFiles = $this->fileLib->getCsslib();
            $this->viewJsFiles  = $this->fileLib->getJslib();
        }

        /**
         * View-Pfad zurückgeben
         * @return string
         */
        public function getViewPath() {
            return $this->viewPath;
        }

        /**
         * View-Name zurückgeben
         * @return string
         */
        public function getViewName() {
            return $this->viewName;
        }

        /**
         * View-Name setzten
         * @param string $viewPath
         */
        public function setViewPath($viewPath) {
            $this->viewPath = \fpcm\classes\baseconfig::$viewsDir.'/'.$viewPath;
        }

        /**
         * View-Name setzten
         * @param string $viewName
         */
        public function setViewName($viewName) {
            $this->viewName = $viewName.'php';
        }

        /**
         * View-Datei zurücliefern
         * @return string
         */
        public function getViewFile() {
            return $this->viewFile;
        }

        /**
         * View-Variablen ausgeben
         * @return string
         */
        public function getViewVars() {
            return $this->viewVars;
        }

       /**
        * View-Datei setzten
        * @param string $viewFile
        */
        public function setViewFile($viewFile) {
            $this->viewFile = $viewFile;
        }

        /**
         * View-Variablen überschreiben
         * @param array $viewVars
         */
        public function setViewVars(array $viewVars) {
            $this->viewVars = $viewVars;
        }                     
        
        /**
         * JavaScript-Variablen in View auslesen
         * @return array
         */
        public function getViewJsFiles() {
            return $this->viewJsFiles;
        }

        /**
         * JavaScript-Variablen in View setzten
         * @param array $viewJsFiles
         */
        public function setViewJsFiles(array $viewJsFiles) {
            $this->viewJsFiles = array_merge($this->viewJsFiles, $viewJsFiles);
        }        
 
        /**
         * CSS-Dateien in View auslesen
         * @return array
         */        
        public function getViewCssFiles() {
            return $this->viewCssFiles;
        }

        /**
         * CSS-Dateien in View erweitern
         * @param array $viewCssFiles
         */
        public function setViewCssFiles(array $viewCssFiles) {
            $this->viewCssFiles = array_merge($this->viewCssFiles, $viewCssFiles);
        }
        
        /**
         * Gibt registrierte Nachrichten zurück
         * @return array
         */
        public function getMessages() {
            return $this->messages;
        }

        /**
         * JS-Variable zur Nutzung hinzufügen
         * @param mixed $jsvars
         */
        public function addJsVars(array $jsvars) {
            $this->jsvars = array_merge($this->jsvars, $jsvars);
        }

        /**
         * Force to load jQuery in Pub-Controllers before other JS-Files if not already done
         * @since FPCM 3.2.0
         */
        public function prependjQuery() {
            if ($this->config->system_loader_jquery) return false;
            array_unshift($this->viewJsFiles, \fpcm\classes\loader::libGetFileUrl('jquery', 'jquery-2.2.0.min.js'));
        }

        /**
         * JS-Variable zur Nutzung abrufen
         * @return array
         */
        protected function getJsVars() {
            return $this->jsvars;
        }
        
        /**
         * Weißt Variable in View Wert zu
         * @param string $varName
         * @param mixes $varValue
         */       
        public function assign($varName, $varValue) {
            $this->viewVars[$varName] = $varValue;
        }
        
        /**
         * rote Fehlermeldungen ausgeben
         * @param string $messageText
         * @param string $params
         * @return void
         */
        public function addErrorMessage($messageText, $params= array()) {            
            if ($this->language->translate($messageText)) {
                $this->messages[][$this->language->translate($messageText, $params)] = 'error';
                return;
            }
            
            $this->messages[][$messageText] = 'error';
        }
        
        /**
         * blaue Info-Meldungen ausgeben
         * @param string $messageText
         * @param string $params
         * @return void
         */
        public function addNoticeMessage($messageText, $params= array()) {
            if ($this->language->translate($messageText)) {
                $this->messages[][$this->language->translate($messageText, $params)] = 'notice';
                return;
            }
            
            $this->messages[][$messageText] = 'notice';
        }
        
        /**
         * glebe Meldungen ausgeben
         * @param string $messageText
         * @param string $params
         * @return void
         */
        public function addMessage($messageText, $params= array()) {
            if ($this->language->translate($messageText)) {
                $this->messages[][$this->language->translate($messageText, $params)] = 'neutral';
                return;
            }
            
            $this->messages[][$messageText] = 'neutral';
        }        
        
        /**
         * Prüft, ob View-Datei vorhanden ist und lädt diese
         * @return bool
         */        
        public function render() {
            $this->viewFile = $this->viewPath.$this->viewName;
            
            if (!file_exists($this->viewFile)) {
                trigger_error("View file {$this->viewFile} not found!");
                return false;
            }
            
            return true;
        }
        
        /**
         * Prüft ob aktuelle Browser einem bestimmten Browser entspricht (nicht unbedingt 100%-tig zuverlässig!)
         * @param string $key
         * @return boolean
         * @static
         */
        public static function isBrowser($key) {            
            if (!isset($_SERVER['HTTP_USER_AGENT'])) return true;
            return preg_match("/($key)/is", $_SERVER['HTTP_USER_AGENT']) === 1 ? true : false;
        }
        
    }
?>