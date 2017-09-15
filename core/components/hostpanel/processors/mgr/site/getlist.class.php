<?php

class hostPanelSiteGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'hostPanelSite';
    public $classKey = 'hostPanelSite';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'list';

    /**
     * * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $group = $this->getProperty('group', false);
        if ($group !== false && $group !== '0') {
            $c->where(array(
                'group' => $group,
            ));
        }

        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where(array(
                'name:LIKE' => "%{$query}%",
                'OR:description:LIKE' => "%{$query}%",
            ));
        }

        return $c;
    }

    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();

        $array['actions'] = array();
        if ($array['status'] == 'process') {
            // Refresh
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-refresh',
                'title' => $this->modx->lexicon('hostpanel_site_refresh'),
                'action' => 'refreshGrid',
                'button' => true,
                'menu' => true,
            );
        }
        if ($array['status'] != 'deleted' && $array['status'] != 'process') {
            // Info
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-info',
                'title' => $this->modx->lexicon('hostpanel_site_info'),
                'action' => 'infoSite',
                'button' => true,
                'menu' => true,
            );
            // Edit
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-edit',
                'title' => $this->modx->lexicon('hostpanel_site_edit'),
                'action' => 'editSite',
                'button' => true,
                'menu' => true,
            );
            // PHP
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-wrench',
                'title' => $this->modx->lexicon('hostpanel_site_php'),
                'action' => 'phpSite',
                'button' => true,
                'menu' => true,
            );
            if ($array['cms'] == 'modx') {
                // Update
                $array['actions'][] = array(
                    'cls' => '',
                    'icon' => 'icon icon-repeat',
                    'title' => $this->modx->lexicon('hostpanel_site_update'),
                    'action' => 'updateSite',
                    'button' => true,
                    'menu' => true,
                );
            }
        }
        if (!$array['lock']) {
            if ($array['status'] == 'deleted') {
                // Remove
                $array['actions'][] = array(
                    'cls' => '',
                    'icon' => 'icon icon-times action-red',
                    'title' => $this->modx->lexicon('hostpanel_site_remove'),
                    //'multiple' => $this->modx->lexicon('hostpanel_sites_remove'),
                    'action' => 'removeSite',
                    'button' => true,
                    'menu' => true,
                );
            } else {
                if ($array['status'] != 'process') {
                    // Lock
                    $array['actions'][] = array(
                        'cls' => '',
                        'icon' => 'icon icon-lock',
                        'title' => $this->modx->lexicon('hostpanel_site_lock'),
                        //'multiple' => $this->modx->lexicon('hostpanel_sites_lock'),
                        'action' => 'lockSite',
                        'button' => true,
                        'menu' => true,
                    );
                }

                // Delete
                $array['actions'][] = array(
                    'cls' => '',
                    'icon' => 'icon icon-times action-red',
                    'title' => $this->modx->lexicon('hostpanel_site_delete'),
                    //'multiple' => $this->modx->lexicon('hostpanel_sites_remove'),
                    'action' => 'deleteSite',
                    'button' => false,
                    'menu' => true,
                );
            }
        } else {
            // Unlock
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-unlock',
                'title' => $this->modx->lexicon('hostpanel_site_unlock'),
                //'multiple' => $this->modx->lexicon('hostpanel_sites_unlock'),
                'action' => 'unlockSite',
                'button' => true,
                'menu' => true,
            );
        }

        return $array;
    }
}

return 'hostPanelSiteGetListProcessor';