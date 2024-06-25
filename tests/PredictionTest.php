<?php
namespace Shibaji\Test;
use Shibaji\Models\SalesPredictionModel;

class PredictionTest{

    public function run(){
        // Instantiate SalesPredictionModel
        $model = new SalesPredictionModel(10, 3.5); // Example coefficients: intercept = 50, ad_spend_coeff = 3.5

        // Make predictions
        $adSpend = 1000; // Example: $1000 spent on advertising
        $predictedSales = $model->predictSales($adSpend);

        // Output the results
        echo "Predicted sales for \$1000 advertising spend: $" . number_format($predictedSales, 2) . "\n";
    }
}
?>
