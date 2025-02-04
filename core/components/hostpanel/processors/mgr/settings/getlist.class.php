<?php

class hostPanelSettingsGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'hostPanelSettings';
    public $classKey = 'hostPanelSettings';

    public function process()
    {
        $key = $this->getProperty('key');
        $parent = $this->getProperty('parent', '');
        $values = $this->getProperty('values', []);
        if (!is_array($values)) {
            $values = $this->modx->fromJSON($values);
            if (!is_array($values)) {
                $values = [];
            }
        }

        $c = $this->modx->newQuery($this->classKey);
        $c->select('value');
        $c->where(array_merge(['key' => $key], ['parent' => $parent]));
        $c->limit(9999);
        $c->sortby($this->getProperty('sortby', 'id'), $this->getProperty('sortdir', 'DESC'));

        $output = [];
        if ($c->prepare() && $c->stmt->execute()) {
            $rows = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $i => $v) {
                @list($display, $value) = explode('==', $v['value']);

                $tmp = [];
                $tmp['display'] = isset($display) ? $display : '';
                $tmp['value'] = isset($value) ? $value : $tmp['display'];

                if (($values && in_array($tmp['value'], $values)) || !$values) {
                    $output[$i] = $tmp;
                }
            }
        }

        return $this->outputArray($output);
    }
}

return 'hostPanelSettingsGetListProcessor';