<?php
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var hostPanel $hostPanel */
$hostPanel = $modx->getService('hostpanel', 'hostPanel', $modx->getOption('hostpanel_core_path', null, $modx->getOption('core_path') . 'components/hostpanel/') . 'model/hostpanel/');
$modx->lexicon->load('hostpanel:default');

// handle request
$corePath = $modx->getOption('hostpanel_core_path', null, $modx->getOption('core_path') . 'components/hostpanel/');
$path = $modx->getOption('processorsPath', $hostPanel->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));