<?php

namespace Wkd\Pokitel\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SalesShipmentAfterSave implements ObserverInterface {

  /**
   * @var \Magento\Framework\ObjectManagerInterface
   */
  protected $_objectManager;

  /**
   * Order Model
   *
   * @var \Magento\Sales\Model\Order $order
   */
  protected $order;

  /**
   * @var \Magento\Sales\Model\OrderFactory
   */
  protected $orderModel;

  /**
   * @var \Wkd\Pokitel\Helper\Data
   */
  protected $_helper;

  /**
  * @param \Magento\Framework\ObjectManagerInterface $objectmanager
  * @param \Magento\Sales\Model\OrderFactory $orderModel
  * @param \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender
  * @param \Magento\Checkout\Model\Session $checkoutSession
  * @param \Wkd\Pokitel\Helper\Data $helper
  */
  public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Magento\Sales\Model\Order $order,
        \Magento\Sales\Model\OrderFactory $orderModel,
        \Wkd\Pokitel\Helper\Data $helper
  ){
        $this->_objectManager = $objectmanager;
        $this->_helper = $helper;
        $this->order = $order;
        $this->orderModel = $orderModel;
  }

  /**
   * @param \Magento\Framework\Event\Observer $observer
   */
  public function execute(\Magento\Framework\Event\Observer $observer){

    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/wkd.log');
    $logger = new \Zend\Log\Logger();
    $logger->addWriter($writer);
    $logger->info('Sales Shipment After Save');

    $order = $observer->getEvent()->getOrder();
    //$logger->info('Order Data::' . json_encode($order->getData()));

    $shipment = $observer->getEvent()->getShipment();
  //  $logger->info('Shipment data::'. json_encode((array)$shipment ));
    $logger->info('Shipment order state::' . json_encode($shipment->getData()));
    $logger->info('Shipment track::' . json_encode((array)$shipment->getTracks()));
    //$logger->info('Shipment order state::' . $shipment->getData());

    $mobileNo = '+918802045390';
    $msg = 'Test SMS 1';
    $this->_helper->sendMessage( $mobileNo, $msg );
    // if ($order instanceof \Magento\Framework\Model\AbstractModel) {
    //    if($order->getState() == 'canceled' || $order->getState() == 'closed') {
    //         //Your code here
    //    }
    // }

    return $this;
  }

}
