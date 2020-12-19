<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var mspPrivateParts $msppp */
if (!$msppp = $modx->getService('mspprivateparts', 'mspPrivateParts', $modx->getOption('mspprivateparts_core_path', null,
        $modx->getOption('core_path') . 'components/mspprivateparts/') . 'model/mspprivateparts/', $scriptProperties)
) {
    return 'Could not load mspPrivateParts class!';
}
/** @var pdoFetch $pdoTools */
$pdoTools = $modx->getService('pdotools');
/** @var miniShop2 $ms2 */
$ms2 = $modx->getService('minishop2');
$ms2->initialize();

// Do your snippet code here. This demo grabs 5 items from our custom table.
$tpl = $modx->getOption('tpl', $scriptProperties, 'mspPrivateParts.select');
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);

// Output
$output = $pdoTools->getChunk($tpl, ['min' => $msppp->config['minParts'], 'max' => $msppp->config['maxParts']]);
if (!empty($toPlaceholder)) {
    // If using a placeholder, output nothing and set output to specified placeholder
    $modx->setPlaceholder($toPlaceholder, $output);

    return '';
}

$payments = [];
$dbPmnts = $modx->getCollection('msPayment', ['class' => 'PrivateParts']);
foreach ($dbPmnts as $dbPmnt) {
    $payments[] = $dbPmnt->get('id');
}
$fields = $ms2->order->get();


$config = [
    'payments' => $payments,
    'count' => $fields['mspPrivateParts_count'] ?? $modx->getOption('msppp_min_parts'),
    'show' => in_array($fields['payment'], $payments)
];

$modx->regClientScript('<script type="text/javascript">var mspppConfig = ' . $modx->toJSON($config) . '</script>');
$modx->regClientScript($msppp->config['frontendJS']);

// By default just return output
return $output;
