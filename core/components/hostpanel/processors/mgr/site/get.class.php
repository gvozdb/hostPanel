<?php

/**
 * Get an Site
 */
class hostPanelSiteGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'hostPanelSite';
    public $classKey = 'hostPanelSite';
    public $languageTopics = array('hostpanel:default');
    //public $permission = 'view';

    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     * @return mixed
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        return parent::process();
    }

    public function cleanup()
    {
        $array = $this->object->toArray();

        // Ссылка на админку в виде активной ссылки
        if ($array['site']) {
            $array['site_link'] = '<a href="http://' . $array['site'] . '" target="_blank">' . $array['site'] . '</a>';
        }
        if ($array['manager_site']) {
            $array['manager_site_link'] = '<a
                href="http://' . $array['site'] . $array['manager_site'] . '"
                class="js-manager-link">' . $array['manager_site'] . '</a>';
                // data-user="' . $array['manager_user'] . '"
                // data-pass="' . $array['manager_pass'] . '"
        }

        // Получаем список доступных версий
        if ($array['cms']) {
            $array['cms_full'] = $array['cms'] . ' ' . $array['version'];
            
            $versions = array();
            $q = $this->modx->newQuery('hostPanelSettings', array(
                'key' => 'version',
                'parent' => $array['cms'],
            ));
            $q->select('hostPanelSettings.value as version');
            $q->prepare();
            $q->stmt->execute();
            if ($rows = $q->stmt->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($rows as $row) {
                    if (version_compare($row['version'], $array['version'], '>=')) {
                        $versions[] = $row['version'];
                    }
                }
                // $this->modx->log(1, print_r($rows, 1));
            }
            $array['versions'] = $this->modx->toJSON($versions);
            // $this->modx->log(1, print_r($array['versions'], 1));
        } else {
            $array['versions'] = '[]';
        }

        return $this->success('', $array);
    }
}

return 'hostPanelSiteGetProcessor';