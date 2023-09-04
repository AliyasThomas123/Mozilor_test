<?php
// Get form data
$blockGoogleAds = isset($_POST['block_google_ads']);
$blockGoogleAnalytics=isset($_POST['block_google_analytics']);
$blockSoundCloud = isset($_POST['block_soundcloud']);
$blockYouTube = isset($_POST['block_youtube']);
$htmlContent = $_POST['html_content'];

// Keywords Searching
function blockContentWithKeywords($htmlContent, $keywords) {
    if (!empty($keywords)) {
        // Block scripts and iframes with URLs containing any of the specified keywords
        $pattern = '/<script.*?src=".*?(' . implode('|', $keywords) . ').*?<\/script>/i';
        $htmlContent = preg_replace($pattern, '', $htmlContent);

        $pattern = '/<iframe.*?src=".*?(' . implode('|', $keywords) . ').*?<\/iframe>/i';
        $htmlContent = preg_replace($pattern, '', $htmlContent);
    }
    return $htmlContent;
}

// Define keywords for blocking
$keywordsToBlock = [];
if (($blockGoogleAds) || ($blockGoogleAnalytics)) {
    $keywordsToBlock[] = 'google';
}
if ($blockSoundCloud) {
    $keywordsToBlock[] = 'soundcloud';
}
if ($blockYouTube) {
    $keywordsToBlock[] = 'youtube';
}
if (isset($_POST['custom_Pattern'])){
    $keywordsToBlock=$_POST['custom_Pattern'];
}
// Block content based on keywords
$htmlContent = blockContentWithKeywords($htmlContent, $keywordsToBlock);

// display the modified HTML content
echo "<h1>Modified HTML Content</h1>";
echo "<pre>" . htmlspecialchars($htmlContent) . "</pre>";
?>
