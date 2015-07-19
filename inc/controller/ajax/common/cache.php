<?php
    /**
     * AJAX cache controller
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\common;
    
    /**
     * AJAX controller zum Cache leeren 
     * 
     * @package fpcm.controller.ajax.common.cache
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */    
    class cache extends \fpcm\controller\abstracts\ajaxController {
        
        /**
         * Request-Handler
         * @return bool
         */
        public function request() {
            return $this->session->exists();
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;
            
            $this->cache->cleanup();

            $this->events->runEvent('clearCache');

            $this->lang->write('CACHE_CLEARED_OK');
        }

    }
?>