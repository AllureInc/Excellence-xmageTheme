<?php

namespace Excellence\Geoip\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
	/**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
	
    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Excellence_Geoip::geoip_manage');
    }

    /**
     * Geoip List action
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Excellence_Geoip::geoip_manage'
        )->addBreadcrumb(
            __('Geoip'),
            __('Geoip')
        )->addBreadcrumb(
            __('Manage Geoip'),
            __('Manage Geoip')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('GeoIP'));
        return $resultPage;
    }
}
