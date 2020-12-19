<?php
/** @var modX $modx */
switch ($modx->event->name) {

    case 'msOnBeforeCreateOrder':
        $payment = $msOrder->Payment;
        if ($payment->get('class') === 'PrivateParts') {
            $countParts = $modx->getOption('mspPrivateParts_count', $_POST, $modx->getOption('msppp_min_parts'));
            $props = $msOrder->get('properties');
            $props['msppp'] = ['countParts' => $countParts];
            $msOrder->set('properties', $props);
        }
}