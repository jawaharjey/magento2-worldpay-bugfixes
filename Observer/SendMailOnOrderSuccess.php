<?php

namespace Worldpay\Payments\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Model\Order\Email\Sender\OrderSender;
use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\LocalizedException;

class SendMailOnOrderSuccess implements ObserverInterface
{
    protected $orderModel;

    protected $orderSender;

    protected $checkoutSession;

    protected $logger;

    public function __construct(OrderFactory $orderModel, OrderSender $orderSender, Session $checkoutSession, \Worldpay\Payments\Logger\Logger $wpLogger
    )
    {
        $this->orderModel = $orderModel;
        $this->orderSender = $orderSender;
        $this->checkoutSession = $checkoutSession;
        $this->logger = $wpLogger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder()->save();
        $payment = $order->getPayment()->getMethodInstance()->getCode();
        //$this->logger->debug('Save Order Observer - '. $payment);
        try {
            if ($payment == 'worldpay_payments_card') {
                $this->orderSender->send($order);
            }
        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }
    }
}
