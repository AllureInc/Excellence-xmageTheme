<?php 

namespace Contact\Us\Block;

use Magento\Framework\View\Element\Template;

class Contact  extends Template
{
	protected $_pageConfig;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\View\Page\Config $pageConfig
	)
	{
		$this->_pageConfig = $pageConfig;
		parent::__construct($context);
	}

	public function getQueryStringId()
	{
		return $this->getRequest()->getParam('id');
	}   

	public function _prepareLayout()
	{	
		// if($this->getQueryStringId()){
		// 	$this->_pageConfig->getTitle()->set(__('Contact Us'));
		// }else{
		// 	$this->_pageConfig->getTitle()->set(__('Hire Us'));
		// }
		// return parent::_prepareLayout();
	}  
}
?>