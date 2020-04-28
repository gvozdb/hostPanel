hostPanel.grid.Sites = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'hostpanel-grid-sites';
    }

    Ext.applyIf(config, {
        url: hostPanel.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/site/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);

                row.data.status == 'process' && this.refreshGrid(grid, e, row);

                if (row.data.status != 'deleted') {
                    row.data.status != 'process' && this.infoSite(grid, e, row);
                }
            }
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec, ri, p) {
                var className = '';

                if (rec.data.status == 'process') {
                    className = 'hostpanel-grid-row-disabled';
                }

                if (rec.data.status == 'deleted') {
                    className = 'hostpanel-grid-row-red';
                }

                return className;
            },
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    hostPanel.grid.Sites.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(hostPanel.grid.Sites, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = hostPanel.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    infoSite: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/site/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'hostpanel-site-window-info',
                            id: Ext.id(),
                            title: _('hostpanel_site_info') + r.object.name,
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    createSite: function (btn, e) {
        var w = MODx.load({
            xtype: 'hostpanel-site-window-create',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.reset();
        w.setValues({
            username: MODx.config['hostpanel_user_mask'],
            modxconnectors: hostPanel.utils.genRegExpString('connectors_/[0-9a-z]{10}/'),
            modxmanager: 'adminka',
            modxtableprefix: hostPanel.utils.genRegExpString('modx_/[0-9A-Za-z]{10}/_'),
            php: '7.0',
        });
        w.show(e.target);
    },

    editSite: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/site/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'hostpanel-site-window-edit',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    updateSite: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/site/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'hostpanel-site-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        var values = Ext.apply({}, r.object);
                        values['modxconnectors'] = values['connectors_site'];
                        values['modxmanager'] = values['manager_site'];
                        values['modxtableprefix'] = values['mysql_table_prefix'];
                        w.setValues(values);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    phpSite: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/site/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'hostpanel-site-window-php',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        var values = Ext.apply({}, r.object);
                        w.setValues(values);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeSite: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('hostpanel_sites_remove')
                : _('hostpanel_site_remove'),
            text: ids.length > 1
                ? _('hostpanel_sites_remove_confirm')
                : _('hostpanel_site_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/site/remove',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function (r) {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    deleteSite: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('hostpanel_sites_delete')
                : _('hostpanel_site_delete'),
            text: ids.length > 1
                ? _('hostpanel_sites_delete_confirm')
                : _('hostpanel_site_delete_confirm'),
            url: hostPanel.config.socket_connector_url,
            params: {
                action: 'mgr/site/delete',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function (r) {
                        //this.refresh();
                        setTimeout(function () {
                                var grid = Ext.getCmp('hostpanel-grid-sites'),
                                    store = grid.getStore();

                                grid.refresh();
                            },
                            200);
                    },
                    scope: this
                }
            }
        });
        return true;
    },

    lockSite: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/site/lock',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    unlockSite: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/site/unlock',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    disableSite: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/site/disable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    enableSite: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/site/enable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    refreshGrid: function (act, btn, e) {
        this.refresh();
    },

    getFields: function (config) {
        return [
            'id',
            'idx',
            'user',
            'group',
            'name',
            'description',
            'php',
            'cms',
            'version',
            'status',
            'actions',
        ];
    },

    getColumns: function (config) {
        return [{
            header: _('hostpanel_site_id'),
            dataIndex: 'id',
            width: 50,
            sortable: true,
            fixed: true,
            resizable: false,
            hidden: true,
        }, {
            header: _('hostpanel_site_idx'),
            dataIndex: 'idx',
            width: 50,
            sortable: true,
            fixed: true,
            resizable: false,
            hidden: true,
        }, {
            header: _('hostpanel_site_user'),
            dataIndex: 'user',
            width: 120,
            sortable: true,
            fixed: true,
        }, {
            header: _('hostpanel_site_group'),
            dataIndex: 'group',
            width: 150,
            sortable: true,
            fixed: true,
        }, {
            header: _('hostpanel_site_name'),
            dataIndex: 'name',
            width: 200,
            sortable: true,
            fixed: true,
        }, {
            header: _('hostpanel_site_description'),
            dataIndex: 'description',
            width: 400,
            sortable: false,
        }, {
            header: _('hostpanel_site_php'),
            dataIndex: 'php',
            width: 100,
            sortable: true,
            fixed: true,
            resizable: false,
        }, {
            header: _('hostpanel_site_cms'),
            dataIndex: 'cms',
            width: 60,
            sortable: true,
            fixed: true,
            resizable: false,
        }, {
            header: _('hostpanel_site_version'),
            dataIndex: 'version',
            width: 70,
            sortable: true,
            fixed: true,
            resizable: false,
        }, {
            header: _('hostpanel_site_status'),
            dataIndex: 'status',
            width: 70,
            sortable: true,
            fixed: true,
            resizable: false,
        }, {
            header: _('hostpanel_grid_actions'),
            id: 'actions',
            dataIndex: 'actions',
            width: 200,
            sortable: false,
            fixed: true,
            resizable: false,
            renderer: hostPanel.utils.renderActions,
        }];
    },

    setFilterGroup: function (cb) {
        this.getStore().baseParams['group'] = cb.value;
        this.getBottomToolbar().changePage(1);
        //this.refresh();
    },

    getTopBar: function (config) {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('hostpanel_site_create'),
            handler: this.createSite,
            scope: this,
            cls: 'primary-button',
        }, '->', {
            xtype: 'hostpanel-combo-group',
            id: 'tbar-hostpanel-combo-group',
            width: 160,
            listeners: {
                select: {
                    fn: this.setFilterGroup,
                    scope: this
                }
            },
        }, {
            xtype: 'textfield',
            name: 'query',
            width: 200,
            id: config.id + '-search-field',
            emptyText: _('hostpanel_grid_search'),
            listeners: {
                render: {
                    fn: function (tf) {
                        tf.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
                            this._doSearch(tf);
                        }, this);
                    }, scope: this
                }
            }
        }, {
            xtype: 'button',
            id: config.id + '-search-clear',
            text: '<i class="icon icon-times"></i>',
            listeners: {
                click: {fn: this._clearSearch, scope: this}
            }
        }];
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _doSearch: function (tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },

    _clearSearch: function (btn, e) {
        this.getStore().baseParams.query = '';
        Ext.getCmp(this.config.id + '-search-field').setValue('');
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
});
Ext.reg('hostpanel-grid-sites', hostPanel.grid.Sites);