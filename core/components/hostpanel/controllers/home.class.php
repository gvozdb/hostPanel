<?php

/**
 * The home manager controller for hostPanel.
 *
 */
class hostPanelHomeManagerController extends hostPanelMainController {
	/* @var hostPanel $hostPanel */
	public $hostPanel;


	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}


	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('hostpanel');
	}


	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addCss($this->hostPanel->config['cssUrl'] . 'mgr/main.css');
		$this->addCss($this->hostPanel->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
		$this->addJavascript($this->hostPanel->config['jsUrl'] . 'mgr/misc/utils.js');
		$this->addJavascript($this->hostPanel->config['jsUrl'] . 'mgr/widgets/sites.grid.js');
		$this->addJavascript($this->hostPanel->config['jsUrl'] . 'mgr/widgets/sites.windows.js');
		$this->addJavascript($this->hostPanel->config['jsUrl'] . 'mgr/widgets/home.panel.js');
		$this->addJavascript($this->hostPanel->config['jsUrl'] . 'mgr/sections/home.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "hostpanel-page-home"});
		});
		</script>');
	}


	/**
	 * @return string
	 */
	public function getTemplateFile() {
		return $this->hostPanel->config['templatesPath'] . 'home.tpl';
	}
}