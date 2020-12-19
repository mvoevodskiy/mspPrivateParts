<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/mspPrivateParts/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/mspprivateparts')) {
            $cache->deleteTree(
                $dev . 'assets/components/mspprivateparts/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/mspprivateparts/', $dev . 'assets/components/mspprivateparts');
        }
        if (!is_link($dev . 'core/components/mspprivateparts')) {
            $cache->deleteTree(
                $dev . 'core/components/mspprivateparts/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/mspprivateparts/', $dev . 'core/components/mspprivateparts');
        }
    }
}

return true;
