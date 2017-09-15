// Поле смены пароля
hostPanel.combo.Password = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype: 'twintrigger',
        ctCls: 'x-field-password',
        allowBlank: true,
        msgTarget: 'under',
        emptyText: _('hostpanel_combo_password'),
        name: 'password',
        triggerAction: 'all',
        setBtnCls: 'x-field-password-set',
        magicBtnCls: 'x-field-password-magic',
        undoBtnCls: 'x-field-password-undo',
        onTrigger1Click: this._triggerSet,
        onTrigger2Click: this._triggerMagic,
        onTrigger3Click: this._triggerUndo,
    });
    hostPanel.combo.Password.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSet();
        }, this);
    });
    this.addEvents('undo', 'magic', 'set');
};
Ext.extend(hostPanel.combo.Password, Ext.form.TwinTriggerField, {
    initComponent: function () {
        Ext.form.TwinTriggerField.superclass.initComponent.call(this);
        this.triggerConfig = {
            tag: 'span',
            cls: 'x-field-password-btns',
            cn: [
                {tag: 'div', cls: 'x-form-trigger ' + this.setBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.magicBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.undoBtnCls},
            ]
        };
    },
    _triggerSet: function () {
        this.fireEvent('set', this);
    },
    _triggerMagic: function () {
        this.fireEvent('magic', this);
    },
    _triggerUndo: function () {
        this.fireEvent('undo', this);
    },
});
Ext.reg('hostpanel-combo-password', hostPanel.combo.Password);
Ext.reg('hostpanel-field-password', hostPanel.combo.Password);


// Комбобокс "PHP"
hostPanel.combo.php = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        store: new Ext.data.JsonStore({
            id: 0,
            comboid: config.id,
            root: 'results',
            totalProperty: 'total',
            autoLoad: true,
            fields: ['value', 'display'],
            url: hostPanel.config.connector_url,
            baseParams: {
                action: 'mgr/settings/getlist',
                key: 'php',
                parent: config.parent || '',
                values: config.values || {},
                sortby: config.sortby || 'value',
                sortdir: config.sortdir || 'DESC',
            },
        }),
        mode: 'remote',
        //mode: 'local',
        displayField: 'display',
        value: 'value',
        valueField: 'value',
        typeAhead: true,
        triggerAction: 'all',
    });
    hostPanel.combo.php.superclass.constructor.call(this, config);
};
Ext.extend(hostPanel.combo.php, MODx.combo.ComboBox);
Ext.reg('hostpanel-combo-php', hostPanel.combo.php);


// Комбобокс "CMS"
hostPanel.combo.cms = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        store: new Ext.data.JsonStore({
            id: 0,
            root: 'results',
            totalProperty: 'total',
            autoLoad: true,
            fields: ['value', 'display'],
            url: hostPanel.config.connector_url,
            baseParams: {
                action: 'mgr/settings/getlist',
                key: 'cms',
            },
        }),
        mode: 'remote',
        //mode: 'local',
        displayField: 'display',
        value: 'value',
        valueField: 'value',
        typeAhead: true,
        triggerAction: 'all',
    });
    hostPanel.combo.cms.superclass.constructor.call(this, config);
};
Ext.extend(hostPanel.combo.cms, MODx.combo.ComboBox);
Ext.reg('hostpanel-combo-cms', hostPanel.combo.cms);


// Комбобокс "Версия"
hostPanel.combo.version = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        store: new Ext.data.JsonStore({
            id: 0,
            comboid: config.id,
            root: 'results',
            totalProperty: 'total',
            autoLoad: true,
            fields: ['value', 'display'],
            url: hostPanel.config.connector_url,
            baseParams: {
                action: 'mgr/settings/getlist',
                key: 'version',
                parent: config.parent || '',
                values: config.values || {},
                sortby: config.sortby || 'value',
                sortdir: config.sortdir || 'DESC',
            },
            listeners: {
                clear: {
                    fn: function (obj) {
                        this.hide();
                    },
                    scope: this
                },
                load: {
                    fn: function (obj, recs, opts) {
                        if (obj.getTotalCount() > 0) {
                            var comboid = obj.comboid;
                            if (comboid) {
                                var combo = Ext.getCmp(comboid);
                                combo.setValue(recs[0].data['value']);
                            }
                            this.show();
                        }
                    },
                    scope: this
                },
            },
        }),
        mode: 'remote',
        //mode: 'local',
        displayField: 'display',
        value: 'value',
        valueField: 'value',
        typeAhead: true,
        triggerAction: 'all',
    });
    hostPanel.combo.version.superclass.constructor.call(this, config);
};
Ext.extend(hostPanel.combo.version, MODx.combo.ComboBox);
Ext.reg('hostpanel-combo-version', hostPanel.combo.version);


// Комбобокс "Сборка"
hostPanel.combo.layout = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        store: new Ext.data.JsonStore({
            id: 0,
            root: 'results',
            totalProperty: 'total',
            autoLoad: true,
            fields: ['value', 'display'],
            url: hostPanel.config.connector_url,
            baseParams: {
                action: 'mgr/settings/getlist',
                key: 'layout',
            },
            listeners: {
                'clear': {
                    fn: function (obj) {
                        this.hide();
                    }, scope: this
                },
                'load': {
                    fn: function (obj, recs, opts) {
                        obj.getTotalCount() > 0 && this.show();
                    }, scope: this
                },
            },
        }),
        mode: 'remote',
        //mode: 'local',
        displayField: 'display',
        value: 'value',
        valueField: 'value',
        typeAhead: true,
        triggerAction: 'all',
    });
    hostPanel.combo.layout.superclass.constructor.call(this, config);
};
Ext.extend(hostPanel.combo.layout, MODx.combo.ComboBox);
Ext.reg('hostpanel-combo-layout', hostPanel.combo.layout);


//
hostPanel.combo.Group = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'hostpanel-combo-group',
        displayField: 'display',
        valueField: 'value',
        valueHiddenField: 'value',
        emptyText: _('hostpanel_select_group'),
        pageSize: 10,
        mode: 'remote',
        typeAhead: true,
        triggerAction: 'all',
        store: new Ext.data.JsonStore({
            id: 0,
            root: 'results',
            totalProperty: 'total',
            autoLoad: true,
            fields: ['value', 'display'],
            url: hostPanel.config.connector_url,
            baseParams: {
                action: 'mgr/site/getgroups',
                key: 'group',
            },
        }),
        listeners: {},
    });
    hostPanel.combo.Group.superclass.constructor.call(this, config);

    this.on('expand', function () {
        var combo = Ext.getCmp(config.id);
        var comboStore = combo.getStore();
        comboStore.load();
    })
};
Ext.extend(hostPanel.combo.Group, MODx.combo.ComboBox);
Ext.reg('hostpanel-combo-group', hostPanel.combo.Group);