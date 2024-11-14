<?php 

//log script
function logger($mydata) {
        // Define the log file path
        $logFile = 'log/access_log.txt';

        // Get the current time
        $time = date('Y-m-d H:i:s');

        // Get the referrer
        $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct Access';

        // Get the current URL
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Get the IP address
        $ip = $_SERVER['REMOTE_ADDR'];

        // Create the log entry
        $logEntry = "Time: $time | Referrer: $referrer | URL: $url | IP: $ip | $mydata" . PHP_EOL;

        // Write the log entry to the file
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    
}     
?>
