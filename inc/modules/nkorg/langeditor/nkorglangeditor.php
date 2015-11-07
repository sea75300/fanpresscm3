<?php
    /**
     * Language Editor, http://nobody-knows.org
     *
     * nkorg/langeditor class: nkorglangeditor
     * 
     * @version 1.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\langeditor;

    class nkorglangeditor extends \fpcm\model\abstracts\module {

        private $dataPath = '';

        public function __construct($key, $name, $version, $versionRemote = '-', $description = '-', $author = '-', $link = '', $systemMinVersion = '', $init = true) {
            
            $this->dataPath = \fpcm\classes\baseconfig::$dataDir.'/langeditback/';
            parent::__construct($key, $name, $version, $versionRemote, $description, $author, $link, $systemMinVersion, $init);

        }
        
        public function runInstall() {

            if (!is_dir($this->dataPath) && !mkdir($this->dataPath, 0777)) {
                trigger_error('Unable to create module datapath in '.\fpcm\model\files\ops::removeBaseDir($this->dataPath, true));
                return false;
            }
            
            if (!file_exists($this->dataPath) || !is_writable($this->dataPath)) {
                trigger_error('Module datapath '.\fpcm\model\files\ops::removeBaseDir($this->dataPath, true).' was not found or is not writable!');
                return false;
            }

            return true;
        }

        public function runUninstall() {
           
            if (!is_dir($this->dataPath)) {
                return true;
            }

            rmdir($this->dataPath);

            return true;
        }

        public function runUpdate() {
            return true;
        }
        
    }
