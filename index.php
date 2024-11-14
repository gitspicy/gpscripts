<?php
include_once('header.html');
include("functions.php");

echo <<< BEWM
    <div class="centered-container">
        <h2>Webtools Homepage</h2>
    </div>
BEWM;
        
   
//update log      
logger('index');  
include("footer.html");
?>
