<?php
    /**
     * Sitemap Link List, https://nobody-knows.org/fanpress3/
     *
     * nkorg/sitemaplinklist class: nkorgsitemaplinklist
     * 
     * @version 3.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\sitemaplinklist;

    class nkorgsitemaplinklist extends \fpcm\model\abstracts\module {

        const NKORG_SITEMAPLINKLIST_CONFIGKEY = 'sitemaplinklist_filepath';
        
        public function runInstall() {
            
            $this->config->add(self::NKORG_SITEMAPLINKLIST_CONFIGKEY, '');
            
            return true;
        }

        public function runUninstall() {
            
            $this->config->remove(self::NKORG_SITEMAPLINKLIST_CONFIGKEY);
            
            return true;
        }

        public function runUpdate() {
            return true;
        }

    }
