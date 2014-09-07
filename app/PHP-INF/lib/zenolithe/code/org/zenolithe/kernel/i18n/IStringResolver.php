<?php
namespace org\zenolithe\kernel\i18n;

interface IStringResolver {
	public function getString($key, $lang, $strict=false);
}
?>