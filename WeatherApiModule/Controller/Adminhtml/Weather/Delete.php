<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Controller\Adminhtml\Weather;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Psr\Log\LoggerInterface;
use Orba\WeatherApiModule\Model\WeatherFactory;

class Delete extends Action implements HttpGetActionInterface
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
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id', null);

        try {
            $objectInstance = $this->objectFactory->create()->load($id);
            if ($objectInstance->getId()) {
                $objectInstance->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the record.'));
            } else {
                $this->messageManager->addErrorMessage(__('Record does not exist.'));
            }
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $this->logger->info($exception->getMessage());
        }

        return $resultRedirect->setPath('*/*');
    }
}
