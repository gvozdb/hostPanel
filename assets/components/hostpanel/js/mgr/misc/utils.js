hostPanel.utils.renderBoolean = function (value, props, row) {
    return value
        ? String.format('<span class="green">{0}</span>', _('yes'))
        : String.format('<span class="red">{0}</span>', _('no'));
};

hostPanel.utils.getMenu = function (actions, grid, selected) {
    var menu = [];
    var cls, icon, title, action = '';

    for (var i in actions) {
        if (!actions.hasOwnProperty(i)) {
            continue;
        }

        var a = actions[i];
        if (!a['menu']) {
            if (a == '-') {
                menu.push('-');
            }
            continue;
        }
        else if (menu.length > 0 && /^remove/i.test(a['action'])) {
            menu.push('-');
        }

        if (selected.length > 1) {
            if (!a['multiple']) {
                continue;
            }
            else if (typeof(a['multiple']) == 'string') {
                a['title'] = a['multiple'];
            }
        }

        cls = a['cls'] ? a['cls'] : '';
        icon = a['icon'] ? a['icon'] : '';
        title = a['title'] ? a['title'] : a['title'];
        action = a['action'] ? grid[a['action']] : '';

        menu.push({
            handler: action,
            text: String.format(
                '<span class="{0}"><i class="x-menu-item-icon {1}"></i>{2}</span>',
                cls, icon, title
            ),
        });
    }

    return menu;
};


hostPanel.utils.renderActions = function (value, metaData, row) {
    var res = [];
    var cls, icon, title, action, item, string = '';

    if (row.data.status == 'process' || row.data.status == 'deleted') {
        //metaData.css = "";
    }

    for (var i in row.data.actions) {
        if (!row.data.actions.hasOwnProperty(i)) {
            continue;
        }
        var a = row.data.actions[i];
        if (!a['button']) {
            continue;
        }

        cls = a['cls'] ? a['cls'] : '';
        icon = a['icon'] ? a['icon'] : '';
        action = a['action'] ? a['action'] : '';
        title = a['title'] ? a['title'] : '';

        item = String.format(
            '<li class="{0}"><button class="btn btn-default {1}" action="{2}" title="{3}"></button></li>',
            cls, icon, action, title
        );

        res.push(item);
    }

    string = String.format(
        '<ul class="hostpanel-row-actions">{0}</ul>',
        res.join('')
    );

    if (row.data.status == 'process') {
        string = '<div class="hostpanel-grid-row-width100per-white">Идёт обработка запроса... ' + string + '</div>';
    }
    else if (row.data.status == 'deleted') {
        string = '<div class="hostpanel-grid-row-width100per-white">Сайт удалён. Нужно удалить его из базы... ' + string + '</div>';
    }

    return string;
};


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