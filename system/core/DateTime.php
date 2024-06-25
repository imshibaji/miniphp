<?php
namespace Shibaji\Core;

class DateTime
{
    protected static $timezone = 'UTC'; // Default timezone

    /**
     * Set the global default timezone.
     *
     * @param string $timezone Timezone identifier, e.g., 'UTC', 'America/New_York'.
     */
    public static function setTimeZone($timezone)
    {
        self::$timezone = $timezone;
        date_default_timezone_set($timezone);
    }

    /**
     * Get the global default timezone.
     *
     * @return string Timezone identifier.
     */
    public static function getTimeZone()
    {
        return self::$timezone;
    }

    /**
     * Get current date and time formatted as per given format.
     *
     * @param string $format Date and time format (default is 'Y-m-d H:i:s').
     * @param string|null $timezone Optional timezone identifier.
     * @return string Formatted date and time string.
     */
    public static function now($format = 'Y-m-d H:i:s', $timezone = null)
    {
        $timezone = $timezone ?: self::$timezone;
        $dateTime = new \DateTime('now', new \DateTimeZone($timezone));
        return $dateTime->format($format);
    }

    /**
     * Convert a date string from one format to another.
     *
     * @param string $dateString Date string to convert.
     * @param string $currentFormat Current format of the date string.
     * @param string $targetFormat Target format for the date string.
     * @param string|null $timezone Optional timezone identifier.
     * @return string Converted date string in target format.
     */
    public static function convertFormat($dateString, $currentFormat, $targetFormat, $timezone = null)
    {
        $timezone = $timezone ?: self::$timezone;
        $dateTime = \DateTime::createFromFormat($currentFormat, $dateString, new \DateTimeZone($timezone));
        return $dateTime->format($targetFormat);
    }

    /**
     * Get the difference between two dates in a specified interval.
     *
     * @param string $start Start date string.
     * @param string $end End date string.
     * @param string $interval Interval specifier (e.g., 'days', 'hours').
     * @param string|null $timezone Optional timezone identifier.
     * @return int|false The difference in the specified interval, or false on failure.
     */
    public static function dateDiff($start, $end, $interval, $timezone = null)
    {
        $timezone = $timezone ?: self::$timezone;
        $startDateTime = new \DateTime($start, new \DateTimeZone($timezone));
        $endDateTime = new \DateTime($end, new \DateTimeZone($timezone));
        $diff = $startDateTime->diff($endDateTime);
        
        switch ($interval) {
            case 'years':
                return $diff->y;
            case 'months':
                return $diff->m;
            case 'days':
                return $diff->days;
            case 'hours':
                return $diff->h;
            case 'minutes':
                return $diff->i;
            case 'seconds':
                return $diff->s;
            default:
                return false;
        }
    }
}
