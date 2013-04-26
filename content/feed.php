<?php
$cache_time = 3600*240; // 24 hours
 
$cache_file = $_SERVER['DOCUMENT_ROOT'].'/cache/udienz.rss';
$timedif = @(time() - filemtime($cache_file));
 
if (file_exists($cache_file) && $timedif < $cache_time) {
    $string = file_get_contents($cache_file);
} else {
    $string = file_get_contents('http://log.udienz.web.id/feed');
    if ($f = @fopen($cache_file, 'w')) {
        fwrite ($f, $string, strlen($string));
        fclose($f);
    }
}
$xml = simplexml_load_string($string);
 
// place the code below somewhere in your html
echo '
    <ul style="list-style-type: none;">';
$count = 0;
$max = 4;
// Present each rss item
foreach ($xml->channel->item as $val) {
    if ($count < $max) {
        echo '
        <li>
            <i class="icon-comments"> </i>
            <strong>'.$val->title.'</strong><br />
            '.$val->description.' | <a href="'.$val->link.'">More  &gt;</a>
        </li>';
    }
    $count++;
}
echo '
    </ul>
</div>';
?>
