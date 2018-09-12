<?php
/**
 * Copyright © 2015 Wkd. All rights reserved.
 */
namespace Wkd\Pokitel\Model\ResourceModel;

/**
 * Message resource
 */
class Message extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('pokitel_message', 'id');
    }

  
}
