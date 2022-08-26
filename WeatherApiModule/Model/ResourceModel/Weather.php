<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Weather extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('orba_weather_api_module_weather', 'entity_id');
    }
}
