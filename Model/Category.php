<?php
namespace M2Dev\Wp\Model;

use Magento\Framework\Data\Collection\ModelFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Category extends AbstractModel
{



    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        ModelFactory $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }


    protected function _construct()
    {
        $this->_init('M2Dev\Wp\Model\Resource\Category');
    }

}
