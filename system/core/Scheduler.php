<?php
namespace Shibaji\Core;

class Scheduler
{
    const INTERVAL_MINUTE = 'minute';
    const INTERVAL_HOUR = 'hour';
    const INTERVAL_DAY = 'day';
    const INTERVAL_WEEK = 'week';
    const INTERVAL_MONTH = 'month';

    /**
     * Schedule a task to run at specified interval or specific date criteria.
     *
     * @param string $interval Interval for task execution ('minute', 'hour', 'day', 'week', 'month').
     * @param mixed $criteria Specific date criteria ('12th', 'Sunday', etc.) based on interval.
     * @param callable $task Task callback function.
     * @param array $args Arguments to pass to the task callback.
     */
    public static function schedule($interval, $criteria, $task, $args = [])
    {
        if ($interval === self::INTERVAL_MONTH && is_numeric($criteria)) {
            $dayOfMonth = (int)$criteria;
            $nextRunTime = self::getNextMonthRunTime($dayOfMonth);
        } elseif ($interval === self::INTERVAL_WEEK && is_string($criteria)) {
            $dayOfWeek = ucfirst(strtolower($criteria)); // Ensure case consistency
            $nextRunTime = self::getNextWeekRunTime($dayOfWeek);
        } else {
            throw new \InvalidArgumentException('Invalid interval or criteria specified.');
        }

        // Store task and schedule details for execution
        self::storeTask($nextRunTime, $task, $args);
    }

    /**
     * Get the next run time based on the specified day of the month.
     *
     * @param int $dayOfMonth Day of the month (1-31).
     * @return int UNIX timestamp of the next run time.
     */
    public static function getNextMonthRunTime($dayOfMonth)
    {
        $currentTimestamp = time();
        $currentDayOfMonth = date('j', $currentTimestamp);
        
        if ($currentDayOfMonth < $dayOfMonth) {
            $nextRunTime = strtotime(date("Y-m-$dayOfMonth H:i:s", $currentTimestamp));
        } else {
            $nextRunTime = strtotime("+1 month", strtotime(date("Y-m-$dayOfMonth H:i:s", $currentTimestamp)));
        }

        return $nextRunTime;
    }

    /**
     * Get the next run time based on the specified day of the week.
     *
     * @param string $dayOfWeek Day of the week (e.g., 'Sunday', 'Monday', ...).
     * @return int UNIX timestamp of the next run time.
     */
    public static function getNextWeekRunTime($dayOfWeek)
    {
        $currentTimestamp = time();
        $currentDayOfWeek = date('l', $currentTimestamp);

        // Calculate next occurrence of the specified day of week
        $daysToAdd = (7 + self::getDayOfWeekNumber($dayOfWeek) - self::getDayOfWeekNumber($currentDayOfWeek)) % 7;
        $nextRunTime = strtotime("+$daysToAdd days", $currentTimestamp);

        return $nextRunTime;
    }

    /**
     * Get the numeric representation of a day of the week.
     *
     * @param string $dayOfWeek Day of the week (e.g., 'Sunday', 'Monday', ...).
     * @return int Numeric representation of the day (0-6).
     */
    private static function getDayOfWeekNumber($dayOfWeek)
    {
        $days = ['Sunday' => 0, 'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6];
        return $days[$dayOfWeek];
    }

    /**
     * Store the scheduled task for execution.
     *
     * @param int $nextRunTime UNIX timestamp of the next run time.
     * @param callable $task Task callback function.
     * @param array $args Arguments to pass to the task callback.
     */
    private static function storeTask($nextRunTime, $task, $args)
    {
        // Example implementation - store in database or queue for later execution
        $taskDetails = [
            'next_run_time' => $nextRunTime,
            'task' => $task,
            'args' => $args,
        ];

        // For demonstration, just print task details
        echo "Task scheduled for " . date('Y-m-d H:i:s', $nextRunTime) . PHP_EOL;
        echo "Task details: " . var_export($taskDetails, true) . PHP_EOL;
    }
}