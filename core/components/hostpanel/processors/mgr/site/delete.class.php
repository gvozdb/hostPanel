<?php

class hostPanelSiteDeleteProcessor extends modObjectProcessor
{
    public $objectType = 'hostPanelSite';
    public $classKey = 'hostPanelSite';
    public $languageTopics = ['hostpanel'];
    //public $permission = 'remove';

    private $sock_host = 'localhost';
    private $sock_port = 9999;
    private $sock = false;
    private $sock_connect = false;
    private $sock_pass = '';

    /**
     * @return bool
     */
    public function initialize()
    {
        $this->sock_host = $this->modx->getOption('hostpanel_socket_host');
        $this->sock_port = (int)$this->modx->getOption('hostpanel_socket_port');

        return parent::initialize();
    }

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
        $id = $ids[0];

        if (!$object = $this->modx->getObject($this->classKey, $id)) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_nf'));
        }
        if ($object->get('lock')) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_remove_site_locked'));
        }

        // Проверяем сокет
        if (($this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_socket_create'));
        }
        if (!$this->sock_connect = socket_connect($this->sock, $this->sock_host, $this->sock_port)) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_socket_connect'));
        }

        $object->set('status', 'process');
        $object->save();

        // Отсылаем задание сокету
        $task_array = [
            'data' => [
                'secret' => $this->modx->getOption('hostpanel_secret'),
                'id' => $id,
                'user' => $object->get('user'),
                'pass' => $this->sock_pass,
                'dbname' => $this->modx->getOption('dbname'),
                'table' => trim($this->modx->getTableName($this->classKey), '`'),
            ],
            'task' => [
                [
                    'remove' => [
                        'user' => $object->get('user'),
                    ],
                ],
            ],
        ];

        $task_yaml = yaml_emit($task_array);
        socket_write($this->sock, $task_yaml, strlen($task_yaml));
        $out = socket_read($this->sock, 1024);

        if (stristr($out, 'ERROR')) {
            $object->set('status', 'deleted');
            $object->save();

            if (stristr($out, 'secret')) {
                return $this->failure($this->modx->lexicon('hostpanel_site_err_secret'));
            } else {
                return $this->failure($this->modx->lexicon('hostpanel_site_err_delete'));
            }
        }

        if (isset($this->sock)) {
            socket_close($this->sock);
        }

        return $this->success();
    }
}

return 'hostPanelSiteDeleteProcessor';