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
            $c->where([
                'group' => $group,
            ]);
        }

        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'name:LIKE' => "%{$query}%",
                'OR:description:LIKE' => "%{$query}%",
            ]);
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
        $data = $object->toArray();

        //
        // Manager
        $data['manager'] = [];
        if ($data['status'] !== 'deleted' && $data['status'] !== 'process') {
            if ($data['cms'] === 'modx') {
                // Enter to manager panel
                $data['manager'][] = [
                    'cls' => '',
                    'icon' => 'icon icon-sign-in',
                    'title' => $this->modx->lexicon('hostpanel_site_manager'),
                    'action' => 'managerSite',
                    'button' => true,
                    // 'menu' => true,
                ];
            }
        }

        //
        // Buttons and menu
        $data['actions'] = [];
        if ($data['status'] === 'process') {
            // Refresh
            $data['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-refresh',
                'title' => $this->modx->lexicon('hostpanel_site_refresh'),
                'action' => 'refreshGrid',
                'button' => true,
                'menu' => true,
            ];
        }
        if ($data['status'] !== 'deleted' && $data['status'] !== 'process') {
            // if ($data['cms'] === 'modx') {
            //     // Enter to manager panel
            //     $data['actions'][] = [
            //         'cls' => '',
            //         'icon' => 'icon icon-sign-in',
            //         'title' => $this->modx->lexicon('hostpanel_site_manager'),
            //         'action' => 'managerSite',
            //         'button' => true,
            //         'menu' => true,
            //     ];
            // }
            // Info
            $data['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-info',
                'title' => $this->modx->lexicon('hostpanel_site_info'),
                'action' => 'infoSite',
                'button' => true,
                'menu' => true,
            ];
            // Edit
            $data['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-edit',
                'title' => $this->modx->lexicon('hostpanel_site_edit'),
                'action' => 'editSite',
                'button' => true,
                'menu' => true,
            ];
            // PHP
            $data['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-wrench',
                'title' => $this->modx->lexicon('hostpanel_site_php'),
                'action' => 'phpSite',
                'button' => true,
                'menu' => true,
            ];
            if ($data['cms'] == 'modx') {
                // Update
                $data['actions'][] = [
                    'cls' => '',
                    'icon' => 'icon icon-repeat',
                    'title' => $this->modx->lexicon('hostpanel_site_update'),
                    'action' => 'updateSite',
                    'button' => true,
                    'menu' => true,
                ];
            }
        }
        if (!$data['lock']) {
            if ($data['status'] == 'deleted') {
                // Remove
                $data['actions'][] = [
                    'cls' => '',
                    'icon' => 'icon icon-times action-red',
                    'title' => $this->modx->lexicon('hostpanel_site_remove'),
                    //'multiple' => $this->modx->lexicon('hostpanel_sites_remove'),
                    'action' => 'removeSite',
                    'button' => true,
                    'menu' => true,
                ];
            } else {
                if ($data['status'] != 'process') {
                    // Lock
                    $data['actions'][] = [
                        'cls' => '',
                        'icon' => 'icon icon-lock',
                        'title' => $this->modx->lexicon('hostpanel_site_lock'),
                        //'multiple' => $this->modx->lexicon('hostpanel_sites_lock'),
                        'action' => 'lockSite',
                        'button' => true,
                        'menu' => true,
                    ];
                }

                // Delete
                $data['actions'][] = [
                    'cls' => '',
                    'icon' => 'icon icon-times action-red',
                    'title' => $this->modx->lexicon('hostpanel_site_delete'),
                    //'multiple' => $this->modx->lexicon('hostpanel_sites_remove'),
                    'action' => 'deleteSite',
                    'button' => false,
                    'menu' => true,
                ];
            }
        } else {
            // Unlock
            $data['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-unlock',
                'title' => $this->modx->lexicon('hostpanel_site_unlock'),
                //'multiple' => $this->modx->lexicon('hostpanel_sites_unlock'),
                'action' => 'unlockSite',
                'button' => true,
                'menu' => true,
            ];
        }

        return $data;
    }
}

return 'hostPanelSiteGetListProcessor';