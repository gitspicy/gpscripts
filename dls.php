<?php
// Sample array
$array = [
    ['Name', 'Age', 'City'],
    ['Alice', 30, 'New York'],
    ['Bob', 25, 'Los Angeles'],
    ['Charlie', 35, 'Chicago']
];

// Generate CSV content
$output = fopen('php://output', 'w');
foreach ($array as $row) {
    fputcsv($output, $row);
}
fclose($output);

// Set headers to prompt download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="output.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// Output the CSV content
readfile('php://output');
?>
