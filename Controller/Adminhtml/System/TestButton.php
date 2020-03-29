<?php

namespace Cap\GmailSmtp\Controller\Adminhtml\System;

use Cap\GmailSmtp\Helper\Data;
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
     * @var Data
     */
    protected $helper;

    /**
     * TestButton constructor.
     *
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param Data $helper
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Data $helper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     * @throws \Zend_Validate_Exception
     * @throws \Zend_Mail_Exception
     */
    public function execute()
    {
        $request = $this->getRequest();
        $name = 'Cap Gmail SMTP Test Email';
        $username = $request->getPost('username');
        $password = $request->getPost('password');
        $auth = strtolower($request->getPost('auth'));
        if (!$request->getParam('store', false)) {
            if ($auth != 'none' && (empty($username) || empty($password))) {
                $this->getResponse()->setBody(__('Please enter a valid username/password'));
                return;
            }
        }
        //decrypted password
        $password = $this->helper->getConfigPassword();

        $to = $request->getPost('email') ? $request->getPost('email') : $username;
        $smtpHost = $request->getPost('host');
        $smtpConf = [
            'name' => $request->getPost('name'),
            'port' => $request->getPost('port')
        ];
        if ($auth != 'none') {
            $smtpConf['auth'] = $auth;
            $smtpConf['username'] = $username;
            $smtpConf['password'] = $password;

        }
        $ssl = $request->getPost('ssl');
        if ($ssl != 'none') {
            $smtpConf['ssl'] = $ssl;
        }
        $transport = new \Zend_Mail_Transport_Smtp($smtpHost, $smtpConf);
        $from = trim($request->getPost('from_email'));
        $from = \Zend_Validate::is($from, 'EmailAddress') ? $from : $username;

        $mail = new \Zend_Mail();
        $mail->setFrom($from, $name);
        $mail->addTo($to, $to);
        $mail->setSubject('Hello from Cap Gmail SMTP');
        $mail->setBodyHtml('Test mail.');

        $result = __('Sent... Please check your email') . ' ' . $to;
        try {
            if (!$mail->send($transport) instanceof \Zend_Mail) {
            }
        } catch (\Exception $e) {
            $result = __($e->getMessage());
        }

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
