<?php
declare(strict_types=1);

namespace Etechflow\MetaTemplates\Controller\Adminhtml\Template;

use Etechflow\MetaTemplates\Model\LicenseValidator;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Etechflow_MetaTemplates::template';

    public function __construct(
        Context $context,
        private PageFactory $pageFactory,
        private LicenseValidator $licenseValidator
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        // Gate: an unlicensed module redirects to the licence/plans page.
        if (!$this->licenseValidator->isValid()) {
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
                ->setPath('metatemplates/license/gate');
        }

        $page = $this->pageFactory->create();
        $page->setActiveMenu('Etechflow_MetaTemplates::template');
        $page->getConfig()->getTitle()->prepend(__('Meta Templates'));
        return $page;
    }
}
