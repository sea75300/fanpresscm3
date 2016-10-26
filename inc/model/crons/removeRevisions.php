<?php

    namespace fpcm\model\crons;
    
    /**
     * FanPress CM remove old article revisions Cronjob
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.crons
     * @since FPCM 3.4
     */    
    class removeRevisions extends \fpcm\model\abstracts\cron {

        /**
         * Auszuführender Cron-Code
         */
        public function run() {
            
            $limit = \fpcm\classes\baseconfig::$fpcmConfig->articles_revisions_limit;
            if (!$limit) {
                $this->updateLastExecTime();
                return true;
            }
            
            $table = \fpcm\classes\database::tableRevisions;
            $count = $this->dbcon->count($table, '*', 'revision_idx <= ? ', array($this->lastExecTime));
            if ($count < $limit) {
                $this->updateLastExecTime();
                return true;
            }

            $deleteLimit = abs($count - $limit);

            $where = 'revision_idx <= ? '.$this->dbcon->orderBy(array('revision_idx ASC')).' '.$this->dbcon->limitQuery(0, $deleteLimit);
            $rows  = $this->dbcon->fetch($this->dbcon->select($table, 'revision_idx', $where, array($this->lastExecTime)), true);

            if (!$rows) {
                $this->updateLastExecTime();
                return true;
            }

            $ids = array();
            foreach ($rows as $row) {
                $ids[] = $row->revision_idx;
            }

            if (!count($ids)) {
                $this->updateLastExecTime();
                return true;
            }

            $this->dbcon->delete($table, 'revision_idx IN ('.implode(', ', $ids).')');
            $this->updateLastExecTime();

            return true;
        }
        
    }
