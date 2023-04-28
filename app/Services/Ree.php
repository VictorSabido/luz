<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Ree
{
    protected $apiKey;
    protected $locale = 'es';
    protected $url = 'https://api.esios.ree.es/archives/70/download_json';

    public function __construct()
    {
        $this->apiKey = $this->getApiKey();
    }

    protected function getApiKey()
    {
        return config('api.ree.api_key');
    }

    public function getPriceByDate($date)
    {
        Log::info('API CALLED: Getting price for ' . $date . ' from REE');

        return Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get($this->url, [
            'locale' => $this->locale,
            'date' => $date,
        ])->json();
    }
}
