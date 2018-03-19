<?php
namespace M2Dev\Wp\Model\Resource;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Visitor log resource
 */
class Category extends AbstractDb
{


    /**
     * Define main table
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('wp_terms', 'term_id');
    }




}
