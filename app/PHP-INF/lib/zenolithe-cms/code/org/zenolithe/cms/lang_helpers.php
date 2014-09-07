<?php
function delegated_lang($lang) {
    $delegated = null;
    
    switch ($lang) {
        case 'fr' :
            $delegated = array('en', 'sp', 'de');
            break;
        case 'en' :
            $delegated = array('fr', 'de', 'sp');
            break;
        case 'sp' :
            $delegated = array('en', 'fr', 'de');
            break;
        case 'de' :
            $delegated = array('en', 'fr', 'sp');
            break;
        case 'zh' :
            $delegated = array('zh_hant', 'en', 'fr');
            break;
        case 'zh_hant' :
            $delegated = array('zh', 'en', 'fr');
            break;
        default :
            $delegated = array('en', 'fr', 'sp');
    }
    
    return $delegated;
}