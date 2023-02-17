<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new Client();
        $promise = $client->getAsync('https://api.stripe.com/v1/products?key=sk_test_51MblMIKkM6iJJF7lt4Rj735GxhpzHl6va0mvNcmr9DoqTvCLJ2Md7Xcf12uqtStWMcKZjPBuP9Sj069zpiwt0uoI001oAud0He&active=true');
        $response = $promise->wait();
        //dd(json_decode($response->getBody()->getContents(), true)['data']);
        $products = json_decode($response->getBody()->getContents(), true)['data'];
        foreach ($products as $product) {
            $data = [
                "prod_id" => $product['id'],
                "name" => $product['name'],
                "slug" => Str::slug($product['name']),
                "price_id" => $product['default_price'],
            ];

            $new_product = Product::create($data);
        }
    }
}
