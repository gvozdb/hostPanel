<?php

/**
 * The base class for hostPanel.
 */
class hostPanel {
	/* @var modX $modx */
	public $modx;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = []) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('hostpanel_core_path', $config, $this->modx->getOption('core_path') . 'components/hostpanel/');
		$assetsUrl = $this->modx->getOption('hostpanel_assets_url', $config, $this->modx->getOption('assets_url') . 'components/hostpanel/');
		$connectorUrl = $assetsUrl .'connector.php';
		$socketConnectorUrl = $assetsUrl .'socket-connector.php';

		$this->config = array_merge([
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,
			'socketConnectorUrl' => $socketConnectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/'
        ], $config);

		$this->modx->addPackage('hostpanel', $this->config['modelPath']);
		$this->modx->lexicon->load('hostpanel:default');
	}

}