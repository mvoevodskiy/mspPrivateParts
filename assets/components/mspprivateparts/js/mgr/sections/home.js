mspPrivateParts.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'mspprivateparts-panel-home',
            renderTo: 'mspprivateparts-panel-home-div'
        }]
    });
    mspPrivateParts.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(mspPrivateParts.page.Home, MODx.Component);
Ext.reg('mspprivateparts-page-home', mspPrivateParts.page.Home);