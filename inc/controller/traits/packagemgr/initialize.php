<?php
    /**
     * Package manager controller trait
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\traits\packagemgr;
    
    /**
     * Trait für Initialisierung von Paket Manager
     * 
     * @package fpcm.controller.traits.packagemgr.initialize
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    trait initialize {

        /**
         * Gibt gemeinsame initiale Daten für Paketmanager zurück,
         * beeinhaltet Benachrichtigungen, Statusinfos, etc.
         * @return array
         */
        public function initPkgManagerData() {
            
            return array(
                'fpcmCronAsyncDiabled'   => true,
                'fpcmUpdaterProcessTime' => $this->lang->translate('PACKAGES_PROCESS_TIME'),
                'fpcmUpdaterMaxStep'     => $this->forceStep ? $this->forceStep : 5,
                'fpcmUpdaterProgressbar' => (int) \fpcm\classes\baseconfig::canConnect(),
                'fpcmUpdaterMessages'    => array(
                    '1_START' => $this->lang->translate('PACKAGES_RUN_DOWNLOAD'),
                    '2_START' => $this->lang->translate('PACKAGES_RUN_EXTRACT'),
                    '3_START' => $this->lang->translate('PACKAGES_RUN_COPY'),
                    '4_START' => $this->lang->translate('PACKAGES_RUN_ADDITIONAL'),
                    '5_START' => $this->lang->translate('PACKAGES_FILE_LIST'),
                    'EXIT_1'  => $this->lang->translate('UPDATES_SUCCESS'),
                    
                    '1_1' => $this->lang->translate('PACKAGES_SUCCESS_DOWNLOAD'),
                    '1_0' => $this->lang->translate('PACKAGES_FAILED_GENERAL'),
                    '2_1' => $this->lang->translate('PACKAGES_SUCCESS_EXTRACT'),
                    '2_0' => $this->lang->translate('PACKAGES_FAILED_GENERAL'),
                    '3_1' => $this->lang->translate('PACKAGES_SUCCESS_COPY'),
                    '3_0' => $this->lang->translate('PACKAGES_FAILED_GENERAL'),
                    '4_1' => $this->lang->translate('PACKAGES_SUCCESS_ADDITIONAL'),
                    '4_0' => $this->lang->translate('UPDATES_FAILED'),
                    '5_1' => $this->lang->translate('PACKAGES_SUCCESS_LOGDONE'),
                    '6_1' => $this->lang->translate('PACKAGES_UPDATE_NEW_VERSION'),
                    
                    '1_'.\fpcm\model\packages\package::FPCMPACKAGE_REMOTEFILE_ERROR  => $this->lang->translate('PACKAGES_FAILED_REMOTEFILE'),
                    '1_'.\fpcm\model\packages\package::FPCMPACKAGE_LOCALFILE_ERROR   => $this->lang->translate('PACKAGES_FAILED_LOCALFILE'),
                    '1_'.\fpcm\model\packages\package::FPCMPACKAGE_LOCALWRITE_ERROR  => $this->lang->translate('PACKAGES_FAILED_LOCALWRITE'),
                    '1_'.\fpcm\model\packages\package::FPCMPACKAGE_LOCALEXISTS_ERROR => $this->lang->translate('PACKAGES_FAILED_LOCALEXISTS'),
                    '1_'.\fpcm\model\packages\package::FPCMPACKAGE_HASHCHECK_ERROR   => $this->lang->translate('PACKAGES_FAILED_HASHCHECK'),                    
                    '2_'.\fpcm\model\packages\package::FPCMPACKAGE_ZIPOPEN_ERROR     => $this->lang->translate('PACKAGES_FAILED_ZIPOPEN'),
                    '2_'.\fpcm\model\packages\package::FPCMPACKAGE_ZIPEXTRACT_ERROR  => $this->lang->translate('PACKAGES_FAILED_ZIPEXTRACT'),
                    '3_'.\fpcm\model\packages\package::FPCMPACKAGE_FILESCOPY_ERROR   => $this->lang->translate('PACKAGES_FAILED_FILESCOPY')
                )
            );
        }
    
    }