<?php

namespace Database\Seeders;

use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{

    const API_URL = 'https://wolf-amazon-data-scraper.p.rapidapi.com/search/watch?api_key=';
    private $api_key;
    private $product_queryword;

    function __construct()
    {
        $this->api_key = env('RAPID_API_KEY');
        $this->product_queryword = env('RAPID_API_QUERYWORD');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //  First, we check we have all the data we need for the process
        if (is_null($this->api_key)) {
            throw new \Exception('RAPID_API_KEY property missing in .env file');
        }

        if (is_null($this->product_queryword)) {
            throw new \Exception('RAPID_API_QUERYWORD property missing in .env file');
        }

        //  Now, we fetch data from an auxiliary API
        $apiClient = new Client();
        $rawResponse = $apiClient->request('get', self::API_URL . $this->api_key,
            [
                'headers' => [
                    'x-rapidapi-host' => 'wolf-amazon-data-scraper.p.rapidapi.com',
                    'x-rapidapi-key' => 'd7770ba819msh48152a7b1a808c8p1afe63jsnab3211079163'
                ]
            ]
        );

        //  If we get a failed response, we don't do anything
        if ($rawResponse->getStatusCode() != 200) {
            throw new \Exception('API response error. Code: ' . $rawResponse->getStatusCode());
        }
        $parsedRepsonse = json_decode($rawResponse->getBody());

        //  Then, we start to inflate the db table with that data
        foreach ($parsedRepsonse->results as $apiProduct) {
            if (!is_null($apiProduct->price)) {
                try {
                    DB::table('product')->insert([
                        'title'     => substr($apiProduct->name, 0, 255),
                        'image_url' => $apiProduct->image,
                        'price'     => $apiProduct->price,
                    ]);
                } catch (\Exception $e) {
                    echo "There has been a problem trying to add a product to the table.\n
                    PRODUCT: {$apiProduct->name}\n
                    ERROR: {$e->getMessage()}\n\n";

                }
            }
        }
    }
}
