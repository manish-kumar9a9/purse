<?php
namespace Zr\Checkavailibilty\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\Storage\WriterInterface;

/**
 * Class Data
 * @package Zr\Checkavailibilty\Helper
 */

class Data extends AbstractHelper
{
    /**
     *
     */
    const CONFIG_POSTCODES = 'checkavailability/config/postcodes';
    /**
     *
     */
    const CONFIG_SUCCESS_MESSAGE = 'checkavailability/config/success_message';
    /**
     *
     */
    const CONFIG_ERROR_MESSAGE = 'checkavailability/config/error_message';
     /**
     *
     */
    /**
     * @var ScopeConfig
     */
     
    protected $_configWriter;  

    /**
     * Data constructor.
     * @param Context $context
     * @param ScopeConfig $scopeConfig
     */
    public function __construct(
        Context $context,
        WriterInterface $configWriter) {
        parent::__construct($context);
        $this->_configWriter = $configWriter;
        $this->scopeConfig = $context->getScopeConfig();
    }

    /**
     * @param $storePath
     * @return mixed
     */
    public function setConfigData()
    {
        return $this->_configWriter->save('carriers/freeshipping/active',1);
    }
    public function resetConfigData()
    {
        return $this->_configWriter->save('carriers/freeshipping/active',0);
    }
    public function setCashConfigData()
    {
        return $this->_configWriter->save('payment/cashondelivery/active',1);
    }
     public function resetCashConfigData()
    {
        return $this->_configWriter->save('payment/cashondelivery/active',0);
    }
    /**
     * @return string
     */
    public function getStoreConfig($storePath)
    {
        return $this->scopeConfig->getValue($storePath,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getPostcodes()
    {
        return trim(self::getStoreConfig(self::CONFIG_POSTCODES));
    }

    /**
     * @return mixed
     */
    public function getSuccessMessage()
    {
        return self::getStoreConfig(self::CONFIG_SUCCESS_MESSAGE);
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return self::getStoreConfig(self::CONFIG_ERROR_MESSAGE);
    }
}