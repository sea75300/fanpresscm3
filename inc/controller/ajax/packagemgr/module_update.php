<?php
    /**
     * AJAX module manager actions controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\packagemgr;
    
    /**
     * AJAX-Controller Paketmanager - installierte Module aktualisieren
     * 
     * @package fpcm.controller.ajax.packagemgr.module_update
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */  
    class module_update extends \fpcm\controller\abstracts\ajaxController {

        /**
         * Auszuführender Schritt
         * @var int
         */
        protected $step;
        
        /**
         * Modul-Key
         * @var string
         */
        protected $key;
        
        /**
         * Modul-Index
         * @var int
         */
        protected $midx;

        /**
         * allow_url_fopen = 1
         * @var bool
         */
        protected $canConnect;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();

            $this->checkPermission  = array('system' => 'options', 'modules' => 'configure', 'modules' => 'install');
            $this->canConnect       = \fpcm\classes\baseconfig::canConnect();
            
        }
        
        /**
         * Request-Handler
         * @return boolean
         */        
        public function request() {
            
            $this->step = (int) $this->getRequestVar('step');
            $this->key  = $this->getRequestVar('key');
            $this->midx = $this->getRequestVar('midx');            
            
            return true;
        }
        
        /**
         * Controller-Processing
         */
        public function process() {

            if (!parent::process()) return false;
            
            if ($this->canConnect) {
                $keyData = \fpcm\model\packages\package::explodeModuleFileName($this->key);
                $pkg = new \fpcm\model\packages\module('module', $keyData[0], $keyData[1]);
            }            
            
            if (!isset($keyData[0]) || !isset($keyData[1])) {
                die($this->step.'_0');
            }
            
            switch ($this->step) {
                case 1 :
                    $res = $pkg->download();
                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Downloaded module package successfully! '.$pkg->getRemoteFile());
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while downloading module package!'.$pkg->getRemoteFile());
                    }
                    break;
                case 2 :
                    $res = $pkg->extract();
                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Extracted module package successfully! '.$pkg->getLocalFile());
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while extracting module package! '.$pkg->getLocalFile());
                    }
                    break;
                case 3 :
                    $res = $pkg->copy();
                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Moved module package content successfully! '.$pkg->getExtractPath());
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while moving module package content! '.$pkg->getExtractPath());
                    }
                    break;
                case 4 :
                    $moduleClass = \fpcm\model\abstracts\module::getModuleClassName($keyData[0]);  
                    $res = class_exists($moduleClass);
                    
                    $moduleClassPath = \fpcm\classes\baseconfig::$moduleDir.$keyData[0].'/'.str_replace(array('\\', '/'), '', $keyData[0]).'.php';
                    if (!file_exists($moduleClassPath)) {
                        $res = false;
                        trigger_error('Module class '.$moduleClass.' not found in "'.$moduleClassPath.'"!');
                        break;
                    }

                    if ($res) {
                        $modObj = new $moduleClass($keyData[0], '', $keyData[1]);
                        if (!is_a($modObj, '\fpcm\model\abstracts\module'))  {
                            $res = false;
                            trigger_error('Module class '.$moduleClass.' must be an instance of "\fpcm\model\abstracts\module"!');
                            break;
                        }                        
                        
                        $res = $modObj->runUpdate();
                    }
                    
                    $moduleItem = new \fpcm\model\modules\listitem($keyData[0], '-', '', $keyData[1]);
                    $moduleItem->update();

                    if ($res === true) {
                        \fpcm\classes\logs::syslogWrite('Run final final module install steps successfully! '.$pkg->getKey());
                    } else {
                        \fpcm\classes\logs::syslogWrite('Error while running final module install steps! '.$pkg->getKey());
                    }
                    break;
                case 5 :
                    if ($this->canConnect) {
                        $pkg->loadPackageFileListFromTemp();
                        $files = $pkg->getFiles();
                        $pkg->cleanup();
                        $this->cache->cleanup();
                        \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                        die('<ul class="fpcm-updater-list-files-'.$this->midx.' fpcm-hidden"><li>'.implode('</li><li>', $files).'</li></ul>');
                    }
                    
                    \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                    $this->cache->cleanup();
                    die();
                    
                    break;                
                default:
                    $res = false;
                    break;
            }
            
            die($this->step.'_'.(int) $res);
            
        }

    }
?>
