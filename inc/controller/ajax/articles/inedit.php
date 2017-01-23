<?php

    namespace fpcm\controller\ajax\articles;
    
    /**
     * Setzt Inhalt auf in Bearbeitung
     * 
     * @package fpcm\controller\ajax\articles\inedit
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.5
     */
    class inedit extends \fpcm\controller\abstracts\ajaxController {

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

            $article = new \fpcm\model\articles\article($this->getRequestVar('id', [9]));

            $this->returnCode = 0;
            if (!$article->exists()) {
                $this->getResponse();
            }
            
            if ($article->isInEdit()) {
                $this->returnCode = 1;
                $this->getResponse();
            }
            
            $article->setInEdit();
            $this->getResponse();

        }
    }
?>