<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    private string $apiKey;
    private string $city;
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient, string $apiKey, string $city)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->city = $city;
    }

    public function getWeather(): ?array
    {
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/weather?q=%s&units=metric&lang=fr&appid=%s',
            $this->city,
            $this->apiKey
        );

        try {
            $response = $this->httpClient->request('GET', $url);
            return $response->toArray();
        } catch (\Exception $e) {
            return null;
        }
    }
}
