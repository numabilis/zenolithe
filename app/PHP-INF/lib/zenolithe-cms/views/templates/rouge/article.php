<?php
require view_file('partials/page-top');

$article = $model->get('article');
echo '<h1>'.$article->getTitle().'</h1>';
echo '<p>'.$article->getContent().'</p>';

require view_file('partials/page-bottom');
?>