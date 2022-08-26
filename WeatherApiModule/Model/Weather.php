<?php


namespace Orba\WeatherApiModule\Model;

use Magento\Framework\Model\AbstractModel;
use Orba\WeatherApiModule\Api\Data\WeatherInterface;
use Orba\WeatherApiModule\Model\ResourceModel\Weather as WeatherResourceModel;

class Weather extends AbstractModel implements WeatherInterface
{
    protected $_eventPrefix = 'orba_weather_api_module_weather';

    protected function _construct(): void
    {
        $this->_init(WeatherResourceModel::class);
    }

    public function getId(): ?int
    {
        return $this->_getData('entity_id');
    }

    public function setId($value)
    {
        $this->setData('entity_id', $value);
    }

    public function getCondition(): ?string
    {
        return $this->getData('condition');
    }

    public function setCondition(string $value): void
    {
        $this->setData('condition', $value);
    }

    public function getDate(): ?string
    {
        return $this->getData('date');
    }

    public function setDate(string $value): void
    {
        $this->setData('date', $value);
    }

    public function getTemperature(): ?int
    {
        return $this->getData('temperature');
    }

    public function setTemperature(int $value): void
    {
        $this->setData('temperature', $value);
    }
}
