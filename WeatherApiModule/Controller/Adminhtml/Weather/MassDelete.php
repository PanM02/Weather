<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Controller\Adminhtml\Weather;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Orba\WeatherApiModule\Model\ResourceModel\Weather\Collection;

class MassDelete extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Orba_WeatherApiModule::weather';

    private Filter $filter;
    private Collection $objectCollection;

    public function __construct(Context $context, Filter $filter, Collection $objectCollection)
    {
        $this->filter = $filter;
        $this->objectCollection = $objectCollection;
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        $collection = $this->filter->getCollection($this->objectCollection);
        $collectionSize = $collection->getSize();
        $collection->walk('delete');

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
