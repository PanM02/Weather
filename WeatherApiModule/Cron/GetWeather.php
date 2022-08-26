<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Cron;

use Orba\WeatherApiModule\Action\GetWeatherApiResponse;
use Orba\WeatherApiModule\Api\WeatherRepositoryInterface;
use Orba\WeatherApiModule\Model\WeatherFactory;
use Psr\Log\LoggerInterface;

class GetWeather
{
    private GetWeatherApiResponse $getWeather;
    private WeatherRepositoryInterface $weatherRepository;
    private WeatherFactory $weatherFactory;

    public function __construct(
        GetWeatherApiResponse $getWeather,
        WeatherRepositoryInterface $weatherRepository,
        WeatherFactory $weatherFactory,
        LoggerInterface $logger
    ) {
        $this->getWeather = $getWeather;
        $this->weatherRepository = $weatherRepository;
        $this->weatherFactory = $weatherFactory;
        $this->logger=$logger;
    }

    public function execute(): void
    {
        $result = $this->getWeather->execute();
        if ($result['status'] === 200) {
            try {
                $weather = $this->weatherFactory->create();
                $weather->setCondition($result['current']['condition']['text']);
                $weather->setDate((new \DateTime())->format('Y-m-d H:i:s'));
                $weather->setTemperature((int)$result['current']['temp_c']);
                $this->weatherRepository->save($weather);
            } catch (\Exception $exception){
                $this->logger->info($exception->getMessage());

            }
        }
    }
}
