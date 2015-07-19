<?php
    /**
     * FanPress CM API class
     * 
     * API class for integration of FanPress CM into an website.
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    require_once __DIR__.'/inc/controller/main.php';
    require_once __DIR__.'/inc/common.php';
    
    /**
     * FanPress CM API class
     * 
     * @package fpcmapi
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */    
    class fpcmAPI {

        /**
         * API-Controller
         * @var array
         */
        protected $controllers = array();
        
        /**
         * Ausführung unter PHP 5.4+
         * @var bool
         */
        protected $versionFailed = false;

        /**
         * Konstruktor, prüft PHP-Version, Installer-Status und Datenbank-Config-Status
         * @return void
         */
        public function __construct() {

            if (version_compare(PHP_VERSION, '5.4.0', '<') || !\fpcm\classes\baseconfig::dbConfigExists() || \fpcm\classes\baseconfig::installerEnabled()) {
                $this->versionFailed = true;
                return;
            }            
            
            \fpcm\classes\http::init();        
        }

        /**
         * Lädt FPCM-Controller
         */
        public function registerController() {
            $this->controllers = \fpcm\classes\baseconfig::getControllers();
        }

        /**
         * Artikel anzeigen
         * @return boolean
         */
        public function showArticles() {

            if ($this->versionFailed) return false;
            
            $this->registerController();

            $module = (!is_null(\fpcm\classes\http::get('module'))) ? \fpcm\classes\http::get('module', array(1,4,7)) : 'fpcm/list';
            if (strpos($module, 'fpcm/') === false || !in_array($module, array('fpcm/list', 'fpcm/article', 'fpcm/archive'))) return false;
            
            $controllerName  = "fpcm/controller/";        
            $controllerName .= (isset($this->controllers[$module])) ? $this->controllers[$module] : ($module ? $module : 'action\system\login');
            $controllerName  = str_replace('/', '\\', $controllerName);       

            if (!class_exists($controllerName)) {
                trigger_error('Undefined controller called: '.$module);
                return false;
            }

            /**
             * @var abstracts\controller
             */
            $controller = new $controllerName(true);    

            if (!is_a($controller, 'fpcm\controller\abstracts\controller')) {
                die("ERROR: The controller for <b>$module</b> must be an instance of <b>fpcm\controller\abstracts\controller</b>. ;)");
                return false;
            }

            if (!$controller->request()) return false;

            $controller->process();
        }
        
        /**
         * Latest News anzeigen
         * @return boolean
         */
        public function showLatestNews() {
            
            if ($this->versionFailed) return false;

            $module = (!is_null(\fpcm\classes\http::get('module'))) ? \fpcm\classes\http::get('module', array(1,4,7)) : false;

            if (!$module || strpos($module, 'fpcm/') === false || $module != 'fpcm/latest') return false;            
            
            /**
             * @var abstracts\controller
             */
            $controller = new \fpcm\controller\action\pub\showlatest(true);

            if (!is_a($controller, 'fpcm\controller\abstracts\controller')) {
                die("ERROR: The controller for <b>$module</b> must be an instance of <b>fpcm\controller\abstracts\controller</b>. ;)");
                return false;
            }

            if (!$controller->request()) return false;

            $controller->process();
        }
        
        /**
         * aktuelle Seitennummer anzeigen
         * @param string $divider
         */
        public function showPageNumber($divider = "&bull; Page") {            
            $controller = new fpcm\controller\action\pub\showtitle('page', $divider);
            $controller->process();
        }
        
        /**
         * Title des aktuellen Artikels anzeigen
         * @param string $divider
         */
        public function showTitle($divider = "&bull;") {            
            $controller = new fpcm\controller\action\pub\showtitle('title', $divider);
            $controller->process();
        }
        
    }