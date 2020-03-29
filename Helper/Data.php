<?php

namespace Cap\GmailSmtp\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * System path configuration
     */
    const CONFIG_HOST = 'cap_gmailsmtp/settings/host';
    const CONFIG_PORT = 'cap_gmailsmtp/settings/port';
    const CONFIG_AUTH = 'cap_gmailsmtp/settings/auth';
    const CONFIG_SSL = 'cap_gmailsmtp/settings/ssl';
    const CONFIG_USERNAME = 'cap_gmailsmtp/settings/username';
    const CONFIG_PASSWORD = 'cap_gmailsmtp/settings/password';

    /**
     * @var EncryptorInterface
     */
    protected $encryptor;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        Context $context,
        EncryptorInterface $encryptor
    ) {
        $this->encryptor = $encryptor;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getConfigHost()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_HOST, $storeScope);
    }

    /**
     * @return mixed
     */
    public function getConfigPort()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_PORT, $storeScope);
    }

    /**
     * @return mixed
     */
    public function getConfigAuth()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_AUTH, $storeScope);
    }

    /**
     * @return mixed
     */
    public function getConfigSsl()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_SSL, $storeScope);
    }

    /**
     * @return mixed
     */
    public function getConfigUsername()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_USERNAME, $storeScope);
    }

    /**
     * @return mixed
     */
    public function getConfigPassword()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        $password = $this->scopeConfig->getValue(self::CONFIG_PASSWORD, $storeScope);
        return $this->encryptor->decrypt($password);
    }
}
