<?php
namespace Wkd\Pokitel\Block\Adminhtml;
class Message extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_message';/*block grid.php directory*/
        $this->_blockGroup = 'Wkd_Pokitel';
        $this->_headerText = __('Message');
        $this->_addButtonLabel = __('Add New Entry'); 
        parent::_construct();
		
    }
}
