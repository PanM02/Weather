<?php declare(strict_types=1);

namespace Orba\WeatherApiModule\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Orba\WeatherApiModule\Api\Data\WeatherInterface;
use Orba\WeatherApiModule\Api\WeatherRepositoryInterface;

class Weather implements SectionSourceInterface
{
    private WeatherRepositoryInterface $weatherRepository;
    private SearchCriteriaBuilder $criteriaBuilder;
    private SortOrderBuilder $sortOrderBuilder;

    public function __construct(
        WeatherRepositoryInterface $weatherRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->weatherRepository = $weatherRepository;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @throws NoSuchEntityException
     * @throws InputException
     */
    public function getSectionData(): array
    {
        $result = $this->getWeatherData();
        if($result === null) {
            return [];
        }
        return [
            'condition' => $result->getCondition(),
            'temperature' => $result->getTemperature()."°C",
            'date' => $result->getDate()
        ];
    }

    /**
     * @throws InputException
     */
    private function getWeatherData(): ?WeatherInterface
    {
        $this->sortOrderBuilder->setField('date');
        $this->sortOrderBuilder->setDirection('DESC');
        $sortOrder = $this->sortOrderBuilder->create();
        $this->criteriaBuilder->addSortOrder($sortOrder);
        $criteria = $this->criteriaBuilder->create();
        $items = $this->weatherRepository->getList($criteria)->getItems();
        if (count($items) > 0) {
            return array_shift($items);
        }
        return null;
    }
}
