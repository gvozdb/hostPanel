hostPanel.window.InfoSite = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'hostpanel-site-window-info';
    }
    Ext.applyIf(config, {
        title: config.title || _('hostpanel_site_info'),
        width: 700,
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

    this.on('hide', function () {
        var w = this;
        window.setTimeout(function () {
            w.close();
        }, 200);
    });

    // Обработка клика по ссылке входа в админку и автоматическая отправка POST запроса на вход
    this.on('afterrender', function () {
        var self = this;
        var data = this.record ? this.record.object : null;

        var manager_link = Ext.select('.js-manager-link');
        if (manager_link.elements['length']) {
            var $manager_link = Ext.get(manager_link.elements[0]);

            $manager_link.on('click', function (e) {
                e.preventDefault();

                var url = 'http://' + data['site'] + data['manager_site'];
                var user = data['manager_user'];
                var pass = data['manager_pass'];

                hostPanel.utils.post(url, {
                    username: user,
                    password: pass,
                    login: 1,
                });
            });
        }

        var sprutio_link = Ext.select('.js-sprutio-link');
        if (sprutio_link.elements['length']) {
            var $sprutio_link = Ext.get(sprutio_link.elements[0]);

            $sprutio_link.on('click', function (e) {
                e.preventDefault();

                var url = $sprutio_link.dom['href'] + 'auth';
                var user = data['sftp_user'];
                var pass = data['sftp_pass'];

                hostPanel.utils.ajaxSubmit(url, {
                        login: user,
                        password: pass,
                        language: 'ru',
                    },
                    function (response, opts) {
                        // var obj = Ext.decode(response.responseText);
                        console.log('success response', response);
                    },
                    function (response, opts) {
                        console.log('failure response', response);
                    }
                );
            });
        }
    }, this);
};
Ext.extend(hostPanel.window.InfoSite, MODx.Window, {
    getFields: function (config) {
        var data = config.record ? config.record.object : null;

        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            items: [{
                layout: 'column',
                border: false,
                items: [{
                    columnWidth: .45,
                    border: false,
                    layout: 'form',
                    items: [{
                        xtype: 'fieldset',
                        layout: 'column',
                        title: 'SSH и SFTP',
                        anchor: '100%',
                        style: 'margin:0 0 10px;',
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
                                name: 'sprutio_link',
                                fieldLabel: 'Логин',
                            }, {
                                xtype: 'displayfield',
                                name: 'sftp_pass',
                                fieldLabel: 'Пароль',
                            }]
                        }],
                    }]
                }, {
                    columnWidth: .55,
                    border: false,
                    layout: 'form',
                    items: [{
                        xtype: 'fieldset',
                        layout: 'column',
                        title: 'О сайте',
                        anchor: '100%',
                        style: 'margin:0 0 10px;',
                        items: [{
                            columnWidth: 1,
                            border: false,
                            layout: 'form',
                            //style: 'text-align:center;',
                            cls: 'hoster-info',
                            items: [{
                                xtype: 'displayfield',
                                name: 'name_link',
                                fieldLabel: 'Сайт',
                            }, {
                                xtype: 'displayfield',
                                name: 'php',
                                fieldLabel: 'PHP',
                            }, {
                                xtype: 'displayfield',
                                name: 'cms_full',
                                fieldLabel: 'CMS',
                            }]
                        }],
                    }]
                }]
            }, {
                layout: 'column',
                border: false,
                items: [{
                    columnWidth: .45,
                    border: false,
                    layout: 'form',
                    items: [{
                        xtype: 'fieldset',
                        layout: 'column',
                        title: 'MySQL',
                        anchor: '100%',
                        style: 'margin:0 0 10px;',
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
                }, {
                    columnWidth: .55,
                    border: false,
                    layout: 'form',
                    items: [{
                        xtype: 'fieldset',
                        layout: 'column',
                        title: 'Управление сайтом',
                        anchor: '100%',
                        style: 'margin:0 0 10px;',
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
                                xtype: 'hostpanel-field-password',
                                id: config.id + '-manager-pass',
                                name: 'manager_pass',
                                fieldLabel: 'Пароль',
                                width: 220,
                                listeners: {
                                    set: {
                                        fn: function (field) {
                                            MODx.Ajax.request({
                                                url: hostPanel.config['connector_url'],
                                                params: {
                                                    action: 'mgr/site/password',
                                                    id: data['id'],
                                                    password: field.getValue(),
                                                },
                                                listeners: {
                                                    success: {
                                                        fn: function (r) {
                                                            data['manager_pass'] = field.getValue();

                                                            if (typeof(r['message']) != 'undefined' && r['message'] != '') {
                                                                MODx.msg.alert('success', r['message']);
                                                            }
                                                        }, scope: this
                                                    },
                                                    failure: {
                                                        fn: function (r) {
                                                            if (typeof(r['message']) != 'undefined' && r['message'] != '') {
                                                                MODx.msg.alert('failure', r['message']);
                                                            }
                                                        }, scope: this
                                                    },
                                                }
                                            });
                                        }, scope: this
                                    },
                                    magic: {
                                        fn: function (field) {
                                            field.setValue(hostPanel.utils.genRegExpString('/[0-9a-zA-Z]{10}/'));
                                        }, scope: this
                                    },
                                    undo: {
                                        fn: function (field) {
                                            field.setValue(data['manager_pass']);
                                        }, scope: this
                                    },
                                }
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

    this.on('hide', function () {
        var w = this;
        window.setTimeout(function () {
            w.close();
        }, 200);
    });
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
                    style: 'margin-bottom: 5px;',
                    items: [{
                        columnWidth: .25,
                        border: false,
                        layout: 'form',
                        style: 'margin-right: 2px;',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_username'),
                            emptyText: _('hostpanel_site_username_desc'),
                            name: 'username',
                            id: config.id + '-username',
                            anchor: '100%',
                        }],
                    }, {
                        columnWidth: .25,
                        border: false,
                        layout: 'form',
                        style: 'margin-left: 2px; margin-right: 2px;',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_name'),
                            emptyText: _('hostpanel_site_name_desc'),
                            name: 'name',
                            id: config.id + '-name',
                            anchor: '100%',
                            //allowBlank: false,
                        }],
                    }, {
                        columnWidth: .25,
                        border: false,
                        layout: 'form',
                        style: 'margin-left: 2px; margin-right: 2px;',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_domain'),
                            emptyText: _('hostpanel_site_domain_desc'),
                            name: 'domain',
                            id: config.id + '-domain',
                            anchor: '100%',
                        }],
                    }, {
                        columnWidth: .25,
                        border: false,
                        layout: 'form',
                        style: 'margin-left: 2px;',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_group'),
                            name: 'group',
                            id: config.id + '-group',
                            anchor: '100%',
                            //allowBlank: false,
                        }],
                    }],
                }, {
                    layout: 'column',
                    anchor: '100%',
                    items: [{
                        columnWidth: .3,
                        border: false,
                        layout: 'form',
                        style: 'margin-right: 5px;',
                        items: [{
                            xtype: 'hostpanel-combo-php',
                            fieldLabel: _('hostpanel_site_php'),
                            name: 'php',
                            hiddenName: 'php',
                            id: config.id + '-php',
                            anchor: '100%',
                        }]
                    }, {
                        columnWidth: .4,
                        border: false,
                        layout: 'form',
                        style: 'margin-left: 5px; margin-right: 5px;',
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
                        columnWidth: .3,
                        border: false,
                        layout: 'form',
                        style: 'margin-left: 5px;',
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
                        columnWidth: .3,
                        border: false,
                        layout: 'form',
                        style: 'margin-right: 5px;',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_modx_manager'),
                            name: 'modxmanager',
                            id: config.id + '-modxmanager',
                            anchor: '100%',
                            hidden: true,
                        }]
                    }, {
                        columnWidth: .4,
                        border: false,
                        layout: 'form',
                        style: 'margin-left: 5px; margin-right: 5px;',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('hostpanel_site_modx_connectors'),
                            name: 'modxconnectors',
                            id: config.id + '-modxconnectors',
                            anchor: '100%',
                            hidden: true,
                        }]
                    }, {
                        columnWidth: .3,
                        border: false,
                        layout: 'form',
                        style: 'margin-left: 5px;',
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
                    height: 50,
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

    this.on('hide', function () {
        var w = this;
        window.setTimeout(function () {
            w.close();
        }, 200);
    });
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
        width: 400,
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

    this.on('hide', function () {
        var w = this;
        window.setTimeout(function () {
            w.close();
        }, 200);
    });
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

        // {
        //     layout: 'column',
        //         anchor: '100%',
        //     style: 'margin: 10px 0 0;',
        //     items: [{
        //     columnWidth: .5,
        //     border: false,
        //     layout: 'form',
        //     items: [{
        //         xtype: 'textfield',
        //         fieldLabel: _('hostpanel_site_modx_connectors'),
        //         name: 'modxconnectors',
        //         id: config.id + '-modxconnectors',
        //         anchor: '100%',
        //     }, {
        //         xtype: 'textfield',
        //         fieldLabel: _('hostpanel_site_modx_manager'),
        //         name: 'modxmanager',
        //         id: config.id + '-modxmanager',
        //         anchor: '100%',
        //     }]
        // }, {
        //     columnWidth: .5,
        //     border: false,
        //     layout: 'form',
        //     style: 'margin-left:10px',
        //     items: [{
        //         xtype: 'textfield',
        //         fieldLabel: _('hostpanel_site_modx_tableprefix'),
        //         name: 'modxtableprefix',
        //         id: config.id + '-modxtableprefix',
        //         anchor: '100%',
        //     }]
        // }],
        // }
    },

    loadDropZones: function () {
    },
});
Ext.reg('hostpanel-site-window-update', hostPanel.window.UpdateSite);


hostPanel.window.PhpSite = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'hostpanel-site-window-php';
    }
    Ext.applyIf(config, {
        title: _('hostpanel_site_php'),
        width: 400,
        autoHeight: true,
        url: hostPanel.config.socket_connector_url,
        action: 'mgr/site/phpversion',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    hostPanel.window.PhpSite.superclass.constructor.call(this, config);

    this.on('hide', function () {
        var w = this;
        window.setTimeout(function () {
            w.close();
        }, 200);
    });
};
Ext.extend(hostPanel.window.PhpSite, MODx.Window, {
    getFields: function (config) {
        var rec = config.record.object;

        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'hostpanel-combo-php',
            fieldLabel: _('hostpanel_site_php'),
            name: 'php',
            hiddenName: 'php',
            id: config.id + '-php',
            anchor: '100%',
            listeners: {},
        }];
    },

    loadDropZones: function () {
    },
});
Ext.reg('hostpanel-site-window-php', hostPanel.window.PhpSite);