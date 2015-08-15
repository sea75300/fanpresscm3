<?php
    /**
     * IP address add controller
     * @category Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\ips;
    
    class ipadd extends \fpcm\controller\abstracts\controller {

        /**
         * Controller-View
         * @var \fpcm\model\view\acp
         */
        protected $view;

        /**
         * Ip-Adress-Objekt
         * @var \fpcm\model\ips\ipaddress
         */
        protected $ipaddress;

        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'options');
            
            $this->view = new \fpcm\model\view\acp('ipadd', 'ips');
            $this->ipaddress = new \fpcm\model\ips\ipaddress();
        }

        public function request() {
            
            if ($this->buttonClicked('ipSave') && !$this->checkPageToken()) {
                $this->view->addErrorMessage('CSRF_INVALID');
                return true;
            }
            
            if ($this->buttonClicked('ipSave')) {
                $this->ipaddress->setIpaddress($this->getRequestVar('ipaddress'));
                $this->ipaddress->setIptime(time());
                $this->ipaddress->setUserid($this->session->getUserId());
                $this->ipaddress->setNoaccess(!is_null($this->getRequestVar('noaccess')));
                $this->ipaddress->setNocomments(!is_null($this->getRequestVar('nocomments')));
                $this->ipaddress->setNologin(!is_null($this->getRequestVar('nologin')));

                if ($this->getRequestVar('ipaddress') && $this->ipaddress->save() && $this->getRequestVar('ipaddress') != \fpcm\classes\http::getIp()) {
                    $this->redirect ('ips/list', array('added' => 1));
                } else {
                    $this->view->addErrorMessage('SAVE_FAILED_IPADDRESS');
                }
            }
            
            return true;
            
        }
        
        public function process() {
            if (!parent::process()) return false;
            $this->view->render();            
        }

    }
?>