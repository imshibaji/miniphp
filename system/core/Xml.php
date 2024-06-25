<?php
namespace Shibaji\Core;

class Xml
{
    private $xml;

    /**
     * XmlManager constructor.
     */
    public function __construct()
    {
        $this->xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root></root>');
    }

    /**
     * Load XML from string.
     *
     * @param string $xmlString The XML string to load.
     * @return bool True if XML loaded successfully, false otherwise.
     */
    public function loadFromString($xmlString)
    {
        try {
            $this->xml = new \SimpleXMLElement($xmlString);
            return true;
        } catch (\Exception $e) {
            echo "Error loading XML from string: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Load XML from file.
     *
     * @param string $filename The filename of the XML file to load.
     * @return bool True if XML loaded successfully, false otherwise.
     */
    public function loadFromFile($filename)
    {
        try {
            $this->xml = simplexml_load_file($filename);
            if ($this->xml === false) {
                throw new \Exception("Failed to load XML from file: $filename");
            }
            return true;
        } catch (\Exception $e) {
            echo "Error loading XML from file: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Convert array to XML and append to current XML structure.
     *
     * @param array $data The array data to convert into XML.
     * @param string $elementName The XML element name to append.
     */
    public function arrayToXml(array $data, $elementName)
    {
        $element = $this->xml->addChild($elementName);
        self::arrayToXmlRecursive($data, $element);
    }

    /**
     * Convert XML to array.
     *
     * @return array The XML data as an associative array.
     */
    public function xmlToArray()
    {
        return self::xmlToArrayRecursive($this->xml);
    }

    /**
     * Convert JSON to XML and append to current XML structure.
     *
     * @param string $jsonString The JSON string to convert into XML.
     * @param string $elementName The XML element name to append.
     * @return bool True on success, false on failure.
     */
    public function jsonToXml($jsonString, $elementName)
    {
        try {
            $data = json_decode($jsonString, true);
            if ($data === null) {
                throw new \Exception("Invalid JSON string provided.");
            }

            $this->arrayToXml($data, $elementName);
            return true;
        } catch (\Exception $e) {
            echo "Error converting JSON to XML: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Convert XML to JSON.
     *
     * @return string|false The XML data as JSON string, or false on failure.
     */
    public function xmlToJson()
    {
        try {
            $jsonString = json_encode($this->xml);
            if ($jsonString === false) {
                throw new \Exception("Error converting XML to JSON.");
            }
            return $jsonString;
        } catch (\Exception $e) {
            echo "Error converting XML to JSON: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Save XML to file.
     *
     * @param string $filename The filename to save the XML to.
     * @return bool True if XML saved successfully, false otherwise.
     */
    public function saveToFile($filename)
    {
        try {
            return $this->xml->asXML($filename) !== false;
        } catch (\Exception $e) {
            echo "Error saving XML to file: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Helper function to recursively convert array to XML.
     *
     * @param array $data The array data to convert.
     * @param \SimpleXMLElement $xmlElement The XML element to attach data to.
     */
    private static function arrayToXmlRecursive(array $data, \SimpleXMLElement &$xmlElement)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xmlElement->addChild("$key");
                    self::arrayToXmlRecursive($value, $subnode);
                } else {
                    self::arrayToXmlRecursive($value, $xmlElement);
                }
            } else {
                $xmlElement->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

    /**
     * Helper function to recursively convert XML to array.
     *
     * @param \SimpleXMLElement $xml The SimpleXMLElement object to convert.
     * @return array The XML data as an associative array.
     */
    private static function xmlToArrayRecursive(\SimpleXMLElement $xml)
    {
        $array = (array) $xml;
        foreach ($array as $key => $value) {
            if (is_object($value) && get_class($value) === 'SimpleXMLElement') {
                $array[$key] = self::xmlToArrayRecursive($value);
            }
        }
        return $array;
    }
}