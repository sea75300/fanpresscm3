<?php
    /**
     * Sitemap Link List, http://nobody-knows.org/fanpress3/
     *
     * nkorg/sitemaplinklist event class: editorAddLinks
     * 
     * @version 3.0.0
     * @author Stefan <Stefan@yourdomain.xyz>
     * @copyright (c) 2015, Stefan
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\sitemaplinklist\events;

    class editorAddLinks extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {
            
            $acfile      = new \fpcm\modules\nkorg\sitemaplinklist\model\activelinkfile();
            $activeLinks = $acfile->loadData();
            
            if (!is_array($activeLinks) || !count($activeLinks)) {
                return $params;
            }
            
            foreach ($activeLinks as $activeLink) {
                $params[] = array(
                    'label' => $activeLink,
                    'value' => $activeLink
                );
            }
            
            
            return $params;
        }

    }