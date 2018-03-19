<?php
/**
 * Created by PhpStorm.
 * User: letuan
 * Date: 4/22/15
 * Time: 2:48 PM
 */

namespace M2Dev\Wp\Helper;

use M2Dev\Wp\Model\Wordpress;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

  /**
   *
   * @var Wordpress
   */
    protected $wordpress = false;

    public function __construct(
        Wordpress $wordpress,
        Context $context
    )
    {
        $this->wordpress = $wordpress;

        parent::__construct($context);
    }


    public function getBlogUrl()
    {
        return $this->_urlBuilder->getUrl('news');
    }

    public function getWordpressModuleName()
    {
        return $this->scopeConfig->getValue('m2dev_wp/general/blog_name', ScopeInterface::SCOPE_STORE);
    }

    public function addCategoryToTopMenu()
    {
        return $this->scopeConfig->getValue('m2dev_wp/general/topmenu', ScopeInterface::SCOPE_STORE);
    }

    public function getWordpressFolder()
    {
        return $this->scopeConfig->getValue('m2dev_wp/general/wordpress_folder', ScopeInterface::SCOPE_STORE);
    }

    public function initWordPress()
    {
        global $in_wordpress;

        $in_wordpress = true;

        define('WP_HOME',$this->_getUrl('*'));

        define('WP_USE_THEMES', true);
        define('TEMPLATEPATH', BP.$this->getWordpressFolder().'/wp-content/themes/magento');
        define('STYLESHEETPATH',BP.$this->getWordpressFolder().'/wp-content/themes/magento');

        require_once(BP.$this->getWordpressFolder()."/wp-load.php");

        wp();

        //$this->wordpress->setData();



        $this->wordpress->setTitle(wp_title('-', $display = false, $seplocation = 'right'));


        $in_wordpress = false;

        return $this->wordpress;
    }

    /**
    *
    * @var Wordpress
    */
    public function test()
    {
        return $this->wordpress;
    }




}
