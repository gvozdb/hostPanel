<?php

/**
 * Class hostPanelMainController
 */
abstract class hostPanelMainController extends modExtraManagerController {
	/** @var hostPanel $hostPanel */
	public $hostPanel;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('hostpanel_core_path', null, $this->modx->getOption('core_path') . 'components/hostpanel/');
		require_once $corePath . 'model/hostpanel/hostpanel.class.php';

		$this->hostPanel = new hostPanel($this->modx);
		//$this->addCss($this->hostPanel->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->hostPanel->config['jsUrl'] . 'mgr/hostpanel.js');
		$this->addHtml('
		<script type="text/javascript">
			hostPanel.config = ' . $this->modx->toJSON($this->hostPanel->config) . ';
			hostPanel.config.connector_url = "' . $this->hostPanel->config['connectorUrl'] . '";
			hostPanel.config.socket_connector_url = "' . $this->hostPanel->config['socketConnectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return ['hostpanel:default'];
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends hostPanelMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}