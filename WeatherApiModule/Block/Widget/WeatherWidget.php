<?php declare(strict_types=1);

namespace Orba\WeatherApiModule\Block\Widget;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Orba\WeatherApiModule\Api\WeatherRepositoryInterface;
use Orba\WeatherApiModule\Model\ResourceModel\Weather\CollectionFactory;
use Psr\Log\LoggerInterface;

class WeatherWidget extends Template implements BlockInterface
{
    protected $_template = "weather.phtml";

    public function __construct(
        Template\Context $context,
        WeatherRepositoryInterface $weatherRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        CollectionFactory $collectionFactory,
        LoggerInterface $logger,
        array $data = []
    ) {
        parent::__construct($context, $data);
        try {
                 $weather = $collectionFactory->create()->getLastItem();
                 $this->setData('text', $weather->getCondition());
                 $this->setData('temp', $weather->getTemperature());
        } catch (\Exception $e) {
                $logger->info($e->getMessage());
        }
    }
}
