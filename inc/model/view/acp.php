<?php
    /**
     * ACP view
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\view;
    
    /**
     * ACP View Objekt
     * 
     * @package fpcm.model.view
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class acp extends \fpcm\model\abstracts\view {

        /**
         * soll Header angezeigt werden
         * @var bool
         */
        private $showHeader     = true;

        /**
         * soll Footer angezeigt werden
         * @var bool
         */
        private $showFooter     = true;
        
        /**
         * Konstruktor
         * @param string $viewName View-Name, ohne Endung .php
         * @param string $viewPath View-Pfad unterhalb von core/views/
         */
        public function __construct($viewName = '', $viewPath = '') {
            parent::__construct($viewName, trim($viewPath, '/').'/');
        }        
        
        /**
         * Header angezeigen Status
         * @return bool
         */
        public function getShowHeader() {
            return $this->showHeader;
        }

        /**
         * Footer angezeigen Status
         * @return bool
         */
        public function getShowFooter() {
            return $this->showFooter;
        }

        /**
         * Header angezeigen Status setzten
         * @param bool $showHeader
         */
        public function setShowHeader($showHeader) {
            $this->showHeader = $showHeader;
        }

        /**
         * Footer angezeigen Status setzten
         * @param bool $showFooter
         */
        public function setShowFooter($showFooter) {
            $this->showFooter = $showFooter;
        }
        
        /**
         * Erzeugt "Nicht gefunden" View
         * @param string $message
         * @param string $action
         */
        public function setNotFound($message, $action) {
            $this->setViewName('notfound.');
            $this->setViewPath('common/');
            
            $this->addErrorMessage($message);
            $this->assign('messageVar', $message);
            $this->assign('backaction', $action);
        }

        /**
         * Lädt Datei, fügt View-Element, Header & Footer zusammen und erstellt Variablen für View
         * @see view
         * @return void
         */
        public function render() {            
            if (parent::render()) {
                $this->initAssigns();
                
                $viewVars = $this->getViewVars();                
                $viewVars = $this->events->runEvent('viewRenderBefore', $viewVars);
                
                foreach ($viewVars as $key => $value) { $$key = $value; }

                if ($this->showHeader) {
                    include_once \fpcm\classes\baseconfig::$viewsDir.'common/header.php';
                } else {
                    include_once \fpcm\classes\baseconfig::$viewsDir.'common/headersimple.php';
                }                
                
                include_once \fpcm\classes\baseconfig::$viewsDir.'common/messages.php';
                
                if ($this->getViewFile()) include_once $this->getViewFile();

                if ($this->showFooter) {
                    include_once \fpcm\classes\baseconfig::$viewsDir.'common/footer.php';
                } else {
                    include_once \fpcm\classes\baseconfig::$viewsDir.'common/footersimple.php';
                }
                
                $this->events->runEvent('viewRenderAfter');
            }
        }
        
        /**
         * View-Variablen initialisieren
         */
        protected function initAssigns() {
            
            /**
             * Current module
             */
            $this->assign('FPCM_CURRENT_MODULE', \fpcm\classes\http::get('module'));
            
            if ($this->session->exists()) {
                $this->assign('FPCM_USER', $this->session->currentUser->getDisplayName());
                $this->assign('FPCM_SESSION_LOGIN', $this->session->getLogin());
                $nav = new \fpcm\model\theme\navigation();
                $this->assign('FPCM_NAVIGATION', $nav->render());
                $this->jsvars = array('fpcmSessionCheckEnabled' => true, 'fpcmSessionCheckMsg' => $this->language->translate('SESSION_TIMEOUT')) + $this->jsvars;
            }
            
            /**
             * CSS und JS Files
             */
            $this->assign('FPCM_CSS_FILES', $this->getViewCssFiles());
            $this->assign('FPCM_JS_FILES', $this->getViewJsFiles());
            $this->assign('FPCM_JS_VARS', $this->getJsVars());
            
            /**
             * Pfade
             */
            $this->assign('FPCM_BASELINK', \fpcm\classes\baseconfig::$rootPath);
            $this->assign('FPCM_THEMEPATH', \fpcm\classes\baseconfig::$themePath);
            $this->assign('FPCM_BASEMODULELINK', \fpcm\classes\baseconfig::$rootPath.'index.php?module=');
            $this->assign('FPCM_SELF', $_SERVER['PHP_SELF']);
            
            /**
             * Sprache
             */
            $this->assign('FPCM_LANG', $this->language);
            
            /**
             * Meldungen
             */
            $this->assign('FPCM_MESSAGES', $this->getMessages());
            
            /**
             * Login-Status
             */
            $this->assign('FPCM_LOGGEDIN', $this->session->exists());
            
            /**
             * Aufruf durch mobile Endgerät
             */
            $this->assign('FPCM_ISMOBILE', $this->isMobile);
            
            /**
             * System config data
             */
            $this->assign('FPCM_VERSION', $this->config->system_version);
            $this->assign('FPCM_FRONTEND_LINK', $this->config->system_url);
            $this->assign('FPCM_DATETIME_MASK', $this->config->system_dtmask);
            $this->assign('FPCM_DATETIME_ZONE', $this->config->system_timezone);
            $this->assign('FPCM_MAINTENANCE_MODE', $this->config->system_maintenance);
            $this->assign('FPCM_CRONJOBS_DISABLED', \fpcm\classes\baseconfig::asyncCronjobsEnabled());
            
            helper::init($this->config->system_lang);
        }
    }
?>