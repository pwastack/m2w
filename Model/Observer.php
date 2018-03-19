<?php

namespace M2Dev\Wp\Model;

use M2Dev\Wp\Helper\Data;
use M2Dev\Wp\Model\CategoryFactory;
use Magento\Catalog\Model\Category;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

class Observer implements ObserverInterface
{

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    protected $_registry;

    protected $_request;

    protected $_categories;


    protected $_helper;

    /**
     * @param Registry $registry
     * @param Resource\Category $categoryResource
     * @param StoreManagerInterface $storeManager
    */
    public function __construct(
        Registry $registry,
        CategoryFactory $category,
        StoreManagerInterface $storeManager,
        Http $request,
        Data $helper
    ) {
        $this->_registry = $registry;
        $this->_storeManager = $storeManager;
        $this->_categories = $category;
        $this->_request = $request;
        $this->_helper = $helper;
    }

    /**
    * /**
     * Adds catalog categories to top menu
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {

        $request_uri =  $this->_request->getUriString();

        /* @var $categories \M2Dev\Wp\Model\Resource\Category\Collection */
        $categories =  $this->_categories->create()->getCollection()->getCategoryList();

        if (strpos($request_uri,$this->_helper->getBlogUrl()) === 0)
        {
            $is_active = true;
        } else {
            $is_active = false;
        }

        $block = $observer->getEvent()->getBlock();
        $block->addIdentity(Category::CACHE_TAG);

        $newsNode = [
            'name' => $this->_helper->getWordpressModuleName(),
            'id' => 'top-menu-news',
            'url' => $this->_helper->getBlogUrl(),
            'has_active' => false,
            'is_active' => $is_active,
        ];

        $newsNode = $this->addNode($observer->getMenu(),$newsNode);

        $this->_addCategoriesToMenu($categories, $newsNode, $block,true);
    }

    /**
     * Recursively adds categories to top menu
     *
     * @param \Magento\Framework\Data\Tree\Node\Collection|array $categories
     * @param Node $parentCategoryNode
     * @param \Magento\Theme\Block\Html\Topmenu $block
     * @return void
     */
    protected function _addCategoriesToMenu($categories, $parentCategoryNode, $block,$first_level = false)
    {
        foreach ($categories as $category) {

            $block->addIdentity('wordpress_category_cache_tag' . '_' . $category['id']);

            $categoryData = $this->getMenuCategoryData($category);
            if ($first_level)
            {
                $categoryData['url'] = $parentCategoryNode->getData('url').'/category/'.$categoryData['url'];
            } else {
                $categoryData['url'] = $parentCategoryNode->getData('url') . '/' . $categoryData['url'];
            }

            $categoryNode = $this->addNode($parentCategoryNode,$categoryData);

            $sub_cat = $this->_categories->create()->getCollection()->getCategoryList($category->getId());

            $this->_addCategoriesToMenu($sub_cat, $categoryNode, $block);
        }
    }

    public function addNode($parentNode,$nodeData)
    {
        $tree = $parentNode->getTree();
        $categoryNode = new Node($nodeData, 'id', $tree, $parentNode);
        $parentNode->addChild($categoryNode);
        return $categoryNode;

    }

    /**
     * Get category data to be added to the Menu
     *
     * @param Node $category
     * @return array
     */
    public function getMenuCategoryData($category)
    {
        $nodeId = 'news-cat-node-' . $category->getId();

        $categoryData = [
            'name' => $category->getName(),
            'id' => $nodeId,
            'url' => $category->getSlug(),
            'has_active' => false,
            'is_active' => false,
        ];

        return $categoryData;
    }


}
