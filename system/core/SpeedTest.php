<?php
namespace Shibaji\Core;

class SpeedTest
{
    private $startTime;
    private $endTime;

    public function start()
    {
        $this->startTime = microtime(true);
    }

    public function stop()
    {
        $this->endTime = microtime(true);
    }

    public function getElapsedTime()
    {
        if (isset($this->startTime) && isset($this->endTime)) {
            return $this->endTime - $this->startTime;
        } else {
            throw new \Exception("Timer has not been started or stopped.");
        }
    }

    public function printElapsedTime()
    {
        $elapsedTime = $this->getElapsedTime();
        echo "Elapsed Time: " . number_format($elapsedTime, 6) . " seconds\n";
    }

    public function printConsoleElapsedTime(){
        $elapsedTime = $this->getElapsedTime();
        $time = number_format($elapsedTime, 6);
        echo <<<HTML
        <script type="text/javascript">
            // Output the elapsed time to the developer console
            console.log("Elapsed time for code block: $time seconds");
        </script>
        HTML;
    }

    public function run(callable $callback, ...$params)
    {
        $this->start();
        call_user_func_array($callback, $params);
        $this->stop();
        // $this->printElapsedTime();
        return $this->getElapsedTime();
    }
}