<?php

namespace Cap\GmailSmtp\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Button;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;

class TestButton extends Field
{
    /**
     * TestButton constructor.
     *
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        $this->_urlBuilder = $context->getUrlBuilder();
        parent::__construct($context, $data);
    }

    /**
     * Generate button html
     *
     * @return string
     * @throws LocalizedException
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock(
            Button::class
        )->setData(
            [
                'id' => 'cap_gmailsmtp_debug_result_button',
                'label' => __('Send Test Email'),
                'onclick' => 'javascript:gmailSmtpAppDebugTest(); return false;',
            ]
        );

        return $button->toHtml();
    }

    /**
     * @return string
     */
    public function getAdminUrl()
    {
        return $this->_urlBuilder->getUrl(
            'gmailsmtp/system/testButton',
            ['store' => $this->_request->getParam('store')]
        );
    }

    /**
     * Render button
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Set template
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('Cap_GmailSmtp::system/config/testbutton.phtml');
    }

    /**
     * Return element html
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }
}
