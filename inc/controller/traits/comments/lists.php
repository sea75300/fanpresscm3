<?php
    /**
     * Comment list trait
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2017, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\traits\comments;
    
    /**
     * Kommentar-Liste trait
     * 
     * @package fpcm.controller.traits.articles.lists
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */    
    trait lists {

        protected $actions = array(
            'COMMENTLIST_ACTION_MASSEDIT' => 1,
            'COMMENTLIST_ACTION_DELETE'   => 2
        );

        /**
         * Initialisiert Berechtigungen
         */
        protected function initCommentPermissions() {

            if (!$this->permissions) return false;
            
            $commentActions = [];

            $canEdit    = $this->permissions->check(['comment' => ['editall', 'edit']]);
            $canApprove = $this->permissions->check(['comment' => 'approve']);
            $canPrivate = $this->permissions->check(['comment' => 'private']);

            $this->view->assign('canEditComments', $canEdit);
            $this->view->assign('canApprove', $canApprove);
            $this->view->assign('canPrivate', $canPrivate);
            $this->view->assign('canMove', $this->permissions->check(['comment' => 'move']));
            
            if ($canEdit && ($canApprove || $canPrivate)) {                
                $commentActions[$this->lang->translate('GLOBAL_EDIT_SELECTED')]   = $this->actions['COMMENTLIST_ACTION_MASSEDIT'];
            }
            
            if ($this->permissions->check(['comment' => 'delete'])) {
                $commentActions[$this->lang->translate('GLOBAL_DELETE')] = $this->actions['COMMENTLIST_ACTION_DELETE'];
            }
            
            $this->view->assign('commentActions', $commentActions);
        }

        /**
         * Kommentar-Aktionen ausführen
         * @param \fpcm\model\comments\commentList $commentList
         * @return boolean
         */
        protected function processCommentActions(\fpcm\model\comments\commentList $commentList) {

            $action = $this->getRequestVar('commentAction', [\fpcm\classes\http::FPCM_REQFILTER_CASTINT]);
            $ids    = $this->getRequestVar('ids', [\fpcm\classes\http::FPCM_REQFILTER_CASTINT]);
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
            }
            
            return true;

        }
        
        /**
         * Initialisiert Suchformular-Daten
         * @param array $users
         */
        protected function initCommentMassEditForm($ajax = false) {

            $this->view->assign('massEditPrivate', [
                $this->lang->translate('GLOBAL_NOCHANGE_APPLY') => -1,
                $this->lang->translate('GLOBAL_YES')            => 1,
                $this->lang->translate('GLOBAL_NO')             => 0
            ]);

            $this->view->assign('massEditSpam', [
                $this->lang->translate('GLOBAL_NOCHANGE_APPLY') => -1,
                $this->lang->translate('GLOBAL_YES')            => 1,
                $this->lang->translate('GLOBAL_NO')             => 0
            ]);

            $this->view->assign('massEditApproved', [
                $this->lang->translate('GLOBAL_NOCHANGE_APPLY') => -1,
                $this->lang->translate('GLOBAL_YES')            => 1,
                $this->lang->translate('GLOBAL_NO')             => 0
            ]);

            if ($ajax) {
                return true;
            }

            $this->view->addJsLangVars([
                'masseditHeadline'   => $this->lang->translate('GLOBAL_EDIT_SELECTED'),
                'masseditSave'       => $this->lang->translate('GLOBAL_SAVE'),
                'masseditSaveFailed' => $this->lang->translate('SAVE_FAILED_ARTICLES')
            ]);
            
            $this->view->addJsVars([
                'masseditPageToken'  => \fpcm\classes\security::createPageToken('cooments/massedit')
            ]);

        }
    
    }