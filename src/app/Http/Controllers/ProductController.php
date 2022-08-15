<?php

namespace App\Http\Controllers;

use App\Connection\MakeUpClient;
use App\Helpers\OriginCurrencyMoney;
use Exception;
use Illuminate\Support\Collection;

class ProductController extends Controller
{

    /**
     * @var MakeUpClient
    */
    protected $client;

    /**
     * @var OriginCurrencyMoney
    */
    protected $currencyMoney;

    /**
     * @param MakeUpClient $client
     * @param OriginCurrencyMoney $currencyMoney
     * @return void
     */
    public function __construct(MakeUpClient $client, OriginCurrencyMoney $currencyMoney)
    {
        $this->client = $client;
        $this->currencyMoney = $currencyMoney;
    }

    /**
     * @param string $type
     * @param string $category
     * @return Collection
    */
    public function searchProducts(string $type = '', string $category = ''): Collection
    {
        $payload = [
            'query' => [
                'product_type' => $type,
                'product_category' => $category
            ]
        ];

        return $this->getProducts($payload);
    }

    /**
     * @param string $brand
     * @return Collection
    */
    public function searchProductByBrand(string $brand = ''): Collection
    {
        $payload = [
            'query' => [
                'brand' => $brand,
            ]
        ];

        $products = $this->getProducts($payload);

        return collect()
            ->merge($products->where('price', $products->min('price'))->values())
            ->merge($products->where('price', $products->max('price'))->values());
    }

    /**
     * @param mixed[] $payload
     * @return Collection
    */
    private function getProducts(array $payload): Collection
    {
        try {
            $localMoney = $this->currencyMoney->convertMoney();

            $products = $this->sendRequest('GET', $payload);
        }catch(Exception $e) {
            return collect([
                'error' => $e->getMessage()
            ]);
        }

        return $products->map(function($value) use ($localMoney){
            return [
                'Name' => $value['name'],
                'Description' => $value['description'],
                'price' => $value['price'],
                'BRL' => 'R$ ' . number_format($localMoney * $value['price'], 2, ',', '')
            ];
        });
    }

    /**
     * @param string $method
     * @param mixed[] $params
     * @param string $url
     * @return Collection
    */
    private function sendRequest(string $method, array $params, string $url = ''): Collection
    {
        $responseData = json_decode($this->client->request($method, $url, $params)
            ->getBody()
            ->getContents(), true);

        return collect($responseData);
    }
}
