<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Controller\Adminhtml\Weather;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Orba\WeatherApiModule\Model\WeatherFactory;
use Psr\Log\LoggerInterface;

class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Orba_WeatherApiModule::weather';

    private WeatherFactory $objectFactory;

    public function __construct(
        Context $context,
        WeatherFactory $objectFactory,
        LoggerInterface $logger
    ) {
        $this->objectFactory = $objectFactory;
        $this->logger=$logger;
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        $data = $this->getRequest()->getParams();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $params = [];
            $objectInstance = $this->objectFactory->create();
            $idField = $objectInstance->getIdFieldName();
            if (empty($data[$idField])) {
                $data[$idField] = null;
            } else {
                $objectInstance->load($data[$idField]);
                $params[$idField] = $data[$idField];
            }
            $objectInstance->addData($data);

            $this->_eventManager->dispatch(
                'orba_weather_api_module_weather_prepare_save',
                ['object' => $this->objectFactory, 'request' => $this->getRequest()]
            );

            try {
                $objectInstance->save();
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params = [$idField => $objectInstance->getId(), '_current' => true];
                    return $resultRedirect->setPath('*/*/edit', $params);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->logger->info($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the record.'));

            }

            $this->_getSession()->setFormData($this->getRequest()->getPostValue());
            return $resultRedirect->setPath('*/*/edit', $params);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
