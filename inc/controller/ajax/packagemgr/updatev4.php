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
     * @var \fpcm\model\packages\update
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
        
        $this->returnData['func'] = $method;
        if (!method_exists($this, $method)) {
            return false;
        }

        call_user_func([$this, $method]);
        sleep(3);
        $this->getSimpleResponse();
    }

    private function processDownload()
    {
        $this->returnData['code'] = true;
        $this->returnData['errorMsg'] = __METHOD__;
        return true;

        $this->res = $this->pkg->download();

        if ($this->res === \fpcm\model\packages\package::FPCMPACKAGE_REMOTEFILE_ERROR) {
            $this->versionDataFile->delete();
        }

        if ($this->res === true) {
            $this->syslog('Downloaded update package successfully from ' . $this->pkg->getRemoteFile());
            $this->returnData['nextstep'] = \fpcm\model\packages\package::FPCMPACKAGE_STEP_EXTRACT;
            return true;
        }

        $this->syslog('Error while downloading update package from ' . $this->pkg->getRemoteFile());
        $this->returnData['nextstep'] = \fpcm\model\packages\package::FPCMPACKAGE_STEP_CLEANUP;
    }

    private function processCheckFs()
    {
        $this->returnData['code'] = true;
        $this->returnData['errorMsg'] = __METHOD__;
        return true;

        $this->res = $this->pkg->checkFiles();

        if ($this->res === \fpcm\model\packages\package::FPCMPACKAGE_FILESCHECK_ERROR) {
            $this->versionDataFile->delete();
        }

        if ($this->res === true) {
            $this->syslog('All local files are writable ' . $this->pkg->getRemoteFile());
            $this->returnData['nextstep'] = \fpcm\model\packages\package::FPCMPACKAGE_STEP_COPY;
            return true;
        }

        $this->syslog('A few files in local file system where not writable ' . $this->pkg->getRemoteFile());
        $this->syslog(implode(PHP_EOL, $this->pkg->getCopyErrorPaths()));
        $this->returnData['nextstep'] = \fpcm\model\packages\package::FPCMPACKAGE_STEP_CLEANUP;
    }

    private function processExtract()
    {
        $this->returnData['code'] = true;
        $this->returnData['errorMsg'] = __METHOD__;
        return true;

        $this->res = $this->pkg->extract();
        $from = \fpcm\model\files\ops::removeBaseDir($this->pkg->getLocalFile());

        if ($this->res === true) {
            $this->syslog('Extracted update package successfully from ' . $from);
            $this->returnData['nextstep'] = \fpcm\model\packages\package::FPCMPACKAGE_STEP_CHECKFILES;
            return true;
        }

        $this->syslog('Error while extracting update package from ' . $from);
        $this->returnData['nextstep'] = \fpcm\model\packages\package::FPCMPACKAGE_STEP_CLEANUP;
    }

    private function processUpdateFs()
    {
        $this->returnData['code'] = true;
        $this->returnData['errorMsg'] = __METHOD__;
        return true;

        $this->res = $this->pkg->copy();

        $dest = \fpcm\model\files\ops::removeBaseDir(\fpcm\classes\baseconfig::$baseDir);
        $from = \fpcm\model\files\ops::removeBaseDir($this->pkg->getExtractPath());

        if ($this->res === true) {
            $this->syslog('Moved update package content successfully from ' . $from . ' to ' . $dest);
            $this->returnData['nextstep'] = \fpcm\model\packages\package::FPCMPACKAGE_STEP_UPGRADEDB;
            return true;
        }

        $this->syslog('Error while moving update package content from ' . $from . ' to ' . $dest);
        $this->syslog(implode(PHP_EOL, $this->pkg->getCopyErrorPaths()));
        $this->returnData['nextstep'] = \fpcm\model\packages\package::FPCMPACKAGE_STEP_CLEANUP;
    }

}

?>