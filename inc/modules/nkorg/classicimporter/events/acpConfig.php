<?php

namespace fpcm\modules\nkorg\classicimporter\events;

class acpConfig extends \fpcm\model\abstracts\moduleEvent {

    /**
     *
     * @var \fpcm\classes\database
     */
    private $db;

    public function run($params = null) {

        $this->db = \fpcm\classes\baseconfig::$fpcmDatabase;
        
        $view = new \fpcm\model\view\module('nkorg/classicimporter', 'acp', 'main', '');

        $import = true;
        if ($this->db->count(\fpcm\classes\database::tableRoll) > 3) $import = false;
        if ($this->db->count(\fpcm\classes\database::tableAuthors) > 1) $import = false;
        if ($this->db->count(\fpcm\classes\database::tableCategories) > 1) $import = false;
        if ($this->db->count(\fpcm\classes\database::tableArticles) > 0) $import = false;
        if ($this->db->count(\fpcm\classes\database::tableComments) > 0) $import = false;
        
        if (!$import) {
            $view->addErrorMessage('FPCM_CLASSICIMPORTER_NOIMPORT');
        }
        
        $view->assign('doimport', $import);
        $view->assign('importActions', array(
            'FPCM_CLASSICIMPORTER_IMPORT_ROLLS'      => 'imports/rolls.php',
            'FPCM_CLASSICIMPORTER_IMPORT_USERS'      => 'imports/users.php',
            'FPCM_CLASSICIMPORTER_IMPORT_CATEGORIES' => 'imports/categories.php',
            'FPCM_CLASSICIMPORTER_IMPORT_IPS'        => 'imports/ipadresses.php',
            'FPCM_CLASSICIMPORTER_IMPORT_SMILEYS'    => 'imports/smileys.php',
            'FPCM_CLASSICIMPORTER_IMPORT_UPLAODS'    => 'imports/uploads.php',
            'FPCM_CLASSICIMPORTER_IMPORT_ARTICLES'   => 'imports/articles.php',
            'FPCM_CLASSICIMPORTER_IMPORT_CONFIG'     => 'imports/config.php',
            'FPCM_CLASSICIMPORTER_IMPORT_TEMPLATES'  => 'imports/templates.php'
        ));
        $view->addJsVars(array(
            'fpcmClassicImporterOpenModule' => $this->lang->translate('FPCM_CLASSICIMPORTER_OPENMODULE'),
            'fpcmClassicImporterArticleID' => $this->lang->translate('FPCM_CLASSICIMPORTER_IMPORT_ARTICLES_ID'),
        ));
        $view->render();
    }

}