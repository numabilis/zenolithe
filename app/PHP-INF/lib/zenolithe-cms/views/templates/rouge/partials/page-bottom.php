<footer>

</footer>
<?php
	foreach($model->getContent('body-end') as $cpt) {
		render_view($cpt->getViewName(), $cpt);
	}
?>
</body>
</html>