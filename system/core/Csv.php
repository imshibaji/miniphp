<?php
namespace Shibaji\Core;

class Csv
{
    /**
     * Generates a CSV file from data array.
     *
     * @param string $filename The name of the CSV file to generate.
     * @param array $data The data to write into the CSV file. Each element should be an associative array representing a row.
     * @param array $headers Optional headers for the CSV file.
     * @return bool True on success, false on failure.
     */
    public static function generate($filename, $data, $headers = [])
    {
        try {
            $file = fopen($filename, 'w');

            // Write headers
            if (!empty($headers)) {
                fputcsv($file, $headers);
            }

            // Write data rows
            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
            return true;
        } catch (\Exception $e) {
            echo "Error generating CSV: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Reads a CSV file and returns the data as an array.
     *
     * @param string $filename The name of the CSV file to read.
     * @param bool $hasHeaders Whether the CSV file has headers (default true).
     * @param string $delimiter The delimiter used in the CSV file (default is ',').
     * @return array|false An array of CSV data or false on failure.
     */
    public static function read($filename, $hasHeaders = true, $delimiter = ',')
    {
        try {
            $file = fopen($filename, 'r');
            if (!$file) {
                throw new \Exception("Unable to open file: $filename");
            }

            $data = [];
            $firstRow = true;

            while (($row = fgetcsv($file, 0, $delimiter)) !== false) {
                if ($hasHeaders && $firstRow) {
                    $headers = $row;
                    $firstRow = false;
                    continue;
                }
                $data[] = $row;
            }

            fclose($file);

            if ($hasHeaders && isset($headers)) {
                array_unshift($data, $headers);
            }

            return $data;
        } catch (\Exception $e) {
            echo "Error reading CSV: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Pushes data from an array to the CSV file.
     *
     * @param string $filename The name of the CSV file to push data into.
     * @param array $dataArray The data to push to the CSV file. Each element should be an associative array representing a row.
     * @param array $headers Optional headers for the CSV file.
     * @return bool True on success, false on failure.
     */
    public static function pushFromArray($filename, $dataArray, $headers = [])
    {
        try {
            $file = fopen($filename, 'a');

            // Write headers if provided and file is empty
            if (!empty($headers) && filesize($filename) === 0) {
                fputcsv($file, $headers);
            }

            // Write data rows
            foreach ($dataArray as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
            return true;
        } catch (\Exception $e) {
            echo "Error pushing to CSV: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Pushes data from JSON to the CSV file.
     *
     * @param string $filename The name of the CSV file to push data into.
     * @param string $jsonString The JSON string containing data to push.
     * @param array $headers Optional headers for the CSV file.
     * @return bool True on success, false on failure.
     */
    public static function pushFromJSON($filename, $jsonString, $headers = [])
    {
        try {
            $dataArray = json_decode($jsonString, true);
            if ($dataArray === null) {
                throw new \Exception("Invalid JSON format.");
            }

            return self::pushFromArray($filename, $dataArray, $headers);
        } catch (\Exception $e) {
            echo "Error pushing JSON to CSV: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Retrieves data from the CSV file as an array.
     *
     * @param string $filename The name of the CSV file to read.
     * @param bool $hasHeaders Whether the CSV file has headers (default true).
     * @param string $delimiter The delimiter used in the CSV file (default is ',').
     * @return array|false An array of CSV data or false on failure.
     */
    public static function getAsArray($filename, $hasHeaders = true, $delimiter = ',')
    {
        return self::read($filename, $hasHeaders, $delimiter);
    }

    /**
     * Retrieves data from the CSV file as a JSON string.
     *
     * @param string $filename The name of the CSV file to read.
     * @param bool $hasHeaders Whether the CSV file has headers (default true).
     * @param string $delimiter The delimiter used in the CSV file (default is ',').
     * @return string|false A JSON string of CSV data or false on failure.
     */
    public static function getAsJSON($filename, $hasHeaders = true, $delimiter = ',')
    {
        $dataArray = self::read($filename, $hasHeaders, $delimiter);
        if ($dataArray === false) {
            return false;
        }

        return json_encode($dataArray);
    }
}
