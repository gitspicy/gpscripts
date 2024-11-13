<?php
include_once('header.html');
?>
    <div class="centered-container prompt-light-italic">
        <h2>Open Multiple Urls</h2>
    
    


    <h3>Enter links to open in new tabs</h3>
    
    <form method="POST" onsubmit="openLinks(document.getElementById('urls').value); return false;">
        <textarea id="urls" name="urls" rows="10" cols="50" placeholder="Enter each URL on a new line"></textarea><br>
        <input type="submit" value="Open Links">
    </form>
    </div>
</body>
        
<script>
        function ensureAbsoluteLink(url) {
            // If the URL does not start with http:// or https://, add http://
            if (!url.startsWith('http://') && !url.startsWith('https://')) {
                return 'http://' + url;
            }
            return url;
        }

        function openLinks(links) {
            const urlArray = links.split("\n");
            urlArray.forEach(link => {
                link = link.trim(); // Remove any extra spaces
                if (link !== '') {
                    const absoluteLink = ensureAbsoluteLink(link); // Ensure it's an absolute URL
                    window.open(absoluteLink, '_blank');
                }
            });
        }
    </script>
    </html>    
      
    
<?php include("footer.html");
