<?php
    /**
     * System stats Dashboard Container
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\dashboard;

    /**
     * System stats dashboard container object
     * 
     * @package fpcm.model.dashboard
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class sysstats extends \fpcm\model\abstracts\dashcontainer {
        
        /**
         * Container table content
         * @var array
         */
        protected $tableContent = array();

        /**
         * Konstruktor
         */
        public function __construct() {
            
            $this->cacheName   = 'sysstats';
            $this->cacheModule = self::CACHE_M0DULE_DASHBOARD;
            
            parent::__construct();   
            
            $this->runCheck();

            $this->headline = $this->language->translate('SYSTEM_stats');
            $this->content  = implode(PHP_EOL, array('<table class="fpcm-ui-table fpcm-small-text2">', implode(PHP_EOL, $this->tableContent),'</table>'));
            $this->name     = 'sysstats';            
            $this->position = 6;
            $this->height   = 1;
        }
        
        /**
         * Check ausführen
         */
        protected function runCheck() {

            if ($this->cache->isExpired()) {
                $this->getArticleStats();
                $this->getCommentStats();
                $this->getUserStats();
                $this->getFileStats();
                
                $this->cache->write($this->tableContent, $this->config->system_cache_timeout);
            } else {
                $this->tableContent = $this->cache->read();
            }
            
            $this->getCacheStats();
            
        }
        
        /**
         * Artikel-Statistiken berechnen
         */
        protected function getArticleStats() {
            $articleList = new \fpcm\model\articles\articlelist();
            
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_ARTICLES_ALL').':</strong></td><td class="fpcm-ui-center">'.$articleList->countArticlesByCondition().'</td></tr>';
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_ARTICLES_ACTIVE').':</strong></td><td class="fpcm-ui-center">'.$articleList->countArticlesByCondition(array('active' => true)).'</td></tr>';
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_ARTICLES_ARCHIVE').':</strong></td><td class="fpcm-ui-center">'.$articleList->countArticlesByCondition(array('archived' => true)).'</td></tr>';
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_ARTICLES_DRAFT').':</strong></td><td class="fpcm-ui-center">'.$articleList->countArticlesByCondition(array('drafts' => true)).'</td></tr>';
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_ARTICLES_TRASH').':</strong></td><td class="fpcm-ui-center">'.$articleList->countArticlesByCondition(array('deleted' => true)).'</td></tr>';
            
            $count = $articleList->countArticlesByCondition(array('approval' => true));
            $this->tableContent[] = '<tr class="'.($count > 0 ? 'fpcm-ui-important-text' : 'fpcm-ui-text').'"><td><strong>'.$this->language->translate('SYSTEM_STATS_ARTICLES_APPROVAL').':</strong></td><td class="fpcm-ui-center">'.$count.'</td></tr>';
        }
        
        /**
         * Kommentar-Statistiken berechnen
         */
        protected function getCommentStats() {
            $commentList = new \fpcm\model\comments\commentList();
            
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_COMMENTS_ALL').':</strong></td><td class="fpcm-ui-center">'.$commentList->countCommentsByCondition().'</td></tr>';
            
            $count = $commentList->countCommentsByCondition(array('unapproved' => true));
            $this->tableContent[] = '<tr class="'.($count > 0 ? 'fpcm-ui-important-text' : 'fpcm-ui-text').'"><td><strong>'.$this->language->translate('SYSTEM_STATS_COMMENTS_UNAPPR').':</strong></td><td class="fpcm-ui-center">'.$count.'</td></tr>';
            
            $count = $commentList->countCommentsByCondition(array('private' => true));
            $this->tableContent[] = '<tr class="'.($count > 0 ? 'fpcm-ui-important-text' : 'fpcm-ui-text').'"><td><strong>'.$this->language->translate('SYSTEM_STATS_COMMENTS_PRIVATE').':</strong></td><td class="fpcm-ui-center">'.$count.'</td></tr>';
            
            $count = $commentList->countCommentsByCondition(array('spam' => true));
            $this->tableContent[] = '<tr class="'.($count > 0 ? 'fpcm-ui-important-text' : 'fpcm-ui-text').'"><td><strong>'.$this->language->translate('SYSTEM_STATS_COMMENTS_SPAM').':</strong></td><td class="fpcm-ui-center">'.$count.'</td></tr>';
        }
        
        /**
         * Benutzer-Statistiken berechnen
         */
        protected function getUserStats() {
            
            $userCountAll = $this->dbcon->count(\fpcm\classes\database::tableAuthors);
            $userCountAct = $this->dbcon->count(\fpcm\classes\database::tableAuthors, '*', 'disabled = 0');            
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_USERS').':</strong></td><td class="fpcm-ui-center">'.$userCountAll.' ('.$userCountAct.')</td></tr>';
            
            $categoryCount = $this->dbcon->count(\fpcm\classes\database::tableCategories);
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_CATEGORIES').':</strong></td><td class="fpcm-ui-center">'.$categoryCount.'</td></tr>';
        }
        
        /**
         * Datei-Statistiken berechnen
         */
        protected function getFileStats() {
            
            $fileCount = $this->dbcon->count(\fpcm\classes\database::tableFiles, '*');
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_UPLOAD_COUNT').':</strong></td><td class="fpcm-ui-center">'.$fileCount.'</td></tr>'; 
            
            $imgList    = new \fpcm\model\files\imagelist();
            $folderSize = \fpcm\classes\tools::calcSize($imgList->getUploadFolderSize());
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_UPLOAD_SIZE').':</strong></td><td class="fpcm-ui-center">'.$folderSize.'</td></tr>';
        }
        
        /**
         * Cache-Statistiken berechnen
         */
        protected function getCacheStats() {
            $folderSize = \fpcm\classes\tools::calcSize($this->cache->getSize());
            $this->tableContent[] = '<tr><td><strong>'.$this->language->translate('SYSTEM_STATS_CACHE_SIZE').':</strong></td><td class="fpcm-ui-center">'.$folderSize.'</td></tr>';            
        }
        
        
    }