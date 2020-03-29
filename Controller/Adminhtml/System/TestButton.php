<?php

namespace Cap\GmailSmtp\Controller\Adminhtml\System;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class TestButton extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Cap_GmailSmtp::config';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * TestButton constructor.
     *
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $request = $this->getRequest();
        $name = 'Gmail SMTP Test';
        $username = $request->getPost('username');
        $password = $request->getPost('password');
        $auth = strtolower($request->getPost('auth'));
        if (!$request->getParam('store', false)) {
            if ($auth != 'none' && (empty($username) || empty($password))) {
                $this->getResponse()->setBody(__('Please enter a valid username/password'));
                return;
            }
        }
        $result = $username . $password . $auth;
        $this->getResponse()->setBody($this->makeClickableLinks($result));
    }

    /**
     * Make link clickable
     *
     * @param string $s
     * @return string
     */
    public function makeClickableLinks($s)
    {
        return preg_replace(
            '@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@',
            '<a href="$1" target="_blank">$1</a>',
            $s
        );
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }
}
