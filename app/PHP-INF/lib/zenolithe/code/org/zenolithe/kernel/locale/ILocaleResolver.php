<?php
namespace org\zenolithe\kernel\locale;

use org\zenolithe\kernel\http\Request;

interface ILocaleResolver {
	public function resolve(Request $request);
}
?>
