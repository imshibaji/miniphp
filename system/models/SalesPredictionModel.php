<?php

namespace Shibaji\Models;

class SalesPredictionModel
{
    private $coefficients;

    /**
     * Constructor to initialize the model coefficients.
     */
    public function __construct($intercept = 50, $adSpendCoeff = 3.5)
    {
        $this->coefficients = [
            'intercept' => $intercept,
            'ad_spend_coeff' => $adSpendCoeff,
        ];
    }
    /**
     * Predicts sales based on advertising spending.
     *
     * @param float $adSpend The amount spent on advertising.
     * @return float The predicted sales.
     */
    public function predictSales($adSpend)
    {
        // Simple linear regression equation: sales = intercept + ad_spend * ad_spend_coeff
        $intercept = $this->coefficients['intercept'];
        $adSpendCoeff = $this->coefficients['ad_spend_coeff'];
        
        return $intercept + $adSpend * $adSpendCoeff;
    }
}