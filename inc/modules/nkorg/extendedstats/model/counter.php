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
    
    const FPCM_NKORG_EXTSTATS_MODE_MONTH = 1;

    const FPCM_NKORG_EXTSTATS_MODE_YEAR = 2;

    const FPCM_NKORG_EXTSTATS_MODE_DAY = 3;
    
    protected $mode;

    protected $months;

    public function fetchArticles($start, $stop, $mode = 1) {
        
        $this->mode = (int) $mode;
        
        $hash = hash(\fpcm\classes\security::defaultHashAlgo, __METHOD__.json_encode(func_get_args()));
        $cache = new \fpcm\classes\cache($hash);

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

        $values       = $this->dbcon->fetch($result, true);
        $this->months = $this->language->translate('SYSTEM_MONTHS');
        
        $labels = [];
        $data   = [];
        $colors = [];
        
        $cached = ($cache->isExpired() ? [] : $cache->read());
        
        foreach ($values as $value) {

            $labels[]   = $this->getLabel($value->dtstr);
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
    
    private function getLabel($data) {
        
        switch ($this->mode) {
            case self::FPCM_NKORG_EXTSTATS_MODE_DAY :

                $dtstr      = explode('-',$data);
                $month      = (int) $dtstr[1];

                return $dtstr[2].'. '.$this->months[$month].' '.$dtstr[0];
                
                break;
            case self::FPCM_NKORG_EXTSTATS_MODE_YEAR :                
                return $data;
                break;
        }

        $dtstr      = explode('-',$data);
        $month      = (int) $dtstr[1];

        return $this->months[$month].' '.$dtstr[0];
    }

    private function getSelectItemMysql() {
        
        switch ($this->mode) {
            case self::FPCM_NKORG_EXTSTATS_MODE_DAY :
                return "DATE_FORMAT(FROM_UNIXTIME(createtime), '%Y-%m-%d' ) AS dtstr";
                break;
            case self::FPCM_NKORG_EXTSTATS_MODE_YEAR :
                return "DATE_FORMAT(FROM_UNIXTIME(createtime), '%Y' ) AS dtstr";
                break;
        }
        
        return "DATE_FORMAT(FROM_UNIXTIME(createtime), '%Y-%m' ) AS dtstr";
    }
    
    private function getSelectItemPgsql() {
        
        switch ($this->mode) {
            case self::FPCM_NKORG_EXTSTATS_MODE_DAY :
                return "to_char(to_timestamp(createtime), 'YYYY-MM_DD') AS dtstr";
                break;
            case self::FPCM_NKORG_EXTSTATS_MODE_YEAR :
                return "to_char(to_timestamp(createtime), 'YYYY') AS dtstr";
                break;
        }

        return "to_char(to_timestamp(createtime), 'YYYY-MM') AS dtstr";
    }

    private function getRandomColor() {
        
        $colStr = '#'.dechex(mt_rand(0, 255)).dechex(mt_rand(0, 255)).dechex(mt_rand(0, 255));
        return strlen($colStr) === 7 ? $colStr : str_pad($colStr, 7, dechex(mt_rand(0, 16)));
    }
}
