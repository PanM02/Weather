<?php
declare(strict_types=1);

namespace Orba\WeatherApiModule\Ui\Component\Form\Weather;

use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Orba\WeatherApiModule\Model\ResourceModel\Weather\Collection;

class DataProvider extends AbstractDataProvider
{
    private FilterPool $filterPool;
    private array $loadedData = [];

    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        FilterPool $filterPool,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        $this->filterPool = $filterPool;
    }

    public function getData(): array
    {
        if (!$this->loadedData) {
            $items = $this->collection->getItems();
            foreach ($items as $item) {
                $this->loadedData[$item->getId()] = $item->getData();
                break;
            }
        }
        return $this->loadedData;
    }
}
