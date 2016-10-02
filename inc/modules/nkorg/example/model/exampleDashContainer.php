<?php
    /**
     * FanPress CM example dashboard container
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\modules\nkorg\example\model;

    class exampleDashContainer extends \fpcm\model\abstracts\dashcontainer {

        public function __construct() {

            parent::__construct();            

            $classname = get_class();
            
            $this->headline = $this->language->translate('FPCM_EXAMPLE_HEADLINE');
            $this->content  = 'This is an example dashboard conatiner from example module!';
            $this->name     = strtolower($classname);
            $this->position = 10;
        }
        
    }