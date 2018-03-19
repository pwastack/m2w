<?php
namespace M2Dev\Wp\Block;

class HEAD extends \Magento\Framework\View\Element\Template
{

    protected $_postFactory;



    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \M2Dev\Wp\Model\PostFactory $postFactory,
        array $data = []
    ) {

        parent::__construct($context, $data);
        $this->_postFactory = $postFactory;

    }

    /**
     * Retrieve Page instance
     *
     * @return \Magento\Cms\Model\Page
     */
    public function getPosts()
    {
       $posts = $this->_postFactory->create()->getCollection();
        $posts->addFilter('post_status', 'publish');
        $posts->addFilter('post_type','post');

        return $posts;

    }


}