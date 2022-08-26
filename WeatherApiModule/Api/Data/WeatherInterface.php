<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\WeatherApiModule\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface WeatherInterface extends ExtensibleDataInterface
{
    const ID = 'entity_id';
    const CONDITION = 'condition';
    const DATE = 'date';
    const TEMPERATURE = 'temperature';

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @param int $value
     * @return void
     */
    public function setId($value);

    /**
     * @return string|null
     */
    public function getCondition(): ?string;

    /**
     * @param string $value
     * @return void
     */
    public function setCondition(string $value): void;

    /**
     * @return string|null
     */
    public function getDate(): ?string;

    /**
     * @param string $value
     * @return void
     */
    public function setDate(string $value): void;

    /**
     * @return int|null
     */
    public function getTemperature(): ?int;

    /**
     * @param int $value
     * @return void
     */
    public function setTemperature(int $value): void;
}
