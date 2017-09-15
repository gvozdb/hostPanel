<?php

class hostPanelSiteCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'hostPanelSite';
    public $classKey = 'hostPanelSite';
    public $languageTopics = array('hostpanel:default');
    protected $name = '';
    protected $domain = '';
    protected $php = '';
    protected $cms = '';
    protected $version = '';
    protected $modxconnectors = '';
    protected $modxmanager = '';
    protected $modxtableprefix = '';
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
        $this->name = trim($this->getProperty('name'));
        $this->domain = trim($this->getProperty('domain'));
        $this->php = trim($this->getProperty('php'));
        $this->cms = trim($this->getProperty('cms'));
        $this->version = trim($this->getProperty('version'));
        $this->modxconnectors = trim($this->getProperty('modxconnectors'));
        $this->modxmanager = trim($this->getProperty('modxmanager'));
        $this->modxtableprefix = trim($this->getProperty('modxtableprefix'));

        $this->name = ($this->name == $this->modx->lexicon('hostpanel_site_name_desc')) ? '' : $this->name;
        $this->domain = ($this->domain == $this->modx->lexicon('hostpanel_site_domain_desc')) ? '' : $this->domain;

        $this->setProperty('name', $this->name);
        $this->setProperty('domain', $this->domain);
        $this->setProperty('php', $this->php);
        $this->setProperty('cms', $this->cms);
        $this->setProperty('version', $this->version);
        $this->setProperty('modxconnectors', $this->modxconnectors);
        $this->setProperty('modxmanager', $this->modxmanager);
        $this->setProperty('modxtableprefix', $this->modxtableprefix);

        return parent::beforeSet();
    }

    public function process()
    {
        if (!function_exists(yaml_parse)) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_yaml_notfound'));
        }
        if ($this->modx->getCount($this->classKey, array('name' => $this->name))) {
            $this->modx->error->addField('name', $this->modx->lexicon('hostpanel_site_err_ae'));

            return $this->failure($this->modx->lexicon('hostpanel_site_err_ae'));
        }
        if (!empty($this->cms) && empty($this->version)) {
            $this->modx->error->addField('version', $this->modx->lexicon('hostpanel_site_err_version'));

            return $this->failure($this->modx->lexicon('hostpanel_site_err_version'));
        }

        $this->setProperty('status', 'process');

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

        $repl = array(
            array(
                '[[+id]]',
                '[[+name]]',
            ),
            array(
                $obj->get('id'),
                $obj->get('name'),
            ),
        );

        $host_domain = $this->modx->getOption('hostpanel_host_domain');
        $domain_mask = $this->modx->getOption('hostpanel_domain_mask');
        // $user_prefix = $this->modx->getOption('hostpanel_user_prefix');

        if (!$username = $this->getProperty('username')) {
            $username = $this->modx->getOption('hostpanel_user_mask');
        }
        $username = str_replace($repl[0], $repl[1], $username);

        $obj->set('user', $username);
        if (!$obj->get('name')) {
            $obj->set('name', $username);
        }
        $obj->save();

        $repl[0][] = '[[+user]]';
        $repl[1][] = $obj->get('user');

        $this->domain = !empty($this->domain) ? str_replace($repl[0], $repl[1], $this->domain) : str_replace($repl[0], $repl[1], $domain_mask);

        // Формируем задание
        $task_array['data'] = array(
            'secret' => $this->modx->getOption('hostpanel_secret'),
            'id' => $obj->get('id'),
            'user' => $obj->get('user'),
            'pass' => $this->sock_pass,
            'dbname' => $this->modx->getOption('dbname'),
            'table' => trim($this->modx->getTableName($this->classKey), '`'),
        );
        $task = array(
            'host' => $host_domain,
            'user' => $obj->get('user'),
            'domain' => $this->domain,
            'php' => $this->php,
            'version' => $obj->version,
            'modxconnectors' => $obj->modxconnectors,
            'modxmanager' => $obj->modxmanager,
            'modxtableprefix' => $obj->modxtableprefix,
        );
        if ($obj->get('cms') == 'modx') {
            $task_array['task'][] = array(
                'addmodx' => $task,
            );
        } elseif ($obj->get('cms') == '') {
            $task_array['task'][] = array(
                'addplace' => $task,
            );
        }

        // Отсылаем задание сокету
        $task_yaml = yaml_emit($task_array);
        //$this->modx->log(MODX::LOG_LEVEL_ERROR, print_r($task_yaml,1));

        socket_write($this->sock, $task_yaml, strlen($task_yaml));
        $out = socket_read($this->sock, 1024);
        //return $this->failure(print_r($out,1));

        if (stristr($out, 'ERROR')) {
            $obj->set('status', 'deleted');
            $obj->save();

            if (stristr($out, 'secret')) {
                return $this->failure($this->modx->lexicon('hostpanel_site_err_secret'));
            } else {
                return $this->failure($this->modx->lexicon('hostpanel_site_err_create'));
            }
        }
        if (isset($this->sock)) {
            socket_close($this->sock);
        }

        return parent::afterSave();
    }
}

return 'hostPanelSiteCreateProcessor';
