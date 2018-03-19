<?php
namespace M2Dev\Wp\Block;

use M2Dev\Wp\Model\PostFactory;
use Magento\Framework\View\Element\Template;

class Listing extends Template
{

    protected $_postFactory;


    /**
     * @param Template\Context $context
     * @param PostFactory $postFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PostFactory $postFactory,
        array $data = []
    ) {

        parent::__construct($context, $data);
        $this->_postFactory = $postFactory;
    }

    /**
     * Retrieve Page instance
     *
     * @return \M2Dev\Wp\Model\Resource\Post\Collection
     */
    public function getPosts()
    {

        $posts = $this->_postFactory->create()->getCollection();
        $posts->addFilter('post_status', 'publish');
        $posts->addFilter('post_type','post');

        return $posts;

    }




}