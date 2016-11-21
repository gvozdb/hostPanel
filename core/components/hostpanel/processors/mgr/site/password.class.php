<?php

class hostPanelSitePasswordProcessor extends modObjectProcessor
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

        $password = $this->getProperty('password');
        if (empty($password)) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_password_empty'));
        }

        $id = (int)$this->getProperty('id');
        if (empty($id)) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_ns'));
        }
        if (!$object = $this->modx->getObject($this->classKey, $id)) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_nf'));
        }

        // Проверяем сокет
        if (($this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_socket_create'));
        }
        if (!$this->sock_connect = socket_connect($this->sock, $this->sock_host, $this->sock_port)) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_socket_connect'));
        }

        // Отсылаем задание сокету
        $task_array = array(
            'data' => array(
                'secret' => $this->modx->getOption('hostpanel_secret'),
                'id' => $id,
                'user' => $object->get('user'),
                'pass' => $this->sock_pass,
                'dbname' => $this->modx->getOption('dbname'),
                'table' => trim($this->modx->getTableName($this->classKey), '`'),
            ),
            'task' => array(
                array(
                    'password' => array(
                        'base_path' => $object->get('path'),
                        'user' => $object->get('user'),
                        'password' => $password,
                    ),
                ),
            ),
        );

        $task_yaml = yaml_emit($task_array);
        socket_write($this->sock, $task_yaml, strlen($task_yaml));
        $out = socket_read($this->sock, 1024);

        if (stristr($out, 'ERROR')) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_password'));
        }

        if (isset($this->sock)) {
            socket_close($this->sock);
        }

        return $this->success('Пароль успешно сохранён!');
    }
}

return 'hostPanelSitePasswordProcessor';