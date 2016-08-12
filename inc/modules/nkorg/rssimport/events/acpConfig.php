<?php
    /**
     * RSS Importer, https://nobody-knows.org
     *
     * nkorg/rssimport event class: acpConfig
     * 
     * @version 0.0.1
     * @author imagine <imagine@yourdomain.xyz>
     * @copyright (c) 2016, imagine
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\rssimport\events;

    class acpConfig extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $view = new \fpcm\model\view\module('nkorg/rssimport', 'acp', 'main', '');

            $userlist = new \fpcm\model\users\userList();
            $users    = $userlist->getUsersNameList();
            $seluser  = array_values(array_slice($users, 0, 1));
            
            $view->assign('userids', $users);
            $view->assign('selectedUser', $seluser[0]);

            $categorylist = new \fpcm\model\categories\categoryList();
            $categories   = $categorylist->getCategoriesNameListCurrent();
            $selcategory  = array_values(array_slice($categories, 0, 1));
            
            $view->assign('categoryids', $categories);
            $view->assign('selectedCategory', $selcategory[0]);

            $view->render();

        }

    }