<?php
namespace Contact\Us\Controller\Index;
use Contact\Us\Helper\Sender;
class Post extends \Magento\Framework\App\Action\Action
{
    /**
    * @var \Magento\Framework\App\Config\ScopeConfigInterface
    */
    protected $scopeConfig;

    /**
    * @var \Contact\Us\Helper\Post
    */
    protected $_senderHelper;
    /**
    * @param \Magento\Framework\App\Action\Context $context
    * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Sender $senderHelper
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->_senderHelper = $senderHelper;
    }

    /**
    * Post user question
    *
    * @return void
    * @throws \Exception
    */
    public function execute()
    {        

        $post = $this->getRequest()->getPostValue();
        if (!$post) {
            $this->_redirect('/');
            return;
        }
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $recipientMail = $this->getRequest()->getPostValue('email');
        $adminRecipientMail = $this->scopeConfig->getValue('trans_email/ident_support/email',$storeScope);
        $this->_senderHelper->sendMail('3', $adminRecipientMail, $adminRecipientMail, $post);
        $this->_senderHelper->sendMail('2', $recipientMail, $adminRecipientMail, $post);
        $this->_redirect('/');
    }
}
