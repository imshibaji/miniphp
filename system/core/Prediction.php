<?php

namespace Shibaji\Core;

use Shibaji\Models\SalesPredictionModel;

class Prediction
{
    private $model;

    /**
     * Constructor to initialize the prediction model.
     */
    public function __construct()
    {
        $this->model = new SalesPredictionModel();
    }

    /**
     * Predicts sales based on advertising spending.
     *
     * @param array $inputData The input data with 'ad_spend' as the key.
     * @return float The predicted sales.
     * @throws \InvalidArgumentException If input data is invalid.
     */
    public function predict($inputData)
    {
        // Validate input data
        if (!$this->validateInput($inputData)) {
            throw new \InvalidArgumentException('Invalid input data.');
        }

        // Extract input feature
        $adSpend = $inputData['ad_spend'];

        // Make prediction using the model
        try {
            $predictedSales = $this->model->predictSales($adSpend);
            return $predictedSales;
        } catch (\Exception $e) {
            throw new \RuntimeException('Prediction error: ' . $e->getMessage());
        }
    }

    /**
     * Validate input data format (placeholder method).
     *
     * @param array $inputData The input data to validate.
     * @return bool True if input data is valid, false otherwise.
     */
    private function validateInput($inputData)
    {
        return isset($inputData['ad_spend']) && is_numeric($inputData['ad_spend']);
    }
}

/*
// Example usage:
$prediction = new Prediction();

// Example input data (replace with actual data)
$inputData = [
    'ad_spend' => 1000, // Example: $1000 spent on advertising
];

try {
    $predictedSales = $prediction->predict($inputData);
    echo "Predicted sales: $" . number_format($predictedSales, 2) . "\n";
} catch (\Exception $e) {
    echo "Prediction error: " . $e->getMessage() . "\n";
}
*/