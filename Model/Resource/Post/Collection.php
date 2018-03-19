<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace M2Dev\Wp\Model\Resource\Post;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Visitor log collection
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Collection extends AbstractCollection
{




    /**
     * Collection resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('M2Dev\Wp\Model\Post', 'M2Dev\Wp\Model\Resource\Post');


    }

}
