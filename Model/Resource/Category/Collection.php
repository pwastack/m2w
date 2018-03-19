<?php
namespace M2Dev\Wp\Model\Resource\Category;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{
    protected $joined_taxonomy = false;

    /**
     * Collection resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('M2Dev\Wp\Model\Category', 'M2Dev\Wp\Model\Resource\Category');
    }

    protected function joinTaxonomy()
    {
        $this->join('wp_term_taxonomy',"wp_term_taxonomy.term_id = main_table.term_id AND taxonomy = 'category'");
        $this->joined_taxonomy = true;
    }

    public function getCategoryList($parent = 0){
        if (!$this->joined_taxonomy)
        {
            $this->joinTaxonomy();
        }

        $this->addFieldToFilter('parent',array('eq' => $parent));
        $this->addFieldToFilter('count',array('gt' => 0));

        return $this;
    }

}
