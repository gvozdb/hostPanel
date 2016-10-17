hostPanel.window.InfoSite = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'hostpanel-site-window-info';
    }
    Ext.applyIf(config, {
        title: config.title || _('hostpanel_site_info'),
        width: 600,
        autoHeight: true,
        url: hostPanel.config.connector_url,
        action: 'mgr/site/info',
        fields: this.getFields(config),
        labelAlign: 'left',
        labelWidth: '30%',
        buttons: [{
            text: config.cancelBtnText || _('cancel'),
            scope: this,
            handler: function () {
                this.hide();
            }
        }],
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    hostPanel.window.InfoSite.superclass.constructor.call(this, config);

    // Обработка клика по ссылке входа в админку и автоматическая отправка POST запроса на вход
    this.on('afterrender', function () {
        var link = Ext.select('.js-manager-link');
        if (link.elements.length) {
            var $link = Ext.get(link.elements[0]);

            $link.on('click', function (e) {
                e.preventDefault();

                var url = $link.getAttribute('href');
                var user = $link.getAttribute('data-user');
                var pass = $link.getAttribute('data-pass');
                hostPanel.utils.post(url, {
                    username: user,
                    password: pass,
                    login: 1,
                });
            });
        }
    });
};
Ext.extend(hostPanel.window.InfoSite, MODx.Window, {
    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            items: [{
                layout: 'column',
                border: false,
                items: [{
                    columnWidth: .50,
                    border: false,
                    layout: 'form',
                    items: [{
                        xtype: 'fieldset',
                        layout: 'column',
                        title: 'О сайте',
                        anchor: '100%',
                        style: 'margin:0;',
                        items: [{
                            columnWidth: 1,
                            border: false,
                            layout: 'form',
                            //style: 'text-align:center;',
                            cls: 'hoster-info',
                            items: [{
                                xtype: 'displayfield',
                                name: 'name',
                                fieldLabel: 'Название',
                            }, {
                                xtype: 'displayfield',
                                name: 'site_link',
                                fieldLabel: 'Домен',
                            }, {
                                xtype: 'displayfield',
                                name: 'cms',
                                fieldLabel: 'CMS',
                            }, {
                                xtype: 'displayfield',
                                name: 'version',
                                fieldLabel: 'Версия',
                            }]
                        }],
                    }]
                }, {
                    columnWidth: .50,
                    border: false,
                    layout: 'form',
                    items: [{
                        xtype: 'fieldset',
                        layout: 'column',
                        title: 'Управление сайтом',
                        anchor: '100%',
                        style: 'margin:0;',
                        items: [{
                            columnWidth: 1,
                            border: false,
                            layout: 'form',
                            //style: 'text-align:center;',
                            cls: 'hoster-info',
                            items: [{
                                xtype: 'displayfield',
                                id: config.id + '-manager-link',
                                name: 'manager_site_link',
                                fieldLabel: 'Ссылка',
                            }, {
                                xtype: 'displayfield',
                                id: config.id + '-manager-user',
                                name: 'manager_user',
                                fieldLabel: 'Логин',
                            }, {
                                xtype: 'displayfield',
                                id: config.id + '-manager-pass',
                                name: 'manager_pass',
                                fieldLabel: 'Пароль',
                            }]
                        }],
                    }]
                }]
            }, {
                layout: 'column',
                border: false,
                items: [{
                    columnWidth: .50,
                    border: false,
                    layout: 'form',
                    items: [{
                        xtype: 'fieldset',
                        layout: 'column',
                        title: 'SSH и SFTP',
                        anchor: '100%',
                        style: 'margin:0;',
                        items: [{
                            columnWidth: 1,
                            border: false,
                            layout: 'form',
                            //style: 'text-align:center;',
                            cls: 'hoster-info',
                            items: [{
                                xtype: 'displayfield',
                                name: 'sftp_port',
                                fieldLabel: 'Порт',
                            }, {
                                xtype: 'displayfield',
                                name: 'sftp_user',
                                fieldLabel: 'Логин',
                            }, {
                                xtype: 'displayfield',
                                name: 'sftp_pass',
                                fieldLabel: 'Пароль',
                            }]
                        }],
                    }]
                }, {
                    columnWidth: .50,
                    border: false,
                    layout: 'form',
                    items: [{
                        xtype: 'fieldset',
                        layout: 'column',
                        title: 'MySQL',
                        anchor: '100%',
                        style: 'margin:0;',
                        items: [{
                            columnWidth: 1,
                            border: false,
                            layout: 'form',
                            //style: 'text-align:center;',
                            cls: 'hoster-info',
                            items: [{
                                xtype: 'displayfield',
                                name: 'mysql_site',
                                fieldLabel: 'Ссылка',
                            }, {
                                xtype: 'displayfield',
                                name: 'mysql_user',
                                fieldLabel: 'Логин',
                            }, {
                                xtype: 'displayfield',
                                name: 'mysql_pass',
                                fieldLabel: 'Пароль',
                            }]
                        }],
                    }]
                }]
            }]
        }];
    },

    loadDropZones: function () {
    },
});
Ext.reg('hostpanel-site-window-info', hostPanel.window.InfoSite);


hostPanel.window.CreateSite = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'hostpanel-site-window-create';
    }
    Ext.applyIf(config, {
        title: _('hostpanel_site_create'),
        bwrapCssClass: 'x-window-with-tabs',
        width: 600,
        autoHeight: true,
        url: hostPanel.config.socket_connector_url,
        action: 'mgr/site/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    hostPanel.window.CreateSite.superclass.constructor.call(this, config);
};
Ext.extend(hostPanel.window.CreateSite, MODx.Window, {
    getFields: function (config) {
        return [{
            xtype: 'modx-tabs',
            bodyStyle: {background: 'transparent'},
            border: true,
            deferredRender: false,
            autoScroll: false,
            anchor: '100% 100%',
            items: [{
                title: _('hostpanel_site'),
                layout: 'form',
                cls: 'modx-panel',
                anchor: '100% 100%',
                labelWidth: 100,
                items: [{
                    layout: 'column',
                    anchor: '100%',
                    style: 'margin-bottom: 15px;',
                    items: [{
                        columnWidth: .5,
                        border: false,
                        layout: 'form',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_username'),
                            emptyText: _('hostpanel_site_username_desc'),
                            name: 'username',
                            id: config.id + '-username',
                            anchor: '100%',
                        }, {
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_name'),
                            emptyText: _('hostpanel_site_name_desc'),
                            name: 'name',
                            id: config.id + '-name',
                            anchor: '100%',
                            //allowBlank: false,
                        }]
                    }, {
                        columnWidth: .5,
                        border: false,
                        layout: 'form',
                        style: 'margin-left:10px',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_domain'),
                            emptyText: _('hostpanel_site_domain_desc'),
                            name: 'domain',
                            id: config.id + '-domain',
                            anchor: '100%',
                        }, {
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_group'),
                            name: 'group',
                            id: config.id + '-group',
                            anchor: '100%',
                            //allowBlank: false,
                        }]
                    }],
                }, {
                    layout: 'column',
                    anchor: '100%',
                    style: 'margin-bottom: 15px;',
                    items: [{
                        columnWidth: .5,
                        border: false,
                        layout: 'form',
                        items: [{
                            xtype: 'hostpanel-combo-cms',
                            fieldLabel: _('hostpanel_site_cms'),
                            name: 'cms',
                            hiddenName: 'cms',
                            id: config.id + '-cms',
                            anchor: '100%',
                            listeners: {
                                'select': {
                                    fn: function (o) {
                                        var fields = ['version', 'layout'];
                                        for (i in fields) {
                                            if (fields.hasOwnProperty(i)) {
                                                var cmp = Ext.getCmp(config.id + '-' + fields[i]);
                                                if (cmp) {
                                                    var store = cmp.getStore();
                                                    if (store) {
                                                        store.removeAll();

                                                        if (o.value !== '') {
                                                            store.baseParams['parent'] = o.value;
                                                            store.load();
                                                        }
                                                        cmp.reset();
                                                        cmp.setValue('');
                                                    }
                                                }
                                            }
                                        }

                                        fields = ['modxconnectors', 'modxmanager', 'modxtableprefix'];
                                        for (i in fields) {
                                            if (fields.hasOwnProperty(i)) {
                                                if (o.getValue() == 'modx') {
                                                    Ext.getCmp(config.id + '-' + fields[i]).show();
                                                } else {
                                                    Ext.getCmp(config.id + '-' + fields[i]).hide();
                                                }
                                            }
                                        }
                                    },
                                    scope: this
                                },
                            },
                        }]
                    }, {
                        columnWidth: .5,
                        border: false,
                        layout: 'form',
                        style: 'margin-left:10px',
                        items: [{
                            xtype: 'hostpanel-combo-version',
                            fieldLabel: _('hostpanel_site_version'),
                            name: 'version',
                            hiddenName: 'version',
                            id: config.id + '-version',
                            anchor: '100%',
                            listeners: {
                                afterrender: {
                                    fn: function (o) {
                                        setTimeout(function () {
                                            if (o.store.getTotalCount() === 0) {
                                                o.hide();
                                            }
                                        }, 9);
                                    },
                                    scope: this
                                },
                            },
                        }]
                    }],
                }, {
                    layout: 'column',
                    anchor: '100%',
                    style: 'margin: 0;',
                    items: [{
                        columnWidth: .5,
                        border: false,
                        layout: 'form',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_modx_connectors'),
                            name: 'modxconnectors',
                            id: config.id + '-modxconnectors',
                            anchor: '100%',
                            hidden: true,
                        }, {
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_modx_manager'),
                            name: 'modxmanager',
                            id: config.id + '-modxmanager',
                            anchor: '100%',
                            hidden: true,
                        }]
                    }, {
                        columnWidth: .5,
                        border: false,
                        layout: 'form',
                        style: 'margin-left:10px',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_modx_tableprefix'),
                            name: 'modxtableprefix',
                            id: config.id + '-modxtableprefix',
                            anchor: '100%',
                            hidden: true,
                        }]
                    }],
                }, {
                    xtype: 'textarea',
                    fieldLabel: _('hostpanel_site_description'),
                    name: 'description',
                    id: config.id + '-description',
                    height: 70,
                    anchor: '100%',
                }],
            }, {
                id: 'modx-' + this.ident + '-packages',
                title: _('hostpanel_cms_packages'),
                layout: 'form',
                cls: 'modx-panel',
                autoHeight: true,
                forceLayout: true,
                labelWidth: 100,
                items: [],
            }],
        }];
    },

    loadDropZones: function () {
    },
});
Ext.reg('hostpanel-site-window-create', hostPanel.window.CreateSite);


hostPanel.window.EditSite = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'hostpanel-site-window-edit';
    }
    Ext.applyIf(config, {
        title: _('hostpanel_site_edit'),
        width: 600,
        autoHeight: true,
        url: hostPanel.config.connector_url,
        action: 'mgr/site/edit',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    hostPanel.window.EditSite.superclass.constructor.call(this, config);
};
Ext.extend(hostPanel.window.EditSite, MODx.Window, {
    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            layout: 'column',
            anchor: '100%',
            style: 'margin: 0;',
            items: [{
                columnWidth: .5,
                border: false,
                layout: 'form',
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('hostpanel_site_name'),
                    name: 'name',
                    id: config.id + '-name',
                    anchor: '100%',
                    allowBlank: false,
                }]
            }, {
                columnWidth: .5,
                border: false,
                layout: 'form',
                style: 'margin-left:10px',
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('hostpanel_site_group'),
                    name: 'group',
                    id: config.id + '-group',
                    anchor: '100%',
                }]
            }],
        }, {
            xtype: 'textarea',
            fieldLabel: _('hostpanel_site_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '100%',
            height: 70,
        }];
    },

    loadDropZones: function () {
    },
});
Ext.reg('hostpanel-site-window-edit', hostPanel.window.EditSite);


hostPanel.window.UpdateSite = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'hostpanel-site-window-update';
    }
    Ext.applyIf(config, {
        title: _('hostpanel_site_update'),
        width: 600,
        autoHeight: true,
        url: hostPanel.config.socket_connector_url,
        action: 'mgr/site/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    hostPanel.window.UpdateSite.superclass.constructor.call(this, config);
};
Ext.extend(hostPanel.window.UpdateSite, MODx.Window, {
    getFields: function (config) {
        var rec = config.record.object;

        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'hostpanel-combo-version',
            fieldLabel: _('hostpanel_site_version'),
            name: 'version',
            hiddenName: 'version',
            id: config.id + '-version',
            parent: rec.cms,
            values: rec.versions,
            anchor: '100%',
            listeners: {},
        }];
    },

    loadDropZones: function () {
    },
});
Ext.reg('hostpanel-site-window-update', hostPanel.window.UpdateSite);