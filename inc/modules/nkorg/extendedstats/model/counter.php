<?php
/**
 * Extended statistics
 *
 * nkorg/extendedstats event class: acpConfig
 * 
 * @version 1.0.0
 * @author imagine <imagine@yourdomain.xyz>
 * @copyright (c) 2017, imagine
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 *
 */
namespace fpcm\modules\nkorg\extendedstats\model;

class counter extends \fpcm\model\abstracts\tablelist {

    public function fetchArticles($start, $stop) {
        
        $cache = new \fpcm\classes\cache(__METHOD__);

        $where = '1=1';
        
        $where .= (trim($start) ? ' AND createtime >= '.strtotime($start) : '');
        $where .= (trim($stop)  ? ' AND createtime < '.strtotime($stop) : '');
        
        $result = $this->dbcon->select(
            \fpcm\classes\database::tableArticles,
            "count(id) AS counted, ".call_user_func([$this, 'getSelectItem'.ucfirst($this->dbcon->getDbtype())]),
            $where.' GROUP BY dtstr '.$this->dbcon->orderBy(['dtstr ASC'])
        );
        
        if (!$result) {
            return [];
        }

        $values = $this->dbcon->fetch($result, true);
        $months = $this->language->translate('SYSTEM_MONTHS');
        
        $labels = [];
        $data   = [];
        $colors = [];
        
        $cached = ($cache->isExpired() ? [] : $cache->read());
        
        foreach ($values as $value) {

            $dtstr      = explode('-', $value->dtstr);
            $month      = (int) $dtstr[1];

            $labels[]   = $months[$month].' '.$dtstr[0];
            $data[]     = (string) $value->counted;

            $cached[$value->dtstr] = (isset($cached[$value->dtstr]) ? $cached[$value->dtstr] : $this->getRandomColor());
            $colors[]   = $cached[$value->dtstr];

        }
        
        $cache->write($cached, 604800);

        return [
            'labels'    => $labels,
            'datasets'  => [
                [
                    'label'             => '',
                    'fill'              => false,
                    'data'              => $data,
                    'backgroundColor'   => $colors,
                    'borderColor'       => $this->getRandomColor(),
                ]
            ]
        ];

    }

    private function getSelectItemMysql() {
        return "DATE_FORMAT(FROM_UNIXTIME(createtime), '%Y-%m' ) AS dtstr";
    }
    
    private function getSelectItemPgsql() {
        return "to_char(to_timestamp(createtime), 'YYYY-MM') AS dtstr";
    }

    private function getRandomColor() {
        return '#'.dechex(mt_rand(0, 255)).dechex(mt_rand(0, 255)).dechex(mt_rand(0, 255));
    }
}
