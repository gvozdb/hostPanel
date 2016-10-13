var hostPanel = function (config) {
	config = config || {};
	hostPanel.superclass.constructor.call(this, config);
};
Ext.extend(hostPanel, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('hostpanel', hostPanel);

hostPanel = new hostPanel();