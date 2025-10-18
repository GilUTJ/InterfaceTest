<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ConfigService
{
    protected $configUrl;

    public function __construct()
    {
        $this->configUrl = rtrim(env('API_BASE_URL'), '/') . '/';
    }

    public function headers(){
        return [
            'Acept' => 'aplication/json',
            'Content-Type' => 'aplication/json',
            'Ambu-Public-Key' => env('API_PUBLIC_KEY'),
            'Ambu-Private-Key' => env('API_PRIVATE_KEY'),
        ];
    }

    //funcion para autenticar la API externa y obtener configuraciones
    public function fetchConfigurations()
    {
        $response = Http::withHeaders($this->headers())
            ->get($this->configUrl . 'configurations');

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to fetch configurations: ' . $response->body());
    }

    public function createPark($data){
        $response = Http::withHeaders($this->headers())
        ->post($this->configUrl . 'parks',$data);

        if ($response->successful()) {
            return $response->json();
        }
        throw new \Exception('Failed to create park: ' . $response->body());
    }

    public function getParks(){
        $response = Http::withHeaders($this->headers())
        ->get($this->configUrl . 'parks');

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to fetch parks: ' . $response->body());
    }

}
