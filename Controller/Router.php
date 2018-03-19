<?php

namespace M2Dev\Wp\Controller;
use M2Dev\Wp\Helper\Data;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Route\Config;


class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * @var Data
     */
    protected $helper;

    protected $routeConfig;

    /**
     * @param ActionFactory $actionFactory
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\UrlInterface $url
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
        ActionFactory $actionFactory,
        Data $helper,
        Config $routeConfig
    ) {
        $this->actionFactory = $actionFactory;
        $this->helper = $helper;

        $this->routeConfig = $routeConfig;

    }

    /**
     * Validate and Match Cms Page and modify request
     *
     * @param RequestInterface $request
     * @return bool
     */
    public function match(RequestInterface $request)
    {
        /* @var $request \Magento\Framework\App\Request\Http */
        if (strpos($request->getUriString(),$this->helper->getBlogUrl()) !== 0)
        {
            return null;
        }

        $request->setControllerModule('blog')->setControllerName('index')->setActionName('index');

        return $this->actionFactory->create(
            Forward::class,
            ['request' => $request]
        );
    }
}
