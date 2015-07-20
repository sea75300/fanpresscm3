<?php

namespace fpcm\modules\nkorg\modulecreator\controller;
    
class creator extends \fpcm\controller\abstracts\ajaxController {

    /**
     *
     * @var array
     */
    protected $info;
    
    protected $eventsArray;
    
    protected $moddir;
    
    protected $finalResult = true;

    /**
     * Request-Handler
     * @return boolean
     */
    public function request() {
    
        if (!$this->session->exists()) {
            return false;
        }
        
        $newdata = $this->getRequestVar('newdata');
        
        $this->info        = $newdata['info'];
        $this->eventsArray = $newdata['events'];
        
        $this->filterInfo();
        
        $this->moddir = \fpcm\classes\baseconfig::$moduleDir.$this->info['vendor'].'/'.$this->info['key'];  
        
        return true;
    }

    public function process() {

        if (!$this->moddir) {
            trigger_error('Unable to proceed with module creation, because module destination folder is empty!');
            $this->finalResult = false;
        }
        
        if ($this->finalResult && file_exists($this->moddir)) {
            trigger_error('Unable to proceed with module creation, because folder already exists!');
            $this->finalResult = false;
        }
        
        $this->finalResult = $this->finalResult && $this->createFolderStructure();
        $this->finalResult = $this->finalResult && $this->createConfigFiles();
        $this->finalResult = $this->finalResult && $this->createEventClasses();
        
        $this->finalize();
    }
    
    protected function createFolderStructure() {  

        if (!$this->finalResult) {
            return false;
        }
        
        if (!file_exists(dirname($this->moddir)) && !mkdir(dirname($this->moddir))) {
            trigger_error('Unable to create module base folder in '.dirname($this->moddir));
            return false;
        }
        
        if (!mkdir($this->moddir)) {
            trigger_error('Unable to create module base folder in '.$this->moddir);
            return false;
        }
        
        $folders = array('config', 'controller', 'model', 'events', 'js', 'lang', 'views');
        
        foreach ($folders as $folder) {
            if (!mkdir($this->moddir.'/'.$folder)) {
                trigger_error('Unable to create folder "'.$folder.'" for module folder structure');
                return false;
            }
        }
        
        $moduleclass = new \fpcm\modules\nkorg\modulecreator\model\moduleclass();
        $eventName = $this->info['vendor'].$this->info['key'];

        $code = $moduleclass->parse(array(
            'eventname'  => $eventName,
            'modulename' => $this->info['name'],
            'vendor'     => $this->info['vendor'],
            'modulekey'  => $this->info['key'],
            'version'    => $this->info['version'],
            'author'     => $this->info['author'],
            'infolink'   => filter_var($this->info['link'], FILTER_VALIDATE_URL)
        ));

        if (!file_put_contents($this->moddir.'/'.$eventName.'.php', $code)) {
            trigger_error('Unable to create event class file for event "'.$eventName.'".');
            return false;
        }
        
        return true;
    }
    
    protected function createConfigFiles() {
        
        if (!$this->finalResult) {
            return false;
        }
        
        include_once \fpcm\classes\loader::libGetFilePath('spyc', 'Spyc.php');
        
        $confdir = $this->moddir.'/config/';
        
        file_put_contents($confdir.'controllers.yml', "## Module Controller list file\n---\n");
        
        if (!file_put_contents($confdir.'dependencies.yml', "## Module dependency file\n---\n".$this->info['dependencies'])) {
            trigger_error('Unable to create dependency config file "'.$confdir.'dependencies.yml"');
            return false;
        }
        unset($this->info['dependencies']);
        
        $this->info['description'] = '"'.$this->info['description'].'"';        
        $ymlstring  = "## Module list config file\n";
        $ymlstring .= str_replace('description: >', 'description: ', \Spyc::YAMLDump($this->info,0,0));        
        
        if (!file_put_contents($confdir.'modulelist.yml', $ymlstring)) {
            trigger_error('Unable to create modulelist config file "'.$confdir.'modulelist.yml"');
            return false;
        }
        
        return true;

    }
    
    protected function createEventClasses() {

        if (!$this->finalResult) {
            return false;
        }
        
        $eventDraft = new \fpcm\modules\nkorg\modulecreator\model\eventdraft();
        foreach ($this->eventsArray as $eventName) {
            
            $code = $eventDraft->parse(array(
                'eventname'  => $eventName,
                'modulename' => $this->info['name'],
                'vendor'     => $this->info['vendor'],
                'modulekey'  => $this->info['key'],
                'version'    => $this->info['version'],
                'author'     => $this->info['author'],
                'infolink'   => filter_var($this->info['link'], FILTER_VALIDATE_URL)
            ));
            
            if (!file_put_contents($this->moddir.'/events/'.$eventName.'.php', $code)) {
                trigger_error('Unable to create event class file for event "'.$eventName.'".');
                return false;
            }
            
        }
        
        return true;
    }
    
    protected function finalize() {

        if (!$this->finalResult) {
            die('0');
        }
                
        die(str_replace(\fpcm\classes\baseconfig::$baseDir, '', $this->moddir));

    }
    
    protected function filterInfo() {
        
        $regex = '/[^0-9a-zA-Z_]/';

        $this->info['vendor'] = strtolower(preg_replace($regex, '', $this->info['vendor']));
        $this->info['key']    = strtolower(preg_replace($regex, '', $this->info['key']));
        
        
    }

}
?>