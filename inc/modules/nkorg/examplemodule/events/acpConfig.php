<?php

namespace fpcm\modules\nkorg\examplemodule\events;

class acpConfig extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        
        $view = new \fpcm\model\view\acp('dummy');
        $view->addMessage('FPCM_EXAMPLEMODULE_HEADLINE');
        $view->addNoticeMessage('FPCM_EXAMPLEMODULE_HEADLINE');
        $view->addErrorMessage('FPCM_EXAMPLEMODULE_HEADLINE');
        $view->assign('nofade', true);
        $view->render();
        
    }

}
