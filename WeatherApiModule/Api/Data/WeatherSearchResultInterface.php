<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\WeatherApiModule\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface WeatherSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Orba\WeatherApiModule\Api\Data\WeatherInterface[]
     */
    public function getItems();

    /**
     * @param \Orba\WeatherApiModule\Api\Data\WeatherInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
