<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class articlesimport extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $id = (int) $this->getRequestVar('id');
            $db = $this->initDatabase();
            if (!$db) die('0');
            
            $tmp1 = new \fpcm\model\files\tempfile(\fpcm\modules\nkorg\classicimporter\nkorgclassicimporter::mappingUser);
            $usermapping = $tmp1->getContent();
            $usermapping = json_decode($tmp1->getContent(), true);
            
            $tmp2 = new \fpcm\model\files\tempfile(\fpcm\modules\nkorg\classicimporter\nkorgclassicimporter::mappingCategories);
            $categorymapping = $tmp2->getContent();
            $categorymapping = json_decode($tmp2->getContent(), true);                  
            
            if (($tmp2->getFilesize() > 0 && !is_array($categorymapping)) || ($tmp1->getFilesize() > 0 && !is_array($usermapping))) {
                trigger_error('Unable to parse user or category mapping files');
                die('0');
            }
            
            $newspost = $db->fetch($db->select('newsposts', '*', "id = {$id}"));

            $article = new \fpcm\model\articles\article();
            
            $content = html_entity_decode(htmlspecialchars_decode(utf8_encode($newspost->content)));
            
            $search  = array('/data/upload/', '/thumb_');
            $replace = array('/data/uploads/', '/thumbs/');
            $titel = html_entity_decode(htmlspecialchars_decode(utf8_encode($newspost->titel)));
            
            $article->setContent(str_replace($search, $replace, $content));
            $article->setTitle($titel);
            $article->setCreatetime($newspost->writtentime);
            $article->setChangetime( ($newspost->editedtime ? $newspost->editedtime : $newspost->writtentime) );
            $article->setComments($newspost->comments_active);
            $article->setDeleted($newspost->is_deleted);
            $article->setDraft($newspost->ispreview);
            $article->setArchived($newspost->is_archived);
            $article->setPinned($newspost->is_pinned);
            if ($newspost->writtentime > time()) {
                $article->setPostponed(true);
            }

            $article->setCategories(array(1));
            $newcategories = array();

            $oldcategories = explode(';', $newspost->category);
            if (is_array($categorymapping)) {
                if (count($oldcategories)) {
                    foreach ($oldcategories as $categorie) {
                        if (!isset($categorymapping[$categorie])) continue;
                        $newcategories[] = (int) $categorymapping[$categorie];
                    }


                }   
            } else {                
                $categoryList = new \fpcm\model\categories\categoryList();
                $categories = $categoryList->getCategoriesAll();

                foreach ($oldcategories as $categorie) {
                    if (!isset($categories[$categorie])) continue;
                    $newcategories[] = $categories[$categorie]->getId();
                }
            }
            
            if (count($newcategories)) {
                $article->setCategories($newcategories);
            }
            
            if (is_array($usermapping) && isset($usermapping[$newspost->author])) {
                $article->setCreateuser($usermapping[$newspost->author]);
                $article->setChangeuser($usermapping[$newspost->author]);
            } else {
                $article->setCreateuser($newspost->author);
                $article->setChangeuser($newspost->author);
            }
            
            $article->prepareDataSave(true);
            $newid = $article->save();
            
            if (!$newid) {
                trigger_error('Unable to import article with ID '.$id.'! Skipping comments...');
                usleep(1500);
                die('0');
            }            
            
            $id = ($newid != $id ? $newid : $id);
            $comments = $db->fetch($db->select('comments', '*', "newsid = {$id}"), true);
            
            if (!count($comments)) {
                usleep(1500);
                die('1');
            }
            
            foreach ($comments as $comment) {
                $newcomment = new \fpcm\model\comments\comment();
                $newcomment->setName(utf8_encode(htmlspecialchars_decode($comment->author_name)));
                $newcomment->setEmail(utf8_encode(htmlspecialchars_decode($comment->author_email)));
                $newcomment->setWebsite(utf8_encode(htmlspecialchars_decode($comment->author_url)));
                $newcomment->setText(htmlspecialchars_decode(utf8_encode($comment->comment_text)));
                $newcomment->setCreatetime($comment->comment_time);
                $newcomment->setIpaddress($comment->ip);
                $newcomment->setChangeuser($this->session->getUserId());
                $newcomment->setChangetime(time());
                
                if ($comment->status == 2) {
                    $newcomment->setApproved(0);
                } elseif ($comment->status == 1) {
                    $newcomment->setPrivate(1);
                } else {
                    $newcomment->setApproved(1);
                }
                
                $newcomment->setArticleid($id);

                $newcomment->save();
            }
            
            sleep(1);
            die('1');
            
        }

    }
?>