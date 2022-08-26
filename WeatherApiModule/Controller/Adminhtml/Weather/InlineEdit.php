<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Controller\Adminhtml\Weather;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;
use Orba\WeatherApiModule\Api\WeatherRepositoryInterface;
use Orba\WeatherApiModule\Model\Weather;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Orba_WeatherApiModule::weather';

    private JsonFactory $jsonFactory;
    private WeatherRepositoryInterface $repository;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        WeatherRepositoryInterface $repository,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->repository = $repository;
        $this->logger=$logger;
    }

    public function execute(): Json
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        try {
            foreach (array_keys($postItems) as $weatherId) {
                /** @var Weather $weather */
                $weather = $this->repository->getById($weatherId);
                foreach ($postItems[$weatherId] as $key => $value) {
                    $weather->setData($key, $value);
                }
                $this->repository->save($weather);
            }
        } catch (Exception $e) {
            $messages[] = __('There was an error saving the data: ') . $e->getMessage();
            $error = true;
            $this->logger->info($e->getMessage());
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
