<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\WeatherApiModule\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Orba\WeatherApiModule\Api\Data\WeatherInterface;
use Orba\WeatherApiModule\Api\Data\WeatherSearchResultInterface;

interface WeatherRepositoryInterface
{
    /**
     * @param int $id
     * @return \Orba\WeatherApiModule\Api\Data\WeatherInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): WeatherInterface;

    /**
     * @param \Orba\WeatherApiModule\Api\Data\WeatherInterface
     * @return void
     */
    public function save(WeatherInterface $Weather): void;

    /**
     * @param \Orba\WeatherApiModule\Api\Data\WeatherInterface
     * @return void
     */
    public function delete(WeatherInterface $Weather): void;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Orba\WeatherApiModule\Api\Data\WeatherSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): WeatherSearchResultInterface;
}
