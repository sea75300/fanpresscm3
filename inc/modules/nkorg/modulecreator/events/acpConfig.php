<?php

namespace fpcm\modules\nkorg\modulecreator\events;

class acpConfig extends \fpcm\model\abstracts\moduleEvent {

    public function run($params = null) {
        $moduleEventList = new \fpcm\model\events\eventList();
        
        $sortedEvents = array();
        foreach ($moduleEventList->getSystemEventList() as $eventName) {
            $letter = strtoupper(substr($eventName, 0, 1));
            $sortedEvents[$letter][] = $eventName;
        }
        
        $view = new \fpcm\model\view\module('nkorg/modulecreator', 'acp', 'main', '');
        $view->assign('sortedEvents', $sortedEvents);
        $view->render();
    }

}