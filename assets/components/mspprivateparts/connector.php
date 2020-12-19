<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
}
else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var mspPrivateParts $mspPrivateParts */
$mspPrivateParts = $modx->getService('mspprivateparts', 'mspPrivateParts', $modx->getOption('mspprivateparts_core_path', null,
        $modx->getOption('core_path') . 'components/mspprivateparts/') . 'model/mspprivateparts/'
);
$modx->lexicon->load('mspprivateparts:default');

// handle request
$corePath = $modx->getOption('mspprivateparts_core_path', null, $modx->getOption('core_path') . 'components/mspprivateparts/');
$path = $modx->getOption('processorsPath', $mspPrivateParts->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));