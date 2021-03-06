<?php

/**
 * Controller to upgrade to version 4.9
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\action\packagemgr;

class updatev4 extends \fpcm\controller\abstracts\controller {

    /**
     * Controller-View
     * @var \fpcm\model\view\acp
     */
    protected $view;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct();

        $this->checkPermission = ['system' => 'update'];
        $this->view = new \fpcm\model\view\acp('upgradev4', 'packagemgr');
    }

    /**
     * Controller-Processing
     */
    public function process()
    {
        $updater = new \fpcm\model\updater\system();
        $updater->checkUpdates();
        
        if (!parent::process() || !$updater->getRemoteData('v4Available')) {
            $this->view = new \fpcm\model\view\error();
            $this->view->setMessage('Version 4 is not available.');
            $this->view->render();
            exit;
        }

        $this->config->setMaintenanceMode(false);

        $update = new \fpcm\model\packages\updatev4('update', 'fanpress_update', $updater->getRemoteData('v4version'), false);
        $this->view->addJsVars([
            'upgradeUrl' => $update->getRemoteFile(),
            'updateDbUrl' => \fpcm\classes\tools::getControllerLink('package/sysupdate', ['update-db' => 1])
        ]);
        
        $this->view->addJsLangVars([
            'redircErr' => $this->lang->translate('UPGARDEV4_REDIRECT_ERR')
        ]);
        
        $this->view->setViewJsFiles(['upgradev4.js']);
        $this->view->render();
    }

}
