mspPrivateParts.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'mspprivateparts-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('mspprivateparts_item_create'),
        width: 550,
        autoHeight: true,
        url: mspPrivateParts.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    mspPrivateParts.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(mspPrivateParts.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('mspprivateparts_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('mspprivateparts_item_description'),
            name: 'description',
            id: config.id + '-description',
            height: 150,
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('mspprivateparts_item_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('mspprivateparts-item-window-create', mspPrivateParts.window.CreateItem);


mspPrivateParts.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'mspprivateparts-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('mspprivateparts_item_update'),
        width: 550,
        autoHeight: true,
        url: mspPrivateParts.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    mspPrivateParts.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(mspPrivateParts.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('mspprivateparts_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('mspprivateparts_item_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('mspprivateparts_item_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('mspprivateparts-item-window-update', mspPrivateParts.window.UpdateItem);