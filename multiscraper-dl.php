<?php
include('functions.php');
$debug = 0;


//echo '<pre>';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['parts'])) {
    
    // Get numbers from the form
    $numbers = $_POST['parts'];
    logger($numbers);
           
    // Explode the numbers into an array by newlines
    $numbersArray = preg_split('/\r\n|\r|\n/', $numbers);
// ;
($debug == 1) ? var_dump($numbersArray): '';


$totalArray='';
foreach ($numbersArray as $number){
    //BEGIN
    //$mynum = $numbersArray[0];
    $base = "https://www.rockauto.com/en/parts/four+seasons," . $number;
     
    //$url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
    $url = filter_var($base, FILTER_SANITIZE_URL);

    // Check if the URL is valid
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        // Use file_get_contents to get the HTML content
        $html = @file_get_contents($url);
        
        if ($html === FALSE) {
            echo "Unable to retrieve the content. Please check the URL.";
        } else {
            // Load the HTML content into DOMDocument
            $dom = new DOMDocument();
            libxml_use_internal_errors(true); // Suppress HTML parsing warnings
           
            $dom->loadHTML($html);
            libxml_clear_errors();
            
            // Find all <a> tags with the class 'a-btn-moreinfo'
            $xpath = new DOMXPath($dom);
            $anchors = $xpath->query("//a[contains(@class, 'a-btn-moreinfo')]");

            if ($anchors->length > 0) {
                
                foreach ($anchors as $anchor) {
                    $href = $anchor->getAttribute('href');
                    
                    if ($href) {
                        //echo "<p><a href='" . htmlspecialchars($href) . "' target='_blank'>" . htmlspecialchars($href) . "</a></p>";
						$mylink=$href;
						//echo $mylink;

						$newpage = @file_get_contents($mylink);
						//var_dump($newpage);
						
                        //get new DoM
						$newdom = new DOMDocument();
						libxml_use_internal_errors(true); // Suppress HTML parsing warnings
						
                        //Load HTML
                        $newdom->loadHTML($newpage);
						libxml_clear_errors();
						
                        //Get xpath
						$newxpath = new DOMXPath($newdom);
                        
                        //Query
						$atpoints = $newxpath->query("//table[contains(@class, 'moreinfotable')]");
						
                        //var init
                        //$tc ="";

                        foreach ($atpoints as $value) {
                            
                           //echo $newdom->saveHTML($value);
                            //$tc .= $newdom->saveHTML($value);
                            $totalArray .= $newdom->saveHTML($value);
                            } 
                            ($debug == 1) ? var_dump($tc): '';

                       // set flag
                       $flag=1;
      

                    }
                }//foreach
            }//if anchors >0
        
       // echo $tc;
        
        }//Main Processing
    }//if valid url
}//main if
}


if (isset($totalArray))
{ 
  
   

    $totalArray= str_replace("</td><td>", "\t", $totalArray);
    $totalArray= str_replace("</tr><tr>", "\n", $totalArray);
    $totalArray= str_replace("</td></tr>", "\n\n", $totalArray);
    $totalArray= str_replace("FOUR SEASONS ", "", $totalArray);
    $totalArray= str_replace(" Specifications", "", $totalArray);

    $totalArray = strip_tags($totalArray);

   





    // Start output buffering to prevent any accidental output before headers are sent
    ob_start();
    
    // Set the filename for download
    $filename = $numbersArray[0] . "output.txt";
    
    // Clear any previous output and set headers
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($totalArray));
    
    // Output the content and flush the buffer
    echo $totalArray;
    ob_end_flush();
    
    // Exit to ensure no further output is sent
    exit;
}


include('header.html');

?>

<div class="centered-container">
        <h2>Batch A/C Kit Attributes File Download</h1>
        <p>Enter the part numbers below, one per line up to 10. The results will be downloaded as a text file.<br />

        </p>
       
    <form method="POST">
        
        <textarea rows="10" cols="15" id="parts" name="parts" placeholder="" required></textarea><br />
        <button type="submit">Submit</button>
    </form>
    </div>

    <?php 

   



       // $outputString = implode(PHP_EOL, $totalArray);
/* 
// Set the filename for download
$filename = "output.txt";

// Set the appropriate headers for file download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($totalArray));

// Output the content
echo $totalArray;

// Exit to ensure no further output is sent
exit;

 */




include("footer.html");
?>