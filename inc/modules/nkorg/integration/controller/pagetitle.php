<?php
    namespace fpcm\modules\nkorg\integration\controller;
    
    class pagetitle extends \fpcm\controller\abstracts\ajaxController {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();
            
            $spacerText = $this->getRequestVar('spacertext', array(1,4,7));
            die("<?php \$api->showPageNumber('$spacerText'); ?>");
            
        }

    }
?>