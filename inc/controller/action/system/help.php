<?php
    /**
     * Help view controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\system;
    
    class help extends \fpcm\controller\abstracts\controller {
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array();

            $this->view   = new \fpcm\model\view\acp('help', 'system');
        }
        
        /**
         * Controller-Processing
         * @return boolean
         */
        public function process() {
            if (!parent::process()) return false;

            $xml = simplexml_load_string($this->lang->getHelp());
            
            $contents = array();
            
            foreach ($xml->chapter as $chapter) {
                $contents[trim($chapter->headline)] = trim($chapter->text);
            }
            
            $contents = $this->events->runEvent('extendHelp', $contents);
            
            $this->view->assign('chapters', $contents);
            
            $this->view->render();
        }
        
    }
?>
