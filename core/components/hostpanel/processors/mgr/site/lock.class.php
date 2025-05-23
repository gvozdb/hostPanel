<?php

class hostPanelSiteLockProcessor extends modObjectProcessor
{
    public $objectType = 'hostPanelSite';
    public $classKey = 'hostPanelSite';
    public $languageTopics = ['hostpanel'];
    //public $permission = 'save';

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var hostPanelSite $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('hostpanel_site_err_nf'));
            }

            $object->set('lock', true);
            $object->save();
        }

        return $this->success();
    }
}

return 'hostPanelSiteLockProcessor';
