<?php
declare(strict_types=1);

namespace Etechflow\MetaTemplates\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private LicenseValidator $licenseValidator
    ) {
    }

    /**
     * Master switch. Returns false when the licence is invalid OR the admin
     * "Enable" flag is off. The licence check runs FIRST so an unlicensed
     * install silently no-ops on the storefront (MetaResolver bails on false).
     */
    public function isEnabled($storeId = null): bool
    {
        if (!$this->licenseValidator->isValid()) {
            return false;
        }
        return $this->scopeConfig->isSetFlag('etechflow_metatemplates/general/enabled', ScopeInterface::SCOPE_STORE, $storeId);
    }

    /** override = always apply; otherwise only fill empty entity meta. */
    public function isOverride($storeId = null): bool
    {
        return (string)$this->scopeConfig->getValue('etechflow_metatemplates/general/mode', ScopeInterface::SCOPE_STORE, $storeId) === 'override';
    }
}
