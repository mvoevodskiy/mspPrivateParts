mspPrivateParts.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'mspprivateparts-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: false,
            hideMode: 'offsets',
            items: [{
                title: _('mspprivateparts_items'),
                layout: 'anchor',
                items: [{
                    html: _('mspprivateparts_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'mspprivateparts-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    mspPrivateParts.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(mspPrivateParts.panel.Home, MODx.Panel);
Ext.reg('mspprivateparts-panel-home', mspPrivateParts.panel.Home);
