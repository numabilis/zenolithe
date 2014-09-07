<?php
$component['type'] = 'textblock';
$component['roles'] = array('view-component', 'interceptor');
$component['editor'] = 'org\\zenolithe\\cms\\components\\editors\\HtmlBlockEditor';
$component['editor-configuration']['view'] = 'components/text-block-localization';
$component['class']  = 'org\\zenolithe\\cms\\components\\HtmlBlock';
?>
