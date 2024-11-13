<?php
include_once('header.html');
?>
   

<div class="centered-container">
   <h2>Quick open Opticat pages</h2>
<form method="POST" action="">
    <label for="numbers">Enter Numbers (one per line):</label><br>
    <textarea id="numbers" name="numbers" rows="20" cols="30" required></textarea><br>
    <input type="submit" value="Submit">
</form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get numbers from the form
    $numbers = $_POST['numbers'];
    
    // Explode the numbers into an array by newlines
    $numbersArray = preg_split('/\r\n|\r|\n/', $numbers);

    // Pass the numbers array to JavaScript to open URLs
    echo "<script>";
    echo "var numbers = " . json_encode($numbersArray) . ";";
    echo "for (var i = 0; i < numbers.length; i++) {";
    echo "    var url = 'https://web.tecalliance.net/opticat/qa/parts/search?query=' + numbers[i].trim();"; // Adjust URL here
    echo "    window.open(url, '_blank');"; // Opens in a new tab
    echo "}";
    echo "</script>";
}
?>
       
      
    
<?php include("footer.html");
