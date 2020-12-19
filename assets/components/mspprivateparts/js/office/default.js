Ext.onReady(function () {
    mspPrivateParts.config.connector_url = OfficeConfig.actionUrl;

    var grid = new mspPrivateParts.panel.Home();
    grid.render('office-mspprivateparts-wrapper');

    var preloader = document.getElementById('office-preloader');
    if (preloader) {
        preloader.parentNode.removeChild(preloader);
    }
});