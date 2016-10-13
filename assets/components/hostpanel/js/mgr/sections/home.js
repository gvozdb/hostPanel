hostPanel.page.Home = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'hostpanel-panel-home', renderTo: 'hostpanel-panel-home-div'
		}]
	});
	hostPanel.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(hostPanel.page.Home, MODx.Component);
Ext.reg('hostpanel-page-home', hostPanel.page.Home);