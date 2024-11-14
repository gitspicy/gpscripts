<?php
//echo "<pre>";
//set initial flag
$flag=0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['url'])) {
    //get PN from form
    //BEGIN

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
                        $tc ="";
                        
                        foreach ($atpoints as $value) {
                           //echo $newdom->saveHTML($value);
                            $tc .= $newdom->saveHTML($value);

                        }

                       // set flag
                       $flag=1;


                      

                     }//END
                }
            } else {
                echo "<p>No anchor tags with class 'a-btn-moreinfo' found on the given page.</p>";
            }
        }
    } else {
        echo "Invalid URL. Please enter a valid URL.";
    }
}




include('header.html');

echo <<< BEWM

<div class="centered-container">
        <h2>AC Kit Attribute Scraper</h1>
        <p>Enter the part number below. Results displayed below.</p>
    
    <form method="POST">
        <label for="url"></label>
        <input type="text" id="url" name="url" placeholder="Example: 5283NK" required>
        <button type="submit">Submit</button>
    </form>
    <br /><hr />
    <p>Batch scrapers<br />
        <a class="scrapelink" href="multiscraper.php">Onscreen data</a> | 
        <a class="scrapelink" href="multiscraper-dl.php">Download data</a>
    </p>

           
    </div>
BEWM;

if ($flag==1){

    $tc= str_replace("FOUR SEASONS ", "", $tc);
    $tc= str_replace(" Specifications", " Attributes", $tc);
echo <<< HAM
<div class="centered-container">
    <div class="results">
        <p>$tc</p>
        <hr />
        </div>
    </div>
       
HAM;
}

include('footer.html');
    ?>

