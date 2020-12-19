<?php

/**
 * The home manager controller for mspPrivateParts.
 *
 */
class mspPrivatePartsHomeManagerController extends modExtraManagerController
{
    /** @var mspPrivateParts $mspPrivateParts */
    public $mspPrivateParts;


    /**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('mspprivateparts_core_path', null,
                $this->modx->getOption('core_path') . 'components/mspprivateparts/') . 'model/mspprivateparts/';
        $this->mspPrivateParts = $this->modx->getService('mspprivateparts', 'mspPrivateParts', $path);
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('mspprivateparts:default');
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('mspprivateparts');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->mspPrivateParts->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->mspPrivateParts->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addJavascript($this->mspPrivateParts->config['jsUrl'] . 'mgr/mspprivateparts.js');
        $this->addJavascript($this->mspPrivateParts->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->mspPrivateParts->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->mspPrivateParts->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->mspPrivateParts->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->mspPrivateParts->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->mspPrivateParts->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        mspPrivateParts.config = ' . json_encode($this->mspPrivateParts->config) . ';
        mspPrivateParts.config.connector_url = "' . $this->mspPrivateParts->config['connectorUrl'] . '";
        Ext.onReady(function() {
            MODx.load({ xtype: "mspprivateparts-page-home"});
        });
        </script>
        ');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->mspPrivateParts->config['templatesPath'] . 'home.tpl';
    }
}