<?php
use org\zenolithe\kernel\http\RequestHelper;

$template = $model->get('template');
if($template['page']['count'] > 1) {

?>
<div class="pagination">
<?php
$reqHelper = RequestHelper::getInstance();

$inc = 3;
$current = $template['page']['current'];
$pageCount = $template['page']['count'];

$min = $current - $inc;
$max = $current + $inc;
if($min < 2) {
    $min = 2;
}
if($max > $pageCount - 1) {
    $max = $pageCount - 1;
}
if($current != 1) {
    $i = $current - 1;
    if($i > 1) {
        echo '<a href="'.$reqHelper->urlWithModifiedParameter('p', $i).'"><img width="6" height="10" src="'. static_url("rsrc/orange/puces/puce-04-bis.png").'" alt="Précédent"></a> ';
    } else {
        echo '<a href="'.$reqHelper->urlWithRemovedParameter('p').'"><img width="6" height="10" src="'. static_url("rsrc/orange/puces/puce-04-bis.png").'" alt="Précédent"></a> ';
    }
    echo ' <a href="'.$reqHelper->urlWithRemovedParameter('p').'">1</a> ';
} else {
    echo '<img width="6" height="10" src="'. static_url("rsrc/orange/puces/puce-04-bis.png").'" alt="Précédent"> ';
}
if($min > 2) {
    echo ' ... ';
}
for($i=$min; $i<$current; $i++) {
    echo ' <a href="'.$reqHelper->urlWithModifiedParameter('p', $i).'">'.$i.'</a> ';
}
echo ' <strong>'.$current.'</strong>';
if($current <= $max) {
	echo ' ';
}
for($i=$current+1; $i<=$max; $i++) {
    echo ' <a href="'.$reqHelper->urlWithModifiedParameter('p', $i).'">'.$i.'</a> ';
}
if($max < $pageCount - 1) {
    echo ' ... ';
}
if($current != $pageCount) {
    echo ' <a href="'.$reqHelper->urlWithModifiedParameter('p', $pageCount).'">'.$pageCount.'</a>';
    $i = $current + 1;
    echo ' <a href="'.$reqHelper->urlWithModifiedParameter('p', $i).'"><img width="6" height="10" src="'. static_url("rsrc/orange/puces/puce-04.png").'" alt="Suivant"></a>';
} else {
    echo ' <img width="6" height="10" src="'. static_url("rsrc/orange/puces/puce-04.png").'" alt="Suivant">';
}
?>
</div>
<?php } ?>