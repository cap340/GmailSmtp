<?php

namespace Cap\GmailSmtp\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class AuthType implements ArrayInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'none', 'label' => __('None')],
            ['value' => 'ssl', 'label' => 'SSL'],
            ['value' => 'tls', 'label' => 'TLS']
        ];
    }
}
