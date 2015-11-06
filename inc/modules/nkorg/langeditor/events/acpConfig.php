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

        public function run($params = null) {
            
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
                $langItems    = \fpcm\classes\http::postOnly('langitems', array(4,7));

                $fileLines = array();
                foreach ($langItems as $item) {
                    $name  = $item['name'];
                    $value = $item['value'];

                    if (!$name || !$value) {
                        continue;
                    }

                    $fileLines[strtoupper($name)] = str_replace('\n', PHP_EOL, $value);
                }
                
                $lines = $fileLines;
                
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