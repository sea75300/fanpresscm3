<?php
    /**
     * Language Editor, http://nobody-knows.org
     *
     * nkorg/langeditor event class: acpConfig
     * 
     * @version 1.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\langeditor\events;

    class acpConfig extends \fpcm\model\abstracts\moduleEvent {

        private $dataPath = '';
        
        public function run($params = null) {
            
            $this->dataPath = \fpcm\classes\baseconfig::$dataDir.'langeditback/';
            
            $view = new \fpcm\model\view\module(\fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__), 'acp', 'main');
            
            $systemFiles = glob(\fpcm\classes\baseconfig::$langDir.'*/*.php');
            $moduleFiles = glob(\fpcm\classes\baseconfig::$moduleDir.'*/*/lang/*/*.php');
            if (!is_array($systemFiles) || !is_array($moduleFiles)) {
                $view->addErrorMessage('NKORG_LANGEDITOR_LOADERROR');
                $view->render();
                return true;
            }

            $langfiles    = array_merge($systemFiles, $moduleFiles);
            $selectedFile = '';
            $lines        = array();

            if (!is_null(\fpcm\classes\http::postOnly('btnLangfileSelect')) && \fpcm\classes\http::postOnly('langfile')) {
                $selectedFile = base64_decode(\fpcm\classes\http::postOnly('langfile'));
                if (!in_array($selectedFile, $langfiles) || !file_exists($selectedFile)) {
                    $view->addErrorMessage('NKORG_LANGEDITOR_SELECTERROR');
                    $selectedFile = '';
                } else {
                    require $selectedFile;
                    
                    if (!isset($lang)) {
                        $view->addErrorMessage('NKORG_LANGEDITOR_FILEERROR');
                    } else {
                        $lines = $lang;                        
                    }
                }
            }

            if (!is_null(\fpcm\classes\http::postOnly('btnEditLangfile')) && \fpcm\classes\http::postOnly('langitems') && \fpcm\classes\http::postOnly('langfile')) {
                $selectedFile = base64_decode(\fpcm\classes\http::postOnly('langfile'));
                
                if (!is_writable(\fpcm\classes\baseconfig::$langDir)) {
                    $view->addErrorMessage('NKORG_LANGEDITOR_NOTWRITABLE', array('{{syslangapth}}' => \fpcm\model\files\ops::removeBaseDir(\fpcm\classes\baseconfig::$langDir)));
                } else {
                    $langItems    = \fpcm\classes\http::postOnly('langitems', array(4,7));
                    $deletedItems = \fpcm\classes\http::postOnly('deleteitems');
                    if (!is_array($deletedItems)) {
                        $deletedItems = array();
                    }

                    $fileLines = array();
                    foreach ($langItems as $item) {
                        $name  = $item['name'];
                        $value = $item['value'];

                        $hash = md5($name.$value);
                        if (!$name || !$value || in_array($hash, $deletedItems)) {
                            continue;
                        }

                        $fileLines[strtoupper($name)] = str_replace('\n', PHP_EOL, $value);
                    }

                    $lines = $fileLines;

                    $selectedFileBack = str_replace(DIRECTORY_SEPARATOR, '_', ltrim(\fpcm\model\files\ops::removeBaseDir($selectedFile), DIRECTORY_SEPARATOR));
                    $dest = $this->dataPath.$selectedFileBack.'.'.date('YmdHis');
                    if (!copy($selectedFile, $dest)) {
                        $dest = \fpcm\model\files\ops::removeBaseDir($dest, true);
                        $view->addErrorMessage('NKORG_LANGEDITOR_BACKUPERROR', array('{{path}}' => $dest));
                        trigger_error('Unable to create backup of '.\fpcm\model\files\ops::removeBaseDir($selectedFile).' in '.\fpcm\model\files\ops::removeBaseDir($this->dataPath, true));
                    } else {
                        $fileContent  = file_get_contents($selectedFile);               
                        $langVarPos   = strpos($fileContent, '$lang');

                        $fileContent  = trim(substr($fileContent, 0, $langVarPos));
                        $fileContent .= PHP_EOL.PHP_EOL.'$lang = '.var_export($fileLines, true).';'.PHP_EOL.'?>';

                        if (!file_put_contents($selectedFile, $fileContent)) {
                            trigger_error('Unable to save changes to language file '.$selectedFile);
                            $view->addErrorMessage('NKORG_LANGEDITOR_SAVEERROR');
                        } else {
                            $view->addNoticeMessage('NKORG_LANGEDITOR_SAVEOK');
                        }

                        $cache = new \fpcm\classes\cache();
                        $cache->cleanup();                    
                    }
                
                }
            }
 
            $files = array($this->lang->translate('NKORG_LANGEDITOR_FILE') => '');
            $excludeArray = array('help.php', 'tz.php');
            foreach ($langfiles as $langfile){
                $basename = basename($langfile);
                if (in_array($basename, $excludeArray)) {
                    continue;
                }
                $files[\fpcm\model\files\ops::removeBaseDir($langfile)] = base64_encode($langfile);
            }
            
            $view->assign('lines', $lines);
            $view->assign('langfiles', $files);
            $view->assign('selectedFile', $selectedFile);
            $view->render();
            
        }

    }