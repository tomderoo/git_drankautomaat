<?php
$processtime = round((microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) * 1000);
if ($processtime <= 50) {
    $frontcolor = "green";
    $backcolor = "#CCFFCC";
} elseif ($processtime > 50 && $processtime <= 100) {
    $frontcolor = "#999966";
    $backcolor = "#FFFFAA";
} elseif ($processtime > 100 && $processtime <= 200) {
    $frontcolor = "orange";
    $backcolor = "#FFDD55";
} elseif ($processtime > 200) {
    $frontcolor = "red";
    $backcolor = "#FFCCCC";
}
?>
<div style="position: fixed; bottom: 20px; right: 20px; padding: 10px; width: 200px; background-color: <?php print($backcolor); ?>; color: <?php print($frontcolor); ?>; text-align: center; border: 1px solid <?php print($frontcolor); ?>;">
    <?php echo "Process time: {$processtime} ms"; ?>
</div>
