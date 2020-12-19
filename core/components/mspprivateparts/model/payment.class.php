<?php

if (!class_exists('msPaymentInterface')) {
    /** @noinspection PhpIncludeInspection */
    if (file_exists(dirname(dirname(dirname(__FILE__))) . '/minishop2/model/minishop2/mspaymenthandler.class.php')) {
        require_once dirname(dirname(dirname(__FILE__))) . '/minishop2/model/minishop2/mspaymenthandler.class.php';
    } elseif (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/minishop2/model/minishop2/mspaymenthandler.class.php')) {
        require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/minishop2/model/minishop2/mspaymenthandler.class.php';
    } elseif (file_exists(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/minishop2/model/minishop2/mspaymenthandler.class.php')) {
        require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/minishop2/model/minishop2/mspaymenthandler.class.php';
    }
}

class PrivateParts extends msPaymentHandler implements msPaymentInterface
{
    /** @var modX $modx */
    public $modx;
    /** @var array $config */
    public $config;
    /** @var mspPrivateParts */
    public $msppp;


    /**
     * @param xPDOObject $object
     * @param array $config
     */
    function __construct(xPDOObject $object, $config = [])
    {
        parent::__construct($object, $config);

        
        $this->config = array_merge([
            'paymentUrl' => MODX_ASSETS_URL . 'components/mspprivateparts/payment.php',
            'successId' => $this->modx->getOption('msppp_success_id', null, $this->modx->getOption('site_start'), true),
            'storeId' => $this->modx->getOption('msppp_store_id', null, ''),
            'password' => $this->modx->getOption('msppp_password', null, ''),
            'hold' => $this->modx->getOption('msppp_hold', null, false),
            'merchantType' => $this->modx->getOption('msppp_merchant_type', null, 'PP'),
            'recipientId' => $this->modx->getOption('msppp_recipient_id', null, ''),
            'urls' => [
                'create' => 'https://payparts2.privatbank.ua/ipp/v2/payment/create',
                'redirect' => 'https://payparts2.privatbank.ua/ipp/v2/payment?token=',
                'callback' => 'https://payparts2.privatbank.ua/ipp/v2/payment/callback',
                'confirm' => 'https://payparts2.privatbank.ua/ipp/v2/payment/confirm',
                'cancel' => 'https://payparts2.privatbank.ua/ipp/v2/payment/cancel'

            ]
        ], $config);

        if (!$this->msppp = $this->modx->getService('mspprivateparts', 'mspPrivateParts', $this->modx->getOption('mspprivateparts_core_path', null,
                $this->modx->getOption('core_path') . 'components/mspprivateparts/') . 'model/mspprivateparts/')
        ) {
            return 'Could not load mspPrivateParts class!';
        }
//        $this->modx->addPackage('mspprivateparts', MODX_CORE_PATH. 'components/mspprivateparts/model');
//        $this->modx->loadClass('mspPrivatePartsOrder', MODX_CORE_PATH. 'components/mspprivateparts/model/mspprivateparts');
    }


    /**
     * @param msOrder $order
     *
     * @return array|string
     */
    public function send(msOrder $order)
    {
        $response = $this->success('', [
            'redirect' => $this->getPaymentLink($order),
        ]);

        return $response;
    }


    /**
     * @param msOrder $order
     *
     * @return string
     */
    public function getPaymentLink(msOrder $order)
    {
        $payment = null;
        /** @var mspPrivatePartsOrder $record */
        $token = '';
        $record = $this->modx->getObject('mspPrivatePartsOrder', ['id' => $order->id]);
        if (!empty($record)) {
            $token = $record->get('token');
        } else {
            try {

                $orderId = $order->id . '_' . time();
                $props = $order->get('properties');
                $countParts = ($props['msppp'] && $props['msppp']['countParts']) ? $props['msppp']['countParts'] : $this->msppp->config['minParts'];
                $redirectUrl = $this->modx->makeUrl($this->config['successId'], $order->get('context'),
                    ['msorder' => $order->id], 'full');
                $responseUrl = rtrim($this->modx->getOption('site_url'), '/') . $this->config['paymentUrl'];
                $signatureSource = [
                    $this->config['password'],
                    $this->config['storeId'],
                    $orderId,
                    floor($order->get('cost') * 100),
                    $countParts,
                    $this->config['merchantType'],
                    $responseUrl,
                    $redirectUrl
                ];
                $signatureProducts = '';
                $products = [];

                foreach ($order->Products as $product) {
                    $products[] = [
                        'name' => $product->get('name'),
                        'price' => $product->get('price'),
                        'count' => $product->get('count')
                    ];
//                    $signatureProducts .= $product->get('name') . $product->get('count') . floor($product->get('price') * 100);
                    $signatureSource[] = $product->get('name');
                    $signatureSource[] = $product->get('count');
                    $signatureSource[] = floor($product->get('price') * 100);
                }
                $signatureSource[] = $this->config['password'];
//                $signatureSource .= $signatureProducts . $this->config['password'];

                $requestBody = [
                    'storeId' => $this->config['storeId'],
                    'orderId' => $orderId,
                    'amount' => $order->get('cost'),
                    'partsCount' => $countParts,
                    'merchantType' => $this->config['merchantType'],
                    'recipientId' => $this->config['recipientId'],
                    'responseUrl' => $responseUrl,
                    'redirectUrl' => $redirectUrl,
                    'products' => $products,
                    'signature' => $this->calcSignature($signatureSource)
//                    'signature' => base64_encode(sha1($signatureSource))
                ];
                $this->modx->log(1, 'GET PAYMENT LINK. REQUEST BODY' . print_r($requestBody, 1));

                $response = $this->sendPost($requestBody, $this->config['urls']['create']);
                $payment = $this->modx->fromJSON($response);
                $token = $payment['token'];
//                $this->modx->log(1, 'GET PAYMENT LINK. RESPONSE' . print_r($payment, 1) . ', TOKEN ' . $token);

                $record = $this->modx->newObject('mspPrivatePartsOrder');
                $record->set('id', $order->id);
                $record->set('order_id', $orderId);
                $record->set('token', $token);
                $record->save();

//                $this->modx->log(1, 'GET PAYMENT LINK. RECORD FIELDS' . print_r($record->toArray(), 1));
            } catch (Exception $e) {
                $this->modx->log(xPDO::LOG_LEVEL_ERROR, '[mspPrivateParts] Error on create payment with API: ' . $e->getMessage());
            }
        }

        $link = $this->config['urls']['redirect'] . $token;
//        $this->modx->log(1,  ' TOKEN ' . $token . ' LINK ' . $link);
        return $link;
    }


    /**
     * @param msOrder $order
     * @param int $status
     *
     * @return bool
     */
    public function receive(msOrder $order, $status = 2)
    {
        if ($order->get('status') == $status) {
            return true;
        }
        /* @var miniShop2 $miniShop2 */
        $miniShop2 = $this->modx->getService('miniShop2');
        $ctx = $order->get('context');
        if ($ctx != 'web') {
            $this->modx->switchContext($ctx);
        }

        return $miniShop2->changeOrderStatus($order->id, $status);
    }

    /**
     * Send POST
     *
     * @param $param
     * @param $url
     * @return mixed
     */
    private function sendPost($param, $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json; charset=utf-8'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));

        return curl_exec($ch);
    }

    /**
     * @param $array
     * @return string
     */
    private function calcSignature($array)
    {
        $signature = '';
        foreach ($array as $item) {
            $signature .= $item;
        }

//        $this->modx->log(1, 'CALC SIGN ' . $signature);
        return base64_encode(sha1($signature, true));

    }

}
