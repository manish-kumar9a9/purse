<?php
/**
 * Copyright © 2015 Wkd . All rights reserved.
 */
namespace Wkd\Pokitel\Helper;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

	/**
   * @param \Magento\Framework\App\Helper\Context $context
   */
	public function __construct(
      \Magento\Framework\App\Helper\Context $context
	) {
		  parent::__construct($context);
	}

  /**
   * send Message
   */

   public function sendMessage( $mobileNo, $msg ){
       $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/sms.log');
       $logger = new \Zend\Log\Logger();
       $logger->addWriter($writer);
       $logger->info('checkout Success helper');

       $user = 'SACHIN';
       $key = '96f84f2a28XX';
       $senderId = 'abcdef';


       try{
            $xml_data ='<?xml version="1.0"?>
            <parent>
            <child>
            <user>'. $user .'</user>
            <key>'. $key .'</key>
            <mobile>'. $mobileNo .'</mobile>
            <message>'. $msg .'</message>
            <accusage>2</accusage>
            <senderid>'. $senderId .'</senderid>
            </child>
            </parent>';

          $URL = "http://103.233.79.246/submitsms.jsp?";

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
