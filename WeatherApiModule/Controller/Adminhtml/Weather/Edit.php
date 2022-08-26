<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Controller\Adminhtml\Weather;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Orba\WeatherApiModule\Model\WeatherFactory;
use Magento\Backend\Model\View\Result\Page;

class Edit extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Orba_WeatherApiModule::weather';

    private Registry $registry;
    private PageFactory $resultPageFactory;
    private WeatherFactory $objectFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        WeatherFactory $objectFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $objectInstance = $this->objectFactory->create();

        if ($id) {
            $objectInstance->load($id);
            if (!$objectInstance->getId()) {
                $this->messageManager->addErrorMessage(__('This record no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $objectInstance->addData($data);
        }

        $this->registry->register('entity_id', $id);

        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Orba_WeatherApiModule::weather');
        $resultPage->getConfig()->getTitle()->prepend(__('Weather Edit'));

        return $resultPage;
    }
}
