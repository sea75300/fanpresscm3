<?php
    /**
     * Article lists trait
     * 
     * Article lists trait
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\traits\articles;
    
    /**
     * Artikelliste trait
     * 
     * @package fpcm.controller.traits.articles.lists
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */    
    trait lists {

        /**
         * Berechtigungen zum Bearbeiten initialisieren
         */
        public function initEditPermisions() {
            $this->view->assign('permAdd', $this->permissions->check(array('article' => 'add')));
            $this->view->assign('permEditOwn', $this->permissions->check(array('article' => 'edit')));
            $this->view->assign('permEditAll', $this->permissions->check(array('article' => 'editall')));
            $this->view->assign('currentUserId', $this->session->getUserId());
            $this->view->assign('isAdmin', $this->session->getCurrentUser()->isAdmin());               
        }
        
        /**
         * Kategorien übersetzten
         * @return void
         */
        protected function translateCategories() {
            
            if (!count($this->articleItems) || !$this->session->exists()) {
                return false;
            }

            $categories = $this->categoryList->getCategoriesAll();
            foreach ($this->articleItems as $articles) {
                foreach ($articles as &$article) {
                    $res = array();
                    foreach ($article->getCategories() as $categoryId) {                    
                        if (!isset($categories[$categoryId])) continue;                    
                        $res[] = $categories[$categoryId]->getName();
                    }
                    $article->setCategories($res);                    
                }
            }
        }        
    
    }