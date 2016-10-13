<?php

class hostPanelSiteDeleteProcessor extends modObjectProcessor
{
    public $objectType = 'hostPanelSite';
    public $classKey = 'hostPanelSite';
    public $languageTopics = array('hostpanel');
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
        $this->sock_port = (int) $this->modx->getOption('hostpanel_socket_port');

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

        // >> Проверяем сокет
        if (($this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_socket_create'));
        }

        $this->sock_connect = socket_connect($this->sock, $this->sock_host, $this->sock_port);
        if ($this->sock_connect === false) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_socket_connect'));
        }
        // << Проверяем сокет

        $object->set('status', 'process');
        $object->save();

        // >> Отсылаем задание сокету
        $task_array = array(
            'data' => array(
                'id' => $id,
                'user' => $object->get('user'),
                'pass' => $this->sock_pass,
                //'wait'		=> 1,
                'dbname' => $this->modx->getOption('dbname'),
                'table' => trim($this->modx->getTableName($this->classKey), '`'),
            ),
            'task' => array(
                array(
                    'remove' => array(
                        'user' => $object->get('user'),
                    ),
                ),
            ),
        );

        $task_yaml = yaml_emit($task_array);
        //$this->modx->log(MODX::LOG_LEVEL_ERROR, print_r($task_yaml,1));

        socket_write($this->sock, $task_yaml, strlen($task_yaml));

        $out = socket_read($this->sock, 1024);

        if (stristr($out, 'ERROR')) {
            $object->set('status', 'deleted');
            $object->save();

            return $this->failure($this->modx->lexicon('hostpanel_site_err_delete'));
        }

        if (isset($this->sock)) {
            socket_close($this->sock);
        }

        // << Отсылаем задание сокету

        return $this->success();
    }
}

return 'hostPanelSiteDeleteProcessor';