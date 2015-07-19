<?php
    /**
     * Installer view
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\view;
    
    /**
     * Installer View Objekt
     * 
     * @package fpcm.model.view
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class installer extends \fpcm\model\abstracts\view {

        /**
         * Sprachobjekt
         * @var \fpcm\classes\language
         */
        protected $lang;
        
        /**
         * Versionsstring
         * @var string
         */
        protected $version;

        /**
         * Konstruktor
         * @param string $viewName View-Name, ohne Endung .php
         * @param string $viewPath View-Pfad unterhalb von core/views/installer/
         */
        public function __construct($viewName, $langCode) {
            $this->viewPath     = \fpcm\classes\baseconfig::$viewsDir.'installer/';
            $this->viewName     = $viewName.'.php';
            
            $this->language     = new \fpcm\classes\language($langCode);
            $this->fileLib      = new \fpcm\model\system\fileLib();

            $this->viewCssFiles = $this->fileLib->getCsslib();
            $this->viewJsFiles  = $this->fileLib->getJslib();
            
            include \fpcm\classes\baseconfig::$versionFile;
            $this->version      = $fpcmVersion;
            
            $this->addJsVars(array(
                'fpcmCronAsyncDiabled' => true
            ));
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
                
                foreach ($viewVars as $key => $value) { $$key = $value; }

                include_once \fpcm\classes\baseconfig::$viewsDir.'common/header.php';                
                include_once \fpcm\classes\baseconfig::$viewsDir.'common/messages.php';
                
                if ($this->getViewFile()) include_once $this->getViewFile();

                include_once \fpcm\classes\baseconfig::$viewsDir.'common/footer.php';
            }
        }
        
        /**
         * View-Variablen initialisieren
         */
        protected function initAssigns() {

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
             * System config data
             */
            $this->assign('FPCM_VERSION', $this->version);
            
            $this->assign('FPCM_LOGGEDIN', false);
            $this->assign('FPCM_CURRENT_MODULE', 'installer');
            
            helper::init($this->language->getLangCode());
        }
        
        /**
         * Gibt Versionstring zurück
         * @return string
         */
        public function getVersion() {
            return $this->version;
        }

    }
?>