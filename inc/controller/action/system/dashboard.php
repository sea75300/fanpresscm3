<?php
    /**
     * Dashboard controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\system;
    
    class dashboard extends \fpcm\controller\abstracts\controller {
        
        /**
         * Controller-View
         * @var \fpcm\model\view\acp
         */
        protected $view;
        
        /**
         * Dashboard-Container-Array
         * @var array
         */
        protected $containers = array();

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
            $this->view = new \fpcm\model\view\acp('index', 'dashboard');
        }
        
        /**
         * Controller-Processing
         * @return boolean
         */
        public function process() {
            if (!parent::process()) {
                return false;
            }

            if ($this->session->exists()) {
                $this->getClasses();                
            }
            
            $this->view->assign('containers', $this->containers);
            $this->view->render();            
        }
    
        /**
         * Container-Klassen ermitteln
         */
        protected function getClasses() {
            $containers = array_map(array($this, 'parseClassname'), glob(\fpcm\classes\baseconfig::$dashcontainerDir.'*.php'));            
            $containers = $this->events->runEvent('dashboardContainersLoad', $containers);
            
            $positions = array();
            foreach ($containers as $container) {
                /**
                 * @var \fpcm\model\abstracts\dashcontainer
                 */
                $containerObj = new $container();
                
                if (!is_a($containerObj, '\fpcm\model\abstracts\dashcontainer')) {
                    trigger_error('Dashboard container class "'.$container.'" must be an instance of "\fpcm\model\abstracts\dashcontainer".');
                    continue;
                }
                
                if (count($containerObj->getPermissions()) && !$this->permissions->check($containerObj->getPermissions())) continue;
                
                $position = $containerObj->getPosition();                
                if (!$position || isset($this->containers[$position])) {
                    $this->containers[]  = $containerObj;
                } else {
                    $this->containers[$position]  = $containerObj;
                }
                
                
            }
            
            ksort($this->containers);
        }
        
        /**
         * Container-Klassen-Name parsen
         * @param string $filename
         * @return string
         */
        protected function parseClassname($filename) {            
            return '\\fpcm\\model\\dashboard\\'.basename($filename, '.php');            
        }
    }
?>