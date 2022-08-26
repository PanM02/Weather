<?php

namespace Orba\WeatherApiModule\Action;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\ZendClient;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request\Deserializer\Json;
use Psr\Log\LoggerInterface;

class GetWeatherApiResponse
{
    private ScopeConfigInterface $scopeConfig;
    private ZendClient $client;
    private Json $json;
    private LoggerInterface $logger;


    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ZendClient $client,
        Json $json,
        LoggerInterface $logger,
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->client = $client;
        $this->json = $json;
        $this->logger=$logger;
    }

    public function execute(): array
    {
        if ((int) $this->scopeConfig->getValue('web/weather_api/enabled') === 1) {
            if ($this->scopeConfig->getValue('web/weather_api/key') !== '' &&
                $this->scopeConfig->getValue('web/weather_api/uri') !== ''
            ) {
                $this->client->setParameterGet(
                    'key',
                    $this->scopeConfig->getValue('web/weather_api/key')
                );
                $this->client->setParameterGet('q', 'Warsaw');
                try {
                    $this->client->setUri($this->scopeConfig->getValue('web/weather_api/uri'));
                } catch (\Zend_Http_Client_Exception $e) {
                    $this->logger->info($e->getMessage());
                }
                $response = [];
                try {
                    $response = $this->json->deserialize($this->client->request()->getBody());

                } catch (Exception $e) {
                    $this->logger->info($e->getMessage());
                }
                $response['status'] = $this->client->request()->getStatus();
                return $response;
            }
            $response['status'] = 403;
            return $response;
        }
        return [
            'status' => 404,
            'enabled' => $this->scopeConfig->getValue('web/weather_api/enabled')
        ];
    }
}
