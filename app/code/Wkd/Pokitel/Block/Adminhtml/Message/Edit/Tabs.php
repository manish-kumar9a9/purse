<?php
namespace Wkd\Pokitel\Block\Adminhtml\Message\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_message_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Message Information'));
    }
}