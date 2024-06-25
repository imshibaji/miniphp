<?php
namespace Shibaji\Core;

class LocationTracker
{
    /**
     * Get the geographical location based on IP address using an IP geolocation API.
     *
     * @param string $ip Optional IP address. If not provided, uses the user's IP address.
     * @return array|false An array with geographical information (latitude, longitude, city, country, etc.) on success, or false on failure.
     */
    public static function getGeoLocation($ip = null)
    {
        if (!$ip) {
            $ip = $_SERVER['REMOTE_ADDR']; // Get user's IP address
        }

        // Replace 'your_api_key' with your actual API key
        $apiUrl = "https://api.ipgeolocationapi.com/geolocate/$ip";
        $response = file_get_contents($apiUrl);

        if ($response) {
            $data = json_decode($response, true);

            // Example data structure returned by the API
            $location = [
                'latitude' => isset($data['latitude']) ? $data['latitude'] : null,
                'longitude' => isset($data['longitude']) ? $data['longitude'] : null,
                'city' => isset($data['city']) ? $data['city'] : null,
                'country' => isset($data['country_name']) ? $data['country_name'] : null,
                // Add more relevant fields as per API response
            ];

            return $location;
        } else {
            return false; // Failed to fetch geo location data
        }
    }
}