<?php require view_file('admin/top'); ?>

<div id="main">

<table class="list">
	<tr>
		<th>Nom</th>
		<th>Prénom</th>
		<th>Login</th>
		<th>Mail</th>
		<th>Profil</th>
		<th>Actions</th>
	</tr>
<?php
foreach ($model->get('users') as $user) {
?>
	<tr>
		<td><?php echo $user['usr_last_name']; ?></td>
		<td><?php echo $user['usr_first_name']; ?></td>
		<td><?php echo $user['usr_login']; ?></td>
		<td><?php echo $user['usr_email']; ?></td>
		<td>
    	<?php if($user['usr_profile'] == 'admin_app') { ?>
			Admin App
	    <?php } else { ?>
	    	Admin de site
	    <?php } ?>
		</td>
		<td class="actions">
			<a href="edit.php?usr_id=<?php echo $user['usr_id']; ?>"><img src="<?php echo static_url('rsrc/cms/images/user_edit.png'); ?>" /></a>
		</td>
	</tr>
<?php
}
?>
</table>

<div class="listActions"><a class="button" href="edit.php">Nouveau</a></div>

</div>

<?php require view_file('admin/bottom'); ?>

