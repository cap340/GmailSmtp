<?php

namespace Cap\GmailSmtp\Model;

use Cap\GmailSmtp\Helper\Data;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\TransportInterface;

class Transport extends \Zend_Mail_Transport_Smtp implements TransportInterface
{
    /**
     * @var MessageInterface|\Zend_Mail
     */
    protected $messageInterface;

    /**
     * Transport constructor.
     *
     * @param MessageInterface $messageInterface
     * @param Data $helper
     */
    public function __construct(
        MessageInterface $messageInterface,
        Data $helper
    ) {
        if (!$messageInterface instanceof \Zend_Mail) {
            throw new \InvalidArgumentException('Message should be an instance of \Zend_Mail');
        }
        $smtpHost = $helper->getConfigHost();
        $smtpConf = [
            'auth' => strtolower($helper->getConfigAuth()),
            'ssl' => $helper->getConfigSsl(),
            'port' => $helper->getConfigPort(),
            'username' => $helper->getConfigUsername(),
            'password' => $helper->getConfigPassword()
        ];
        parent::__construct($smtpHost, $smtpConf);
        $this->messageInterface = $messageInterface;
    }

    /**
     * @throws MailException
     */
    public function sendMessage()
    {
        try {
            parent::send($this->messageInterface);
        } catch (\Exception $e) {
            throw new MailException(new \Magento\Framework\Phrase($e->getMessage()), $e);
        }
    }
}
