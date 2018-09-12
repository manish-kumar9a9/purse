<?php

namespace Zr\Checkavailibilty\Controller\Postcode;

use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\Product as ProductModel;
use Zr\Checkavailibilty\Helper\Data as DataHelper;
use Magento\Framework\App\Action\Action;

/**
 * Class Check
 * @package Zr\Checkavailibilty\Controller\Postcode
 */
class Check extends Action
{
    /**
     * @var ProductModel
     */
    protected $_productModel;
    /**
     * @var DataHelper
     */
    protected $_helper;

    /**
     * Check constructor.
     * @param Context $context
     * @param ProductModel $productModel
     * @param DataHelper $helper
     */
    public function __construct(
        Context $context,
        ProductModel $productModel,
        DataHelper $helper
    ) {
        parent::__construct($context);
        $this->_productModel = $productModel;
        $this->_helper = $helper;
    }

    /**
     *
     */
    public function execute()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/wkd.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('PINCODE Avalability');

        $response = [];
        try {
            if (!$this->getRequest()->isAjax()) {
                throw new \Exception('Invalid request.');
            }
            if (!$postcode = $this->getRequest()->getParam('postcode')) {
                throw new \Exception('Please enter postcode.');
            }

            $productId = $this->getRequest()->getParam('id', 0);
            $product = $this->_productModel->load($productId);

            if (!$product->getId()) {
                throw new \Exception('Product not found.');
            }
            $postcodes = trim($product->getCheckDeliveryPostcodes());
            if (!$postcodes) {
                //$postcodes = $this->_helper->getPostcodes();

                $url = "https://track.delhivery.com/c/api/pin-codes/json/?token=e3dba93f449a78be7bdf9e9eb7b3f65a6343109c&filter_codes=".$postcode;

                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                //curl_setopt($ch,CURLOPT_POST,true);
                //curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
                $output=curl_exec($ch);
                if($output === false)
                {
                  $response['type'] = 'error';
                  $response['message'] = curl_error($ch);
                }
                curl_close($ch);
                $resultData = json_decode($output, true);
                $logger->info(print_r($resultData, true));
                $logger->info(print_r($resultData['delivery_codes'], true));

                if( isset($resultData['error']) ){
                  $response['type'] = 'error';
                  $response['message'] = $this->_helper->getErrorMessage();
                }elseif( !empty($resultData['delivery_codes'])){
                  $logger->info('Available');
                  $response['type'] = 'success';
                  $response['message'] = $this->_helper->getSuccessMessage();
                }else{
                  $response['type'] = 'error';
                  $response['message'] = $this->_helper->getErrorMessage();
                }
            }
            // $postcodes = array_map('trim', explode(',', $postcodes));
            // if (in_array($postcode, $postcodes)) {
            //     $response['type'] = 'success';
            //     $response['message'] = $this->_helper->getSuccessMessage();
            // } else {
            //     $response['type'] = 'error';
            //     $response['message'] = $this->_helper->getErrorMessage();
            // }
        } catch (\Exception $e) {
            $response['type'] = 'error';
            $response['message'] = $e->getMessage();
        }
        $this->getResponse()->setContent(json_encode($response));
    }
    /**
     *
     */
    // public function execute()
    // {
    //
    //     $response = [];
    //     try {
    //         if (!$this->getRequest()->isAjax()) {
    //             throw new \Exception('Invalid request.');
    //         }
    //         if (!$postcode = $this->getRequest()->getParam('postcode')) {
    //             throw new \Exception('Please enter postcode.');
    //         }
    //
    //         $productId = $this->getRequest()->getParam('id', 0);
    //         $product = $this->_productModel->load($productId);
    //
    //         if (!$product->getId()) {
    //             throw new \Exception('Product not found.');
    //         }
    //         $postcodes = trim($product->getCheckDeliveryPostcodes());
    //         if (!$postcodes) {
    //             $postcodes = $this->_helper->getPostcodes();
    //         }
    //         $postcodes = array_map('trim', explode(',', $postcodes));
    //         if (in_array($postcode, $postcodes)) {
    //             $response['type'] = 'success';
    //             $response['message'] = $this->_helper->getSuccessMessage();
    //         } else {
    //             $response['type'] = 'error';
    //             $response['message'] = $this->_helper->getErrorMessage();
    //         }
    //     } catch (\Exception $e) {
    //         $response['type'] = 'error';
    //         $response['message'] = $e->getMessage();
    //     }
    //     $this->getResponse()->setContent(json_encode($response));
    // }

}
