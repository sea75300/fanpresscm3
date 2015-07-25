<?php

namespace fpcm\modules\nkorg\sitemaplinklist\events;

class themeAddJsFiles extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        $params[] = 'inc/modules/nkorg/sitemaplinklist/js/sitemaplinklist.js';
        return $params;
    }

}
