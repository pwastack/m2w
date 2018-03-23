<?php

namespace M2Dev\Wp\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Post extends \Magento\Framework\Model\AbstractModel
{


   
    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Object initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('M2Dev\Wp\Model\Resource\Post');
    }

    public function checkIdentifier($identifier)
    {
        $collection = $this->getCollection()->addFilter('post_name',$identifier);
        $collection->load();
        if ($collection->count() > 0)
        {
            return $collection->getFirstItem()->getId();
        }

        return false;

    }






}
