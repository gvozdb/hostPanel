<?php

class hostPanelSiteGetListGroupsProcessor extends modObjectGetListProcessor
{
    public $objectType = 'hostPanelSite';
    public $classKey = 'hostPanelSite';

    public function process()
    {
        $key = $this->getProperty('key');

        $c = $this->modx->newQuery($this->classKey);
        $c->select($key);
        $c->limit(9999);
        $c->sortby($this->getProperty('sortby', '`' . $key . '`'), $this->getProperty('sortdir', 'ASC'));
        $c->groupby('`' . $key . '`');

        $output = [
            [
                'display' => '- Не выбрано -',
                'value' => 0,
            ],
        ];
        if ($c->prepare() && $c->stmt->execute()) {
            $rows = $c->stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach ($rows as $v) {
                $tmp = [
                    'display' => $v ?: '- Без группы -',
                    'value' => $v,
                ];

                $output[] = $tmp;
            }
        }

        return $this->outputArray($output);
    }
}

return 'hostPanelSiteGetListGroupsProcessor';