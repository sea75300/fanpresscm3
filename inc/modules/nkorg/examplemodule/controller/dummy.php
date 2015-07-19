<?php
namespace fpcm\modules\nkorg\examplemodule\controller;
    
class dummy extends \fpcm\controller\abstracts\controller {

    /**
     *
     * @var \fpcm\model\view\acp
     */
    protected $view;

    public function __construct() {
        parent::__construct();
        $this->view    = new \fpcm\model\view\acp('dummy');
    }

    public function process() {
        parent::process();

        $this->view->addNoticeMessage('FPCM_EXAMPLEMODULE_HEADLINE');
        $this->view->assign('nofade', true);
        $this->view->render();
    }

}
?>