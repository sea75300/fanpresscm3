<?php
    /**
     * Comment list trait
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\traits\comments;
    
    /**
     * Artikelliste trait
     * 
     * @package fpcm.controller.traits.articles.lists
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */    
    trait lists {

        protected $actions = array(
            'COMMENTLIST_ACTION_SPAM'    => 1,
            'COMMENTLIST_ACTION_APPROVE' => 2,
            'COMMENTLIST_ACTION_PRIVATE' => 3,
            'COMMENTLIST_ACTION_DELETE'  => 4,
        );

        /**
         * Initialisiert Berechtigungen
         */
        protected function initCommentPermissions() {
            if (!$this->permissions) return false;
            
            $commentActions = [];
            if ($this->permissions->check(array('comment' => 'approve'))) {
                $commentActions[$this->lang->translate('COMMMENT_SPAM_BTN')]    = $this->actions['COMMENTLIST_ACTION_SPAM'];
                $commentActions[$this->lang->translate('COMMMENT_APPROVE_BTN')] = $this->actions['COMMENTLIST_ACTION_APPROVE'];
            }
            
            if ($this->permissions->check(array('comment' => 'private'))) {
                $commentActions[$this->lang->translate('COMMMENT_PRIVATE_BTN')] = $this->actions['COMMENTLIST_ACTION_PRIVATE'];
            }
            
            if ($this->permissions->check(array('comment' => 'delete'))) {
                $commentActions[$this->lang->translate('GLOBAL_DELETE')] = $this->actions['COMMENTLIST_ACTION_DELETE'];
            }
            
            $this->view->assign('commentActions', $commentActions);
        }
        
        protected function processCommentActions(\fpcm\model\comments\commentList $commentList) {

            $action = $this->getRequestVar('commentAction', array(9));
            $ids    = $this->getRequestVar('ids', array(9));
            if (!$action || !is_array($ids) || !count($ids)) {
                $this->view->addErrorMessage('SELECT_ITEMS_MSG');
                return true;
            }
            
            switch ($action) {
                case $this->actions['COMMENTLIST_ACTION_DELETE']:
                    if ($commentList->deleteComments($ids)) {
                        $this->view->addNoticeMessage('DELETE_SUCCESS_COMMENTS');
                    } else {
                        $this->view->addErrorMessage('DELETE_FAILED_COMMENTS');
                    }
                break;
                case $this->actions['COMMENTLIST_ACTION_APPROVE']:
                    if ($commentList->toggleApprovement($ids)) {
                        $this->view->addNoticeMessage('SAVE_SUCCESS_APPROVEMENT');
                    } else {
                        $this->view->addErrorMessage('SAVE_FAILED_APPROVEMENT');
                    }
                break;
                case $this->actions['COMMENTLIST_ACTION_PRIVATE']:
                    if ($commentList->togglePrivate($ids)) {
                        $this->view->addNoticeMessage('SAVE_SUCCESS_PRIVATE');
                    } else {
                        $this->view->addErrorMessage('SAVE_FAILED_PRIVATE');
                    }
                break;
                case $this->actions['COMMENTLIST_ACTION_SPAM']:
                    if ($commentList->toggleSpammer($ids)) {
                        $this->view->addNoticeMessage('SAVE_SUCCESS_SPAMMER');
                    } else {
                        $this->view->addErrorMessage('SAVE_FAILED_SPAMMER');
                    }
                break;

            }
            
            return true;

        }
    
    }