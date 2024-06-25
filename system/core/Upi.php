<?php
namespace Shibaji\Core;

class UPIPaymentLinkGenerator
{
    /**
     * Generates a UPI payment link.
     *
     * @param string $serviceProvider The UPI service provider (e.g., googlepay, phonepe, paytm).
     * @param array $params Associative array of parameters for the payment link.
     * @return string|null Returns the generated UPI payment link, or null if parameters are invalid.
     */
    public static function generatePaymentLink($serviceProvider, $params)
    {
        switch (strtolower($serviceProvider)) {
            case 'googlepay':
                return self::generateGooglePayLink($params);
            case 'phonepe':
                return self::generatePhonePeLink($params);
            case 'paytm':
                return self::generatePaytmLink($params);
            default:
                return null;
        }
    }

    /**
     * Generates a Google Pay UPI payment link.
     *
     * @param array $params Associative array of parameters for the payment link.
     * @return string|null Returns the generated Google Pay UPI payment link, or null if parameters are invalid.
     */
    private static function generateGooglePayLink($params)
    {
        // Example URL structure for Google Pay UPI payment
        $baseURL = 'https://pay.google.com/gp/v/gpa';

        // Validate and construct parameters
        if (!isset($params['upi_id'], $params['amount'])) {
            return null;
        }

        $upiId = urlencode($params['upi_id']);
        $amount = urlencode($params['amount']);
        $description = isset($params['description']) ? urlencode($params['description']) : '';

        // Construct the payment link
        $paymentLink = "{$baseURL}?upi={$upiId}&amt={$amount}&cu=INR&tn={$description}";

        return $paymentLink;
    }

    /**
     * Generates a PhonePe UPI payment link.
     *
     * @param array $params Associative array of parameters for the payment link.
     * @return string|null Returns the generated PhonePe UPI payment link, or null if parameters are invalid.
     */
    private static function generatePhonePeLink($params)
    {
        // Example URL structure for PhonePe UPI payment
        $baseURL = 'https://phon.pe/';

        // Validate and construct parameters
        if (!isset($params['phone_number'], $params['amount'])) {
            return null;
        }

        $phoneNumber = urlencode($params['phone_number']);
        $amount = urlencode($params['amount']);
        $description = isset($params['description']) ? urlencode($params['description']) : '';

        // Construct the payment link
        $paymentLink = "{$baseURL}?payee={$phoneNumber}&amount={$amount}&description={$description}";

        return $paymentLink;
    }

    /**
     * Generates a Paytm UPI payment link.
     *
     * @param array $params Associative array of parameters for the payment link.
     * @return string|null Returns the generated Paytm UPI payment link, or null if parameters are invalid.
     */
    private static function generatePaytmLink($params)
    {
        // Example URL structure for Paytm UPI payment
        $baseURL = 'https://paytm.com/upi/payment';

        // Validate and construct parameters
        if (!isset($params['upi_id'], $params['amount'])) {
            return null;
        }

        $upiId = urlencode($params['upi_id']);
        $amount = urlencode($params['amount']);
        $description = isset($params['description']) ? urlencode($params['description']) : '';

        // Construct the payment link
        $paymentLink = "{$baseURL}?src=upi&pn={$upiId}&am={$amount}&cu=INR&tn={$description}";

        return $paymentLink;
    }
}