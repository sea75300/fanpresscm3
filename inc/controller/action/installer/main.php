<?php
    /**
     * System install controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\installer;
    
    define('FPCM_INSTALLER_NOCACHE', true);
    
    class main extends \fpcm\controller\abstracts\controller {
        
        use \fpcm\controller\traits\system\syscheck, 
            \fpcm\controller\traits\common\timezone;
        
        /**
         *
         * @var \fpcm\model\view\installer
         */
        protected $view;
        
        /**
         *
         * @var \fpcm\classes\language
         */
        protected $lang;

        /**
         *
         * @var string
         */
        protected $langCode           = 'de';
        
        /**
         *
         * @var int
         */
        protected $step               = 1;
        
        /**
         *
         * @var bool
         */
        protected $afterStepResult    = true;

        /**
         *
         * @var array
         */
        protected $subTemplates = array(
            1 => '01_selectlang',
            2 => '02_syscheck',
            3 => '03_dbdata',
            4 => '04_createtables',
            5 => '05_sysconfig',
            6 => '06_firstuser',
            7 => '07_finalize'
        );

        public function __construct() {
            return;
        }
        
        public function request() {
            
            if (!\fpcm\classes\baseconfig::installerEnabled()) {
                die('The FanPress CM installer is not enabled!');
                trigger_error('Access to disabled installer from ip address '.\fpcm\classes\http::getIp());
                return false;
            }
            
            $this->step     = !is_null($this->getRequestVar('step')) ? (int) $this->getRequestVar('step') : 1;
            $this->langCode = !is_null($this->getRequestVar('language')) ? $this->getRequestVar('language') : FPCM_DEFAULT_LANGUAGE_CODE;            
            $this->lang     = new \fpcm\classes\language($this->langCode);
            $this->view     = new \fpcm\model\view\installer('main', $this->langCode);

            return true;
        }
        
        public function process() {
            
            $maxStep = max(array_keys($this->subTemplates));
            
            if ($this->step > $maxStep) die('Undefined step!');
            
            $this->view->assign('subTemplate', $this->subTemplates[$this->step]);
            $this->view->assign('maxStep', $maxStep);
            $this->view->assign('currentStep', $this->step);
            $this->view->assign('step', $this->step + 1);
            $this->view->assign('showNextButton', true);
            $this->view->assign('showReload', false);
            $this->view->setViewJsFiles(array(\fpcm\classes\baseconfig::$jsPath.'installer.js'));
            $this->view->addJsVars(array(
                'fpcmInstallerDBTestFailed' => $this->lang->translate('INSTALLER_DBCONNECTION_FAILEDMSG')
            ));

            if (method_exists($this, 'runAfterStep'.($this->step - 1))) {
                call_user_func(array($this, 'runAfterStep'.($this->step - 1)));                
            }            
            
            if (method_exists($this, 'runStep'.$this->step)) {
                call_user_func(array($this, 'runStep'.$this->step));                
            }

            $this->view->render();
        }
        
        /**
         * Installer Step 2
         */
        protected function runStep2() {
            $sysCheckResults = $this->getCheckOptionsSystem();

            $isOk = true;
            foreach ($sysCheckResults as $key => $value) {                    
                if ($value['optional'] || $value['result']) continue;
                $isOk = false;
            }

            if (!$isOk) {
                $this->view->assign('showReload', true);
                $this->view->assign('showNextButton', false);
                $this->view->addErrorMessage('INSTALLER_SYSCHECK_FAILEDMSG');
                $this->view->assign('nofade', true);
            }

            $this->view->assign('checkOptions', $sysCheckResults);           
        }
        
        /**
         * Installer Step 2 after
         */
        protected function runAfterStep2() {
            
            $sqlDrivers = array();
            
            $availableDrivers = \PDO::getAvailableDrivers();
            
            if (in_array('mysql', $availableDrivers)) {
                $sqlDrivers['MySQL/MariaDB'] = 'mysql';
            }
            if (in_array('pgsql', $availableDrivers)) {
                $sqlDrivers['Postgres (experimental!)'] = 'pgsql';
            }                

            $this->view->assign('sqlDrivers', $sqlDrivers);
        }
        
        /**
         * Installer Step 4
         */
        protected function runStep4() {
            $sqlFiles = array();
            
            $dbconfig = \fpcm\classes\baseconfig::getDatabaseConfig();
            $dbtype   = $dbconfig['DBTYPE'];
            
            foreach (glob(\fpcm\classes\baseconfig::$dbStructPath.$dbtype.'/*.sql') as $value) {
                $sqlFiles[substr(basename($value, '.sql'), 2)] = base64_encode(str_rot13(base64_encode($value)));
            }
            
            $this->view->addJsVars(array(
                'fpcmSqlFiles'      => $sqlFiles,
                'fpcmSqlFileExec'   => $this->lang->translate('INSTALLER_CREATETABLES_STEP')
            ));
            
        }

        /**
         * Installer Step 5
         */
        protected function runStep5() {
            if (!is_null($this->getRequestVar('cserr'))) {
                $this->view->addErrorMessage('SAVE_FAILED_OPTIONS');
            }
            
            $timezones = array();
            
            foreach ($this->getTimeZones() as $area => $zones) {
                foreach ($zones as $zone) {
                    $timezones[$area][$zone] = $zone;
                }
            }
            
            $this->view->assign('timezoneAreas', $timezones);            
            
            $modes = array(
                $this->lang->translate('SYSTEM_OPTIONS_USEMODE_IFRAME') => 0,
                $this->lang->translate('SYSTEM_OPTIONS_USEMODE_PHPINCLUDE') => 1
            );
            $this->view->assign('systemModes', $modes);            
            
            $acpLenghts = array(
                $this->lang->translate('SYSTEM_OPTIONS_SESSIONLENGHT_1800')  => 1800,
                $this->lang->translate('SYSTEM_OPTIONS_SESSIONLENGHT_3600')  => 3600,
                $this->lang->translate('SYSTEM_OPTIONS_SESSIONLENGHT_5400')  => 5400,
                $this->lang->translate('SYSTEM_OPTIONS_SESSIONLENGHT_7200')  => 7200,
                $this->lang->translate('SYSTEM_OPTIONS_SESSIONLENGHT_9000')  => 9000,
                $this->lang->translate('SYSTEM_OPTIONS_SESSIONLENGHT_10800') => 10800,
                $this->lang->translate('SYSTEM_OPTIONS_SESSIONLENGHT_14400') => 14400,
                $this->lang->translate('SYSTEM_OPTIONS_SESSIONLENGHT_18000') => 18000              
            );
            $this->view->assign('acpLenghts', $acpLenghts);

            $cacheTimeout = array(
                $this->lang->translate('SYSTEM_OPTIONS_CACHETIMEOUT_3600')   => 3600,
                $this->lang->translate('SYSTEM_OPTIONS_CACHETIMEOUT_21600')  => 21600,
                $this->lang->translate('SYSTEM_OPTIONS_CACHETIMEOUT_43200')  => 43200,
                $this->lang->translate('SYSTEM_OPTIONS_CACHETIMEOUT_64800')  => 64800,
                $this->lang->translate('SYSTEM_OPTIONS_CACHETIMEOUT_86400')  => 86400,
                $this->lang->translate('SYSTEM_OPTIONS_CACHETIMEOUT_172800') => 172800,
                $this->lang->translate('SYSTEM_OPTIONS_CACHETIMEOUT_259200') => 259200,
                $this->lang->translate('SYSTEM_OPTIONS_CACHETIMEOUT_345600') => 345600,
                $this->lang->translate('SYSTEM_OPTIONS_CACHETIMEOUT_432000') => 432000
            );
            $this->view->assign('cacheTimeout', $cacheTimeout);
        }
        
        /**
         * Installer Step 5 after
         */
        protected function runAfterStep5() {
            $newconfig = $this->getRequestVar('conf');
            $newconfig['system_version'] = $this->view->getVersion();
            
            $config = new \fpcm\model\system\config(false, false);
            $config->setNewConfig($newconfig);
            
            if (!$config->update()) {
                $this->redirect('installer', array('step' => '5', 'cserr' => '1', 'language' => $this->langCode));
            }
            
            return true;
        }

        /**
         * Installer Step 6
         */
        protected function runStep6() {
            
            $user = new \fpcm\model\users\author();

            $this->view->assign('author', $user);
            $this->view->assign('userRolls', array($this->lang->translate('GLOBAL_ADMINISTRATOR') => 1));
            $this->view->assign('externalSave', true);
            
            if (!is_null($this->getRequestVar('msg'))) {                
                switch ($this->getRequestVar('msg')) {
                    case false :
                        $this->view->addErrorMessage('SAVE_FAILED_USER');
                        break;
                    case \fpcm\model\users\author::AUTHOR_ERROR_PASSWORDINSECURE :
                        $this->view->addErrorMessage('SAVE_FAILED_PASSWORD_SECURITY');
                        break;
                    case \fpcm\model\users\author::AUTHOR_ERROR_EXISTS :
                        $this->view->addErrorMessage('SAVE_FAILED_USER_EXISTS');
                        break;
                    case -4 :
                        $this->view->addErrorMessage('SAVE_FAILED_PASSWORD_MATCH');
                        break;
                    case -5 :
                        $this->view->addErrorMessage('SAVE_FAILED_USER_SECURITY');
                        break;
                    case -6 :
                        $this->view->addErrorMessage('SAVE_FAILED_USER');
                        break;
                }               
            }
        }
        
        /**
         * Installer Step 6 after
         */
        protected function runAfterStep6() {

            $username = $this->getRequestVar('username');
            
            foreach ($this->getRequestVar() as $key => $data) {
                if ($data == '' && !in_array($key, array('module', 'step', 'btnSubmitNext', 'language'))) {
                    $this->redirect('installer', array('step' => '6', 'msg' => -6, 'language' => $this->langCode));
                    $this->afterStepResult = false;
                    return false;
                }
            }
            
            if (in_array($username, array('admin', 'root', 'test', 'support', 'administrator', 'adm'))) {
                $this->redirect('installer', array('step' => '6', 'msg' => -5, 'language' => $this->langCode));
                $this->afterStepResult = false;
                return false;
            }
            
            $user = new \fpcm\model\users\author($username);            
            $user->setUserName($username);
            $user->setEmail($this->getRequestVar('email'));
            $user->setDisplayName($this->getRequestVar('displayname'));
            $user->setRoll(1);
            $user->setUserMeta(array());
            $user->setRegistertime(time());

            $newpass         = $this->getRequestVar('password');
            $newpass_confirm = $this->getRequestVar('password_confirm');

            if ($newpass && $newpass_confirm && (md5($newpass) == md5($newpass_confirm))) {
                $user->setPassword($newpass);
            } else {
                $res = -4;
                $this->afterStepResult = false;
            }

            if (!isset($res)) {
                $res = $user->save();
                if ($res === true) {
                    return true;
                }
            }
            
            $this->redirect('installer', array('step' => '6', 'msg' => $res, 'language' => $this->langCode));
            
            $this->afterStepResult = false;
            return false;
        }
        
        /**
         * Installer Step 7
         */
        protected function runStep7() {
            
            $res = true;
            
            if ($this->afterStepResult) {
                $res = \fpcm\classes\baseconfig::enableInstaller(false);
                $res = $res && \fpcm\model\files\ops::deleteRecursive(\fpcm\classes\baseconfig::$dbStructPath);
            }
            
            $this->view->assign('disableInstallerMsg', !$res);
            $this->view->assign('showNextButton', false);
        }

    }
?>