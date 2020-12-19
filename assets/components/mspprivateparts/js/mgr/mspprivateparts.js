var mspPrivateParts = function (config) {
    config = config || {};
    mspPrivateParts.superclass.constructor.call(this, config);
};
Ext.extend(mspPrivateParts, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('mspprivateparts', mspPrivateParts);

mspPrivateParts = new mspPrivateParts();