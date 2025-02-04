<?php

/**
 * Remove an Sites
 */
class hostPanelSiteRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'hostPanelSite';
    public $classKey = 'hostPanelSite';
    public $languageTopics = ['hostpanel'];
    //public $permission = 'remove';

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
            if ($object->get('lock')) {
                return $this->failure($this->modx->lexicon('hostpanel_site_err_remove_site_locked'));
            }

            $object->remove();
        }

        return $this->success();
    }
}

return 'hostPanelSiteRemoveProcessor';