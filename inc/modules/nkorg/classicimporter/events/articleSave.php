<?php

namespace fpcm\modules\nkorg\classicimporter\events;

class articleSave extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {

        $tmpArticleData = new \fpcm\model\files\tempfile('articleimportdata');
        $data = json_decode($tmpArticleData->getContent(), true);
        
        if (!$tmpArticleData->exists() || !is_array($data)) return $params;
        
        $hash = md5($params['title'].'#'.$params['createtime']);
        
        if (!array_key_exists($hash, $data)) return $params;        
        $params['id'] = (int) $data[$hash];

        return $params;
    }

}