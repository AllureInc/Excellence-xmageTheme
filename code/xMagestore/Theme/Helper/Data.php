<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace xMagestore\Theme\Helper;

use Magento\Framework\Registry;

use Magento\Cms\Model\BlockFactory;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /* @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var \Magento\Framework\App\Helper\Context
     */
    protected $_context;
    
    /**
     * @var \Magento\Framework\App\Helper\Context
     */
    protected $_registry;


    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param Magento\Framework\Registry $registry
     * 
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Registry $registry
    ){
        $this->_storeManager = $storeManager;
        $this->_registry = $registry;
        parent::__construct($context);
    }

    public function getCurrentProduct(){
        $currentProduct = $this->_registry->registry('current_product'); 
        return $currentProduct;
    }
    public function getMediaUrl(){
        $mediaUrl = $this->getCurrentStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }
    public function getCurrentStore(){
        return $this->_storeManager->getStore();
    }
    public function getCurrentCategory(){
        $category = $this->_registry->registry('current_category');

        return $category->getId();
    }
}  