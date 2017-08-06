<?php

    namespace fpcm\controller\ajax\articles;
    
    /**
     * Massenbearbeitung von Artikeln
     * 
     * @package fpcm\controller\ajax\articles\search
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @since FPCM 3.6
     */
    class massedit extends \fpcm\controller\abstracts\ajaxController {
        
        use \fpcm\controller\traits\articles\lists;

        /**
         * Artikel-Liste
         * @var \fpcm\model\articles\articlelist
         */
        protected $articleList;

        /**
         * Artikel-IDs
         * @var array
         */
        protected $articleIds= [];

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {

            if (!$this->permissions->check([ 'article' => ['edit', 'editall', 'approve', 'archive'] ])) {
                return false;
            }

            $this->articleList = new \fpcm\model\articles\articlelist();
            $this->articleIds  = array_map('intval', json_decode($this->getRequestVar('ids', array(\fpcm\classes\http::FPCM_REQFILTER_STRIPTAGS,\fpcm\classes\http::FPCM_REQFILTER_STRIPSLASHES,\fpcm\classes\http::FPCM_REQFILTER_TRIM)), true));
            
            return true;
        }
        
        /**
         * Controller-Processing
         */
        public function process() {
            if (!parent::process()) return false;
            
        }

    }
?>