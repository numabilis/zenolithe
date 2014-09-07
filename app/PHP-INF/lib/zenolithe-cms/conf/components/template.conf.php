<?php
$component['type'] = 'template';
$component['roles'] = array('interceptor');
$component['editor'] = 'org\\zenolithe\\cms\\templating\\TemplateEditor';
$component['editor-configuration']['view'] = 'components/html-block/localization';
$component['class']  = 'org\\zenolithe\\cms\\templating\\TemplateInterceptor';
?>
