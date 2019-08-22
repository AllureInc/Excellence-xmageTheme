<?php

namespace Contact\Us\Helper;
// use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\Mail\Template\TransportBuilder;
use \Magento\Framework\Translate\Inline\StateInterface;
use \Magento\Store\Model\StoreManagerInterface;
use \Magento\Framework\Message\ManagerInterface;
use \Magento\Framework\App\Response\Http;


class Sender extends \Magento\Framework\App\Helper\AbstractHelper
{
	/**
    * @var \Magento\Framework\Mail\Template\TransportBuilder
    */
    protected $_transportBuilder;

    /**
    * @var \Magento\Framework\Translate\Inline\StateInterface
    */
    protected $inlineTranslation;

    /**
    * @var \Magento\Store\Model\StoreManagerInterface
    */
    protected $storeManager;

    /**
    * @var \Magento\Framework\Message\ManagerInterface
    */
    protected $_messageManager;

    protected $_redirect;
    
	public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager,
        ManagerInterface $messageManager,        
        Http $redirect
    ) {
    	parent::__construct($context);
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
        $this->messageManager = $messageManager;
        $this->_redirect = $redirect;
    }

    public function sendMail($templateId, $reciever, $adminRecipientMail, $post) {
    	$this->inlineTranslation->suspend();
    	try {
    		
            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($post);

            $error = false;

            $sender = [
                'name' => 'xMageStore',
                'email' => $adminRecipientMail
            ];

            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($templateId) //send_email_email_template this code we have mentioned in the email_templates.xml
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($sender)
                ->addTo($reciever)
                ->getTransport();

            $transport->sendMessage(); ;
            $this->inlineTranslation->resume();
            $this->messageManager->addSuccess(
            __('Thanks for contacting us. We\'ll respond to you very soon.')
            );
            return true;
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addError(
            __('We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage())
            );
            return false;
        }
    }
}