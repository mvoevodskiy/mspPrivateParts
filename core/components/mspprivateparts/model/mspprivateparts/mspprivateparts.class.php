<?php

class mspPrivateParts
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('mspprivateparts_core_path', $config,
            $this->modx->getOption('core_path') . 'components/mspprivateparts/'
        );
        $assetsUrl = $this->modx->getOption('mspprivateparts_assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/mspprivateparts/'
        );
        $connectorUrl = $assetsUrl . 'connector.php';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'imagesUrl' => $assetsUrl . 'images/',
            'connectorUrl' => $connectorUrl,

            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'templatesPath' => $corePath . 'elements/templates/',
            'chunkSuffix' => '.chunk.tpl',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'processorsPath' => $corePath . 'processors/',

            'minParts' => $this->modx->getOption('msppp_min_parts'),
            'maxParts' => $this->modx->getOption('msppp_max_parts'),
            'frontendJS' => $this->modx->getOption('msppp_frontend_js', null, '/assets/components/mspprivateparts/js/default.js')
        ), $config);

        $this->modx->addPackage('mspprivateparts', $this->config['modelPath']);
        $this->modx->lexicon->load('mspprivateparts:default');
    }

}