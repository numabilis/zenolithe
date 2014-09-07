<?php
$editedDomainId = -1;
if($model->getAttribute('edited_domain')) {
	$editedDomain = $model->getAttribute('edited_domain');
	$editedDomainId = $editedDomain['dom_id'];
	$menuItem = 'switch';
}
require view_file('admin/top');
?>

<div id="main">
    <table class="list">
    	<tr>
    		<th>Mnem</th>
    		<th>URL</th>
    		<th>Action</th>
    	</tr>
    <?php foreach ($model->getAttribute('domains') as $domain) { ?>
    	<tr>
    		<td><?php echo $domain['dom_mnem']; ?></td>
    		<td><?php echo $domain['dom_base']; ?></td>
    		<td class="actions">
    			<?php if($domain['dom_id'] != $editedDomainId) { ?>
    			<form action='switch.php' method='post'>
            <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
    				<input type="hidden" name="dom_id" value="<?php echo $domain['dom_id']; ?>" />
    				<input type=submit class="button" value="Administrer" />
    			</form>
    			<?php } else { ?>
    				<input disabled="disabled" type=submit class="button" value="Administrer" />
    			<?php } ?>
    		</td>
    	</tr>
    <?php } ?>
    </table>
    
    <div class="listActions"><a class="button" href="new.php">Nouveau</a></div>

</div>

<?php require view_file('admin/bottom'); ?>
