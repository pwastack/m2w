<?php
namespace M2Dev\Wp\Controller\Index;

use M2Dev\Wp\Helper\Data;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;


class Index extends Action
{

    /**
     * @var \M2Dev\Wp\Helper\Init
     */
    protected $_helper;

    /**
     * @param Context $context
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        Data $helper
    ) {
        parent::__construct($context);
        $this->_helper = $helper;
    }

    /**
     * Show Hello World page
     *
     * @return void
     */
    public function execute()
    {


        $wordpress_query = $this->_helper->initWordPress();
        $this->_view->loadLayout();



        /* @var $breadcrums \Magento\Theme\Block\Html\Breadcrumbs */
        $breadcrums = $this->_view->getLayout()->getBlock('breadcrumbs');
        $breadcrums->addCrumb('home',
            [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link' => '/'
            ]);

        $breadcrums->addCrumb('news',
            [
                'label' => __('News'),
                 'title' => __("News"),
                 'link' => $this->_helper->getBlogUrl()
            ]);

        $this->_view->getPage()->getConfig()->getTitle()->set($wordpress_query->getTitle());
        $this->_view->addPageLayoutHandles(['my_wp_view_post']);
        $this->_view->renderLayout();

    }
}
