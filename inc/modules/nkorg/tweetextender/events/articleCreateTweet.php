<?php
    /**
     * Tweet Extender, http://nobody-knows.org/
     *
     * nkorg/tweetextender event class: articleCreateTweet
     * 
     * @version 3.0.0
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\tweetextender\events;

    class articleCreateTweet extends \fpcm\model\abstracts\moduleEvent {

        /**
         * 
         * @param \fpcm\model\articles\article $article
         * @return \fpcm\model\articles\article
         */
        public function run($article = null) {

            $termList = new \fpcm\modules\nkorg\tweetextender\model\termlist();
            $terms    = $termList->getTerms();
            
            if (!count($terms)) {
                return $article;
            }            

            $moduleArticle = clone $article;

            /* @var $term \fpcm\modules\nkorg\tweetextender\model\term */
            foreach ($terms as $term) {
                $newTitle = preg_replace(array('/('.$term->getSearchterm().')/is'), $term->getReplaceterm(), $moduleArticle->getTitle());
                $moduleArticle->setTitle($newTitle);
            }            
            
            \fpcm\classes\logs::syslogWrite($moduleArticle->getTitle());
            
            return $moduleArticle;
        }

    }