<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Cron;

use DateTime;
use Exception;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Orba\WeatherApiModule\Api\WeatherRepositoryInterface;

class DeleteObsoleteWeather
{
    private WeatherRepositoryInterface $weatherRepository;
    private SearchCriteriaBuilder $criteriaBuilder;

    public function __construct(
        WeatherRepositoryInterface $weatherRepository,
        SearchCriteriaBuilder $criteriaBuilder
    ) {
        $this->weatherRepository = $weatherRepository;
        $this->criteriaBuilder = $criteriaBuilder;
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        $weatherItems = $this->weatherRepository->getList($this->criteriaBuilder->create())->getItems();
        $currentDate = new DateTime();
        foreach ($weatherItems as $item) {
            $itemDate = new DateTime($item->getDate());
            $dateDiff = date_diff($currentDate, $itemDate);
            if ($dateDiff->days > 6) {
                $this->weatherRepository->delete($item);
            }
        }
    }
}
