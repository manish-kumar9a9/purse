<?php
namespace Zr\Checkavailibilty\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Model\Product;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            Product::ENTITY,
            'check_delivery_enable',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Enable Availability Check',
                'group' => 'general',
                'input' => 'select',
                'class' => '',
                'source' =>'\Magento\Catalog\Model\Product\Attribute\Source\Status',
                'global' => Attribute::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => 'simple,configurable,bundle,grouped',
				'note'		=> 'Display check delivery availability on product detail page.'
            ]
        );
        $eavSetup->addAttribute(
            Product::ENTITY,
            'check_shipping_available',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Enable Shipping Availability Check',
                'group' => 'general',
                'input' => 'select',
                'class' => '',
                'source' =>'\Magento\Catalog\Model\Product\Attribute\Source\Status',
                'global' => Attribute::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => false,
                'filterable' => true,
                'comparable' => true,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => 'simple,configurable,bundle,grouped',
                'note'      => 'Shipping availability check on product detail page.'
            ]
        );
        $eavSetup->addAttribute(
            Product::ENTITY,
            'check_cod_available',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Enable Cash on delivery Availability Check',
                'group' => 'general',
                'input' => 'select',
                'class' => '',
                'source' =>'\Magento\Catalog\Model\Product\Attribute\Source\Status',
                'global' => Attribute::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => false,
                'filterable' => true,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => 'simple,configurable,bundle,grouped',
                'note'      => 'Display check delivery availability on product detail page.'
            ]
        );
        

        $eavSetup->addAttribute(
            Product::ENTITY,
            'check_delivery_postcodes',
            [
                'type' => 'text',
                'backend' => '',
                'frontend' => '',
                'label' => 'Enter Delivery Postcodes',
                'group' => 'general',
                'input' => 'textarea',
                'class' => '',
                'source' => '',
                'global' => Attribute::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => false,
                'unique' => false,
                'apply_to' => 'simple,configurable,bundle,grouped',
				'note'		=> "Enter postcode's for this product in which you want to make shipping & cod availability."
            ]
        );
    }
}