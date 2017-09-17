<?php

namespace fpcm\modules\nkorg\extendedstats\model;

class counter extends \fpcm\model\abstracts\tablelist {

    public function fetch() {        

        $result = $this->dbcon->select(
            \fpcm\classes\database::tableArticles,
            "count(id) AS counted, ".call_user_func([$this, 'getSelectItem'.ucfirst($this->dbcon->getDbtype())]),
            '1=1 GROUP BY dtstr'
        );
        
        if (!$result) {
            return [];
        }

        $values = $this->dbcon->fetch($result, true);
        
        $months = $this->language->translate('SYSTEM_MONTHS');
        
        $labels = [];
        $data   = [];
        
        foreach ($values as $value) {

            $dtstr = explode('-', $value->dtstr);
            $month = (int) $dtstr[0];
            
            $labels[]           = $months[$month].' '.$dtstr[1];
            $data[]           = (string) $value->counted;            
        }

        return [
            'labels'    => $labels,
            'datasets'  => [
                [
                    'label' => '',
                    'data'  => $data,
                    'backgroundColor' => [],
                    'borderWidth'     => 0
                ]
            ]
        ];

    }

    private function getSelectItemMysql() {
        return "DATE_FORMAT(FROM_UNIXTIME(createtime), '%m-%Y' ) AS dtstr";
    }
    
    private function getSelectItemPgsql() {
        return "to_char(to_timestamp(createtime), 'MM-YYYY') AS dtstr";
    }

}
