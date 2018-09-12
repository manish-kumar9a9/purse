<?php

namespace Wkd\Pokitel\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Ordersms implements ObserverInterface {

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

    /** * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderModel;
    /**
    * @var \Magento\Checkout\Model\Session $checkoutSession
    */
   protected $checkoutSession;

    /**
    * @param \Magento\Framework\ObjectManagerInterface $objectmanager
    * @param \Magento\Sales\Model\OrderFactory $orderModel
    * @param \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender
    * @param \Magento\Checkout\Model\Session $checkoutSession
    */
    public function __construct(
          \Magento\Framework\ObjectManagerInterface $objectmanager,
          \Magento\Sales\Model\Order $order,
          \Magento\Sales\Model\OrderFactory $orderModel,
          \Magento\Checkout\Model\Session $checkoutSession
    ){
          $this->_objectManager = $objectmanager;
          $this->order = $order;
          $this->orderModel = $orderModel;
          $this->checkoutSession = $checkoutSession;
    }
    public function execute(\Magento\Framework\Event\Observer $observer) {

          $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/sms.log');
      		$logger = new \Zend\Log\Logger();
      		$logger->addWriter($writer);
          $logger->info('checkout Success Observer');

          $event = $observer->getEvent();
  		    $order = $observer->getEvent()->getOrder();
          $orderids = $observer->getEvent()->getOrderIds();
          $logger->info('Order Ids: '.json_encode($orderids));

          foreach($orderids as $orderid){

              $logger->info('Current Order: '.$orderid);
              $order = $this->order->load($orderid);
              $incrementId = $order->getIncrementId();
              $price = $order-> getGrandTotal();

              $phone = $order->getBillingAddress()->getTelephone();

              //$logger->info(json_encode($event->toArray()));
              $logger->info('Order Data: '.json_encode($order->getData()));
              $logger->info('phone number: '.$phone);

              $mobileNo = '+91'.$phone;;//'+918802045390';
              
              $proName = '';
              foreach ($order->getAllVisibleItems() as $item) {
              	$logger->info('Name of products: '.$proName);
		$proName = ($proName ? $proName.', '.$item->getName() : $item->getName());
	      }
	      
	      $logger->info('Name of products: '.$proName);
              $msg = 'Order Placed: Your order for '.$proName.' with ID '.$incrementId.' amounting to RS. '.$price.' has been received.';
              $this->sendMessage( $mobileNo, $msg);
          }

    }
    /**
     * send Message
     */

     public function sendMessage( $mobileNo, $msg ){
         $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/sms.log');
         $logger = new \Zend\Log\Logger();
         $logger->addWriter($writer);
         $logger->info('checkout Success Observer');

         // $user = 'SACHIN';
         // $key = '96f84f2a28XX';
         // $senderId = 'abcdef';

         $user = 'MANDEE';
         $key = '7aff18b7c0XX';
         $senderId = 'INFOSM';


         try{
              $xml_data ='<?xml version="1.0"?>
              <parent>
              <child>
              <user>'. $user .'</user>
              <key>'. $key .'</key>
              <mobile>'. $mobileNo .'</mobile>
              <message>'. $msg .'</message>
              <accusage>1</accusage>
              <senderid>'. $senderId .'</senderid>
              </child>
              </parent>';
              $logger->info(' MESSSGE TO BE SENT:');
              $logger->info($xml_data);
            //$URL = "http://103.233.79.246/submitsms.jsp?";
            $URL = "http://sms.webkidukan.com/submitsms.jsp?";

             $ch = curl_init($URL);
             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
             curl_setopt($ch, CURLOPT_POST, 1);
             curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
             curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
             curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             $output = curl_exec($ch);
             curl_close($ch);

             $logger->info('SEND MESSSGE CURL RES');
             $logger->info(print_r($output, true));

         }catch( Exception $e){
           $logger->info('SEND MESSSGE ERROR');
           $logger->info($e);

         }
     }

}
