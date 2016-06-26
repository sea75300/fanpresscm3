<?php
    /**
     * Main controller
     * 
     * Main controller used by index.php
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller;

    /**
     * Main controller
     * 
     * @package fpcm.controller.main
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class main {

        /**
         *
         * @var array
         */
        protected $controllers = array();

        /**
         * Konstruktor
         */
        public function __construct() {

            if (version_compare(PHP_VERSION, '5.4.0', '<')) {
                die('FanPress CM requires at least PHP 5.4.0 or better! :(');
            }

            \fpcm\classes\http::init();

            if (!\fpcm\classes\baseconfig::installerEnabled() && !\fpcm\classes\baseconfig::dbConfigExists()) {
                die('You have to install FanPress CM 3 before using it.');
            }

        }

        /**
         * Controller registrieren
         */
        public function registerController() {
            $this->controllers = \fpcm\classes\baseconfig::getControllers();
        }

        /**
         * Controller-Processing
         * @return boolean
         */
        public function exec() {
            $this->registerController();

            $module = (!is_null(\fpcm\classes\http::get('module'))) ? \fpcm\classes\http::get('module', array(1,4,7)) : false;

            if (!$module) {
                header('Location: index.php?module=system/login');
                return true;
            }
            
            $controllerName = (isset($this->controllers[$module]) ? $this->controllers[$module] : '');
            if (strpos($controllerName, 'fpcm/modules/') === false) $controllerName  = "fpcm/controller/".$controllerName;
            $controllerName  = str_replace('/', '\\', $controllerName);

            if (!class_exists($controllerName)) {
                trigger_error('Undefined controller called: '.$module);
                $this->errorPage("ERROR: The controller class <b>$module</b> does not exist! :/");
            }

            /**
             * @var abstracts\controller
             */
            $controller = new $controllerName();    

            if (!is_a($controller, 'fpcm\controller\abstracts\controller')) {
                trigger_error("ERROR: The controller for <b>$module</b> must be an instance of <b>fpcm\controller\abstracts\controller</b>.");
                die("ERROR: The controller for <b>$module</b> must be an instance of <b>fpcm\controller\abstracts\controller</b>. ;)");
            }

            if (!$controller->request()) return false;

            $controller->process();         
        }

        /**
         * Fehlerseite ausgeben
         * @param string $text
         */
        private function errorPage($text) {        
            $view = new \fpcm\model\view\error();
            $view->setMessage($text);
            $view->render();
            die();
        }

    }