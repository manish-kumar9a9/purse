<?php

 namespace Wkd\Pokitel\Model\Plugin\Checkout;
 class LayoutProcessor
 {
      /**
      * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
      * @param array $jsLayout
      * @return array
      */
      public function afterProcess(
          \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
          array  $jsLayout
      ) {

          $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/layout.log');
          $logger = new \Zend\Log\Logger();
          $logger->addWriter($writer);
          $logger->info("layout Processor");



        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['region_id']['sortOrder'] = 111;
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['region_id']['required'] = true;
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['region_id']['validation']['required-entry'] = true;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['region']['required'] = true;
       $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
       ['shippingAddress']['children']['shipping-address-fieldset']['children']['region']['sortOrder'] = 110;
       $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
       ['shippingAddress']['children']['shipping-address-fieldset']['children']['region']['validation']['required-entry'] = true;



        //company
        // $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        // ['shippingAddress']['children']['shipping-address-fieldset']['children']['company']['disabled'] = 'disabled';
        // $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        // ['shippingAddress']['children']['shipping-address-fieldset']['children']['company']['visible'] = false;

        unset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
                ['shippingAddress']['children']['shipping-address-fieldset']['children']['company']);
        //country
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['country_id']['visible'] = false;
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['country_id']['disabled'] = 'disabled';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['country_id']['value'] = 'IN';


        return $jsLayout;

      }
  }
