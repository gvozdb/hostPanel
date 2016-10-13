<?php

class hostPanelSiteSortProcessor extends modObjectProcessor
{
    public $classKey = 'hostPanelSite';

    /**
     * @return array|string
     */
    public function process()
    {
        /** @var hostPanelSite $target */
        if (!$target = $this->modx->getObject($this->classKey, $this->getProperty('target'))) {
            return $this->failure();
        }
        $sources = json_decode($this->getProperty('sources'), true);
        if (!is_array($sources)) {
            return $this->failure();
        }
        foreach ($sources as $id) {
            /** @var hostPanelSite $source */
            $source = $this->modx->getObject($this->classKey, $id);
            $target = $this->modx->getObject($this->classKey, $this->getProperty('target'));
            $this->sort($source, $target);
        }
        $this->updateIndex();

        return $this->modx->error->success();
    }

    /**
     * @param hostPanelSite $source
     * @param hostPanelSite $target
     */
    public function sort(hostPanelSite $source, hostPanelSite $target)
    {
        $c = $this->modx->newQuery('hostPanelSite');
        $c->command('UPDATE');
        if ($source->get('idx') < $target->get('idx')) {
            $c->query['set']['idx'] = array(
                'value' => '`idx` - 1',
                'type' => false,
            );
            $c->andCondition(array(
                'idx:<=' => $target->idx,
                'idx:>' => $source->idx,
            ));
            $c->andCondition(array(
                'idx:>' => 0,
            ));
        } else {
            $c->query['set']['idx'] = array(
                'value' => '`idx` + 1',
                'type' => false,
            );
            $c->andCondition(array(
                'idx:>=' => $target->idx,
                'idx:<' => $source->idx,
            ));
        }
        $c->prepare();
        $c->stmt->execute();
        $source->set('idx', $target->get('idx'));
        $source->save();
    }

    /**
     *
     */
    public function updateIndex()
    {
        // Check if need to update children indexes
        $c = $this->modx->newQuery($this->classKey);
        $c->groupby('idx');
        $c->select('COUNT(idx) as idx_count');
        $c->sortby('idx_count', 'DESC');
        $c->limit(1);
        if ($c->prepare() && $c->stmt->execute()) {
            if ($c->stmt->fetchColumn() == 1) {
                return;
            }
        }
        // Update indexes
        $c = $this->modx->newQuery($this->classKey);
        $c->select('id');
        $c->sortby('idx ASC, id', 'ASC');
        if ($c->prepare() && $c->stmt->execute()) {
            $table = $this->modx->getTableName($this->classKey);
            $update = $this->modx->prepare("UPDATE {$table} SET idx = ? WHERE id = ?");
            $i = 0;
            while ($id = $c->stmt->fetch(PDO::FETCH_COLUMN)) {
                $update->execute(array($i, $id));
                $i++;
            }
        }
    }
}

return 'hostPanelSiteSortProcessor';