<?php
//echo "<pre>";
//set initial flag
$flag=0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['url'])) {
    //get PN from form
    $base = "https://www.rockauto.com/en/parts/four+seasons," . $_POST['url'];
     
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
						
						$newdom = new DOMDocument();
						libxml_use_internal_errors(true); // Suppress HTML parsing warnings
						
                        $newdom->loadHTML($newpage);
						libxml_clear_errors();
										
						$newxpath = new DOMXPath($newdom);
                        foreach ($newxpath as $key=>$value) {
                            echo $key . " => " . $value;
                        }

						$atpoints = $newxpath->query("//table[contains(@class, 'moreinfotable')]");
						
                        $tc ="";
                        
                        foreach ($atpoints as $value) {
                           //echo $newdom->saveHTML($value);
                            $tc .= $newdom->saveHTML($value);

                        }
                       // set flag
                       $flag=1;


                        /*
                       echo '<hr>';
                       echo ($tc);
                       echo '<hr>';
                       

                        $tabledom = new DOMDocument();
                        @$tabledom->loadHTML($tc);
                        
                        // Get all rows from the table
                        $rows = $tabledom->getElementsByTagName('tr');

                        foreach ($rows as $row) {
                            $cols = $row->getElementsByTagName('td');

                            $col1 = trim($cols?->item(0)->textContent);
                            $col2 = trim($cols?->item(1)->textContent);
                            // Print in 'column 1 <tab> column 2' format
                            echo $col1 . "\t" . $col2 . PHP_EOL;
                            
                        }*/



                     }
                }
            } else {
                echo "<p>No anchor tags with class 'a-btn-moreinfo' found on the given page.</p>";
            }
        }
    } else {
        echo "Invalid URL. Please enter a valid URL.";
    }
}



?>


<?php 

include('header.html');
if ($flag==1){

echo <<< BEWM
<div class="results">
<p>$tc</p>
<hr />
</div>
BEWM;
}

?>
<div class="centered-container">
        <h2>AC Kit Attribute Scraper</h1>
        <p>Enter the part number below. 5283NK</p>
    
    <form method="POST">
        <label for="url"></label>
        <input type="text" id="url" name="url" placeholder="Example: 5283NK" required>
        <button type="submit">Submit</button>
    </form>
    </div>

    <?php include('footer.html');?>

