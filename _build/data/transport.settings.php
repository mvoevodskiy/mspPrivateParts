<?php
/** @var modX $modx */
/** @var array $sources */

$settings = array();

$tmp = array(
    'store_id' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'mspprivateparts_main',
    ),
    'password' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'mspprivateparts_main',
    ),
//    'hold' => array(
//        'xtype' => 'combo-boolean',
//        'value' => false,
//        'area' => 'mspprivateparts_main',
//    ),
    'merchant_type' => array(
        'xtype' => 'textfield',
        'value' => 'PP',
        'area' => 'mspprivateparts_main',
    ),
    'webhook' => array(
        'xtype' => 'textfield',
        'value' => '/assets/components/mspprivateparts/payment.php',
        'area' => 'mspprivateparts_main',
    ),
    'recipient_id' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'mspprivateparts_main',
    ),
    'min_parts' => array(
        'xtype' => 'numberfield',
        'value' => 2,
        'area' => 'mspprivateparts_main',
    ),
    'max_parts' => array(
        'xtype' => 'numberfield',
        'value' => 12,
        'area' => 'mspprivateparts_main',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'msppp_' . $k,
            'namespace' => PKG_NAME_LOWER,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
