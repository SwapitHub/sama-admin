<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductModel;
use App\Models\ProductPrice;
use App\Models\ProductPrecentageDiscount;
use GuzzleHttp\Client;

class FetchProductPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:product-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch prices for products';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
		$this->discount_amount = ProductPrecentageDiscount::first()['amount'];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Fetching product prices...');

        // Fetch products from the database
        ProductModel::chunk(100, function ($products) {
            foreach ($products as $product) {
                try {
                    $productData = [
                           'sku'=>$product['sku'],
                           'metalType'=>$product['metalType'],
                           'metalColor'=>$product['metalColor'],
                           'finishLevel'=>$product['finishLevel'],
                           'fractionsemimount'=>$product['fractionsemimount'],
                           'diamondQuality'=>$product['diamondQuality'],
                    ];
                    $price = $this->fetchPriceFromAPI($productData);
                    echo "<pre>";
                    var_dump($price);
                } catch (Exception $e) {
                    // Log any errors that occur during the process
                    Log::error('Error fetching price for product ' . $product->sku . ': ' . $e->getMessage());
                }
            }
        });

        $this->info('Product prices fetched successfully.');
    }

     // Method to fetch price from third-party API
     private function fetchPriceFromAPI($data)
     {
        $metalColors = ['White', 'Yellow', 'Pink'];
        $metalTypes = ['18kt', 'Platinum'];
        $diamondQualities = ['SI1, G', 'LAB GROWN VS-SI1, E/F/G'];

        

        if($data['finishLevel'] =='Semi-mount (no center)')
        {
            $data['finishLevel'] = 'Semi-mount';
        }
        else if($data['finishLevel'] =='Polished Blank (no stones)')
        {
            $data['finishLevel'] = 'Polished Blank (no stones)';
        }
       
        foreach ($metalTypes as $metalType) {
            foreach ($metalColors as $metalColor) {
                foreach ($diamondQualities as $diamondQuality) {
                    // Construct the URL with query parameters
                    $url = 'http://www.overnightmountings.com/priceapi/service.php?action=pricecalculation&type=json';
                    $url .= '&metaltype=' . urlencode($metalType);
                    $url .= '&metalcolor=' . urlencode($metalColor);
                    $url .= '&stylenumber=' . urlencode($data['sku']);
                    $url .= '&quality=' . urlencode($diamondQuality);
                    $url .= '&level=' . urlencode($data['finishLevel']);

                    // Make HTTP request using GuzzleHttp
                    $client = new Client();
                    $response = $client->request('GET', $url);

                    // Parse JSON response
                    $price_data = json_decode($response->getBody(), true);

                    // Extract relevant information from the response
                    $sku = $data['sku'];
                    $price = isset($price_data['price']) ? $price_data['price'] : null;
                    $finishLevel = $data['finishLevel'];
                    $type = $diamondQuality == 'SI1, G' ? 'natural' : 'lab_grown';

                    $stat = 'true';
                    // Insert or update data into the database
                    $insertorupdate = ProductPrice::updateOrCreate(
                        [
                            'product_sku' => $sku,
                            'metalColor' => $metalColor,
                            'metalType' => $metalType,
                            'diamond_type' => $type,
                            'diamondQuality' => $diamondQuality,
                            'finishLevel' => $finishLevel,
                        ],
                        [
                            'product_sku' => $sku,
                            'reference_price' => $price,
                            'discount_percentage' => $this->discount_amount,
                            'price' => $this->calculatePriceDiscount($price),
                            'metalColor' => $metalColor,
                            'metalType' => $metalType,
                            'diamond_type' => $type,
                            'diamondQuality' => $diamondQuality,
                            'finishLevel' => $finishLevel,
                       ]
                   );
                    if(!$insertorupdate)
                    {
                        $stat = 'false';
                    }
                }
            }
        }

        if($stat =='true')
        {
            return true;
        }else{
            return false;
        }


     }
	 
	 public function calculatePriceDiscount($price)
	 {
	     if($price != 0 || $price != null)
		 {
			 $discount_amount = $price * ($this->discount_amount / 100);	 
			 return $final_price = $price - $discount_amount; 
		 }
	
	 }
}
