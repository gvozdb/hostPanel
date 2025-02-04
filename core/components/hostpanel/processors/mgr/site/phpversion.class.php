<?php

class hostPanelSitePhpVersionProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'hostPanelSite';
    public $classKey = 'hostPanelSite';
    public $languageTopics = ['hostpanel'];
    //public $permission = 'save';

    protected $php = '';
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
     * @return bool
     */
    public function beforeSet()
    {

        $id = (int)$this->getProperty('id');
        if (empty($id)) {
            return $this->modx->lexicon('hostpanel_site_err_ns');
        }

        if (!$this->php = trim($this->getProperty('php'))) {
            return $this->modx->lexicon('hostpanel_site_err_php');
        }

        $this->unsetProperty('php');
        $this->setProperty('status', 'process');

        return parent::beforeSet();
    }

    public function process()
    {
        if (!function_exists(yaml_parse)) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_yaml_notfound'));
        }

        // Проверяем сокет
        if (($this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_socket_create'));
        }
        $this->sock_connect = socket_connect($this->sock, $this->sock_host, $this->sock_port);
        if ($this->sock_connect === false) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_socket_connect'));
        }

        return parent::process();
    }

    public function afterSave()
    {
        $obj = &$this->object;

        // Формируем задание
        $task_array['data'] = [
            'secret' => $this->modx->getOption('hostpanel_secret'),
            'id' => $obj->get('id'),
            'user' => $obj->get('user'),
            'pass' => $this->sock_pass,
            'dbname' => $this->modx->getOption('dbname'),
            'table' => trim($this->modx->getTableName($this->classKey), '`'),
        ];
        $task_array['task'][] = [
            'php' => [
                'user' => $obj->get('user'),
                'php' => $this->php,
            ],
        ];

        // Отсылаем задание сокету
        $task_yaml = yaml_emit($task_array);
        //$this->modx->log(MODX::LOG_LEVEL_ERROR, print_r($task_yaml,1));

        socket_write($this->sock, $task_yaml, strlen($task_yaml));
        $out = socket_read($this->sock, 1024);
        //return $this->failure(print_r($out,1));

        if (stristr($out, 'ERROR')) {
            $obj->set('status', 'run');
            $obj->save();

            if (stristr($out, 'secret')) {
                return $this->failure($this->modx->lexicon('hostpanel_site_err_secret'));
            } else {
                return $this->failure($this->modx->lexicon('hostpanel_site_err_update'));
            }
        }
        if (isset($this->sock)) {
            socket_close($this->sock);
        }

        return parent::afterSave();
    }
}

return 'hostPanelSitePhpVersionProcessor';
