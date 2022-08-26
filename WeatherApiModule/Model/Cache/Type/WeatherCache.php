<?php

namespace Orba\WeatherApiModule\Model\Cache\Type;

use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\Cache\Frontend\Decorator\TagScope;

/**
 * System / Cache Management / Cache type "Your Cache Type Label"
 */
class WeatherCache extends TagScope
{
    /**
     * Cache type code unique among all cache types
     */
    const TYPE_IDENTIFIER = 'weather_cache';

    /**
     * The tag name that limits the cache cleaning scope within a particular tag
     */
    const CACHE_TAG = 'WEATHER_TYPE_CACHE';

    /**
     * @param FrontendPool $cacheFrontendPool
     */
    public function __construct(FrontendPool $cacheFrontendPool)
    {
        parent::__construct(
            $cacheFrontendPool->get(self::TYPE_IDENTIFIER),
            self::CACHE_TAG
        );
    }
}
