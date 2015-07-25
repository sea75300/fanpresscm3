<?php
    /**
     * Tweet Extender, http://nobody-knows.org/
     *
     * nkorg/tweetextender event class: acpConfig
     * 
     * @version 3.0.0
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\tweetextender\events;

    class acpConfig extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            $view = new \fpcm\model\view\module(\fpcm\model\abstracts\module::getModuleKeyByFolder(__DIR__) , 'acp', 'main');
            $termlist = new \fpcm\modules\nkorg\tweetextender\model\termlist();
            
            if (!is_null(\fpcm\classes\http::get('added'))) {
                $view->addNoticeMessage('NKORG_TWEETENTENDER_SAVED_OK');
            }
            
            if (!is_null(\fpcm\classes\http::get('btnDeleteTerms')) && !is_null(\fpcm\classes\http::get('ids'))) {                
                $ids = \fpcm\classes\http::get('ids');
                if ($termlist->deleteTerms($ids)) {
                    $view->addNoticeMessage('NKORG_TWEETENTENDER_DELETE_OK');
                } else {
                    $view->addErrorMessage('NKORG_TWEETENTENDER_DELETE_FAILED');
                }
            }  
            
            
            $terms = $termlist->getTerms();            
            $view->assign('terms', $terms);
            
            $view->render();
            
        }

    }