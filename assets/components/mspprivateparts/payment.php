<?php

/** @var modX $modx */
define('MODX_API_MODE', true);
/** @noinspection PhpIncludeInspection */
if (file_exists(dirname(dirname(dirname(__FILE__))) . '/index.php')) {
    require_once dirname(dirname(dirname(__FILE__))) . '/index.php';
} elseif (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php')) {
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';
} elseif (file_exists(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/index.php')) {
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';
} elseif (file_exists(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/index.php')) {
    require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/index.php';
}
//require dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';
$modx->getService('error', 'error.modError');

$bankInput = $modx->fromJSON(file_get_contents('php://input'));

$modx->error->message = null;
/** @var miniShop2 $miniShop2 */
/** @var mspPrivatePartsOrder $record */
$miniShop2 = $modx->getService('miniShop2');
$miniShop2->loadCustomClasses('payment');
if (!class_exists('PrivateParts')) {
    $modx->log(0, 'Error: could not load payment class "PrivateParts".');
    exit('Error: could not load payment class "PrivateParts".');
} elseif (empty($bankInput['orderId'])) {
    $modx->log(0, 'Error: the order id is not specified.');
    exit('Error: the order id is not specified.');
} elseif (!$record = $modx->getObject('mspPrivatePartsOrder', ['order_id' => $bankInput['orderId']])) {
    $modx->log(0, 'Error: could not load specified order.');
    exit('Error: could not load specified order.');
}

/** @var msOrder $order */
if ($order = $record->getOne('Order')) {
    /** @var PrivateParts $handler */
    $handler = new PrivateParts($order);
//    if ($payment = $handler->PrivateParts->payments->get($record->remote_id)) {
        if ($bankInput['paymentState'] === 'SUCCESS') {
            $response = $handler->receive($order, 2);
//        } elseif ($payment->isCancelled()) {
//            $response = $handler->receive($order, 4);
//        } else {
//            $response = 'Error: could not process order.';
        }
//        exit($response !== true ? $response : 'Ok');
//    }
}
exit('Error: unknown');
