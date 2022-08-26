<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Model;

use Orba\WeatherApiModule\Api\WeatherRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Orba\WeatherApiModule\Api\Data\WeatherInterface;
use Orba\WeatherApiModule\Api\Data\WeatherSearchResultInterface;
use Orba\WeatherApiModule\Api\Data\WeatherSearchResultInterfaceFactory;
use Orba\WeatherApiModule\Model\ResourceModel\Weather\CollectionFactory as WeatherCollectionFactory;

class WeatherRepository implements WeatherRepositoryInterface
{
    private WeatherFactory $weatherFactory;
    private WeatherCollectionFactory $weatherCollectionFactory;
    private WeatherSearchResultInterfaceFactory $searchResultFactory;
    private CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        WeatherFactory $weatherFactory,
        WeatherCollectionFactory $weatherCollectionFactory,
        WeatherSearchResultInterfaceFactory $weatherSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->weatherFactory = $weatherFactory;
        $this->weatherCollectionFactory = $weatherCollectionFactory;
        $this->searchResultFactory = $weatherSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function getById(int $id): WeatherInterface
    {
        $weather = $this->weatherFactory->create();
        $weather->getResource()->load($weather, $id);
        if (!$weather->getId()) {
            throw new NoSuchEntityException(__('Unable to find Weather with ID "%1"', $id));
        }
        return $weather;
    }

    public function save(WeatherInterface $weather): void
    {
        /** @var $weather Weather **/
        $weather->getResource()->save($weather);
    }

    public function delete(WeatherInterface $weather): void
    {
        /** @var $weather Weather **/
        $weather->getResource()->delete($weather);
    }

    public function getList(SearchCriteriaInterface $searchCriteria): WeatherSearchResultInterface
    {
        $collection = $this->weatherCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }
}
