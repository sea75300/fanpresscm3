<?php

/**
 * AJAX system updates controller
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\ajax\packagemgr;

/**
 * AJAX-Controller Paketmanager - System-Updater
 * 
 * @package fpcm\controller\ajax\packagemgr\sysupdater
 * @author Stefan Seehafer <sea75300@yahoo.de>
 */
class updatev4 extends \fpcm\controller\abstracts\ajaxController {
    
    /**
     * Update-Package-Object
     * @var \fpcm\model\packages\updatev4
     */
    protected $pkg;

    /**
     * Controller-Processing
     */
    public function process()
    {
        $updater = new \fpcm\model\updater\system();
        $updater->checkUpdates();

        if (!parent::process() || !\fpcm\classes\baseconfig::canConnect() || !$updater->getRemoteData('v4Available')) {
            return false;
        }

        $this->pkg = new \fpcm\model\packages\updatev4('update', 'fanpress_update', $updater->getRemoteData('v4version'), false);

        $method = 'process'.ucfirst($this->getRequestVar('action'));
        if (!method_exists($this, $method)) {
            return false;
        }

        call_user_func([$this, $method]);
        $this->getSimpleResponse();
    }

    private function processDownload()
    {
        $this->res = $this->pkg->download();
        if ($this->res === true) {
            fpcmLogSystem('Downloaded update package successfully from ' . $this->pkg->getRemoteFile());
            $this->returnData['code'] = true;
            return true;
        }

        fpcmLogSystem('Error while downloading update package from ' . $this->pkg->getRemoteFile());
        $this->returnData['code'] = false;
        $this->returnData['errorMsg'] = $this->lang->translate('PACKAGES_FAILED_GENERAL');
        return false;
    }

    private function processExtract()
    {
        $this->res = $this->pkg->extract();
        $from = \fpcm\model\files\ops::removeBaseDir($this->pkg->getLocalFile());

        if ($this->res === true) {
            fpcmLogSystem('Extracted update package successfully from ' . $from);
            $this->returnData['code'] = true;
            return true;
        }

        fpcmLogSystem('Error while extracting update package from ' . $from);
        $this->returnData['code'] = false;
        $this->returnData['errorMsg'] = $this->lang->translate('PACKAGES_FAILED_GENERAL');
        return false;
    }

    private function processCheckFs()
    {
        $this->res = $this->pkg->checkFiles();
        if ($this->res === true) {
            fpcmLogSystem('All local files are writable ' . $this->pkg->getRemoteFile());
            $this->returnData['code'] = true;
            return true;
        }

        fpcmLogSystem('A few files in local file system where not writable ' . $this->pkg->getRemoteFile());
        fpcmLogSystem(implode(PHP_EOL, $this->pkg->getCopyErrorPaths()));
        $this->returnData['code'] = false;
        $this->returnData['errorMsg'] = $this->lang->translate('PACKAGES_FAILED_GENERAL');
        return false;
    }

    private function processUpdateFs()
    {
        $this->res = $this->pkg->copy();

        $dest = \fpcm\model\files\ops::removeBaseDir(\fpcm\classes\baseconfig::$baseDir);
        $from = \fpcm\model\files\ops::removeBaseDir($this->pkg->getExtractPath());

        if ($this->res === true) {
            fpcmLogSystem('Moved update package content successfully from ' . $from . ' to ' . $dest);
            $this->returnData['code'] = true;
            return true;
        }

        $this->returnData['code'] = false;
        $this->returnData['errorMsg'] = $this->lang->translate('PACKAGES_FAILED_GENERAL');
        return false;
    }

}

?>