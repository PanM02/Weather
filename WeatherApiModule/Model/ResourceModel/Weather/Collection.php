<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Model\ResourceModel\Weather;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Orba\WeatherApiModule\Model\Weather;
use Orba\WeatherApiModule\Model\ResourceModel\Weather as WeatherResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    protected function _construct(): void
    {
        $this->_init(Weather::class, WeatherResourceModel::class);
    }
}
