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
        $promise = $client->getAsync('https://api.stripe.com/v1/products?key=' . env('STRIPE_SECRET') . '&active=true');
        $response = $promise->wait();
        //dd(json_decode($response->getBody()->getContents(), true)['data']);
        $products = json_decode($response->getBody()->getContents(), true)['data'];
        foreach ($products as $product) {
            $promise = $client->getAsync('https://api.stripe.com/v1/prices/' . $product['default_price'] . '?key=' . env('STRIPE_SECRET'));
            $response = $promise->wait();
            $amount = json_decode($response->getBody()->getContents(), true)['unit_amount'];
            $data = [
                "prod_id" => $product['id'],
                "name" => $product['name'],
                "slug" => Str::slug($product['name']),
                "price_id" => $product['default_price'],
                "price" => $amount / 100
            ];

            $new_product = Product::create($data);
        }
    }
}
