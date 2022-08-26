<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Model;

use Magento\Framework\Api\SearchResults;
use Orba\WeatherApiModule\Api\Data\WeatherSearchResultInterface;

class WeatherSearchResult extends SearchResults implements WeatherSearchResultInterface
{

}
