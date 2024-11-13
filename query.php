<?php include_once('header.html');?>

    <div class="cecentered-container">
        <h1 class="text-center">Link Generator</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="number" class="form-label">Enter Part Number</label>
                        <input type="number" class="form-control" id="number" name="number" placeholder="Enter a number" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Generate</button>
                </form>
            </div>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $number = intval($_POST['number']);
			$pn = $number;
                echo '<div class="mt-4">';
                echo '<h3 class="text-center">Generated Links:</h3>';
                echo '<div class="list-group">';
                $fourslink="https://www.4s.com/en";
                
				$optilink="https://web.tecalliance.net/opticat/qa/parts/search?query=$pn";
				$orlink="https://www.oreillyauto.com/search?q=$pn";
				$napalink="https://www.napaonline.com/en/search?text=$pn";

                $advancelink="https://shop.advanceautoparts.com/web/SearchResults?searchTerm=$pn";

                echo "<a href=$fourslink class='list-group-item list-group-item-action' target='_blank'> $fourslink </a>";
				echo "<a href=$optilink class='list-group-item list-group-item-action' target='_blank'> $optilink </a>";
				
					
				echo "<a href=$orlink class='list-group-item list-group-item-action' target='_blank'> $orlink </a>";
				
				
				echo "<a href=$napalink class='list-group-item list-group-item-action' target='_blank'> $napalink </a>";
				
				
				echo "<a href=$advancelink class='list-group-item list-group-item-action' target='_blank'> $advancelink </a>";

				
				
				
				echo '</div>';
                echo '</div>';
            
        }
		
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




<?php include_once('footer.html');?>
