<?php

$allow_mobile_version = get_option('arcade-two-mobile-version');
if(is_null($allow_mobile_version)){
	$allow_mobile_version = true;
} else {
	if($allow_mobile_version == 'true'){
		$allow_mobile_version = true;
	} else {
		$allow_mobile_version = false;
	}
}

if(isset($_POST['action'])){
	if($_POST['action'] == 'update-icons-data'){
		file_put_contents(ABSPATH . TEMPLATE_PATH . '/includes/category-icons.json', $_POST['data']);
		show_alert('SAVED!', 'success');
	} else if($_POST['action'] == 'update-allow-mobile'){
		if(isset($_POST['mobile-version'])){
			update_option('arcade-two-mobile-version', 'true');
			$allow_mobile_version = true;
		} else {
			update_option('arcade-two-mobile-version', 'false');
			$allow_mobile_version = false;
		}
		show_alert('SAVED!', 'success');
	}
}

$category_icons = json_decode( file_get_contents(ABSPATH . TEMPLATE_PATH . '/includes/category-icons.json'), true);

echo '<h4>'._t('Allow mobile version').'</h4>';
echo '<br>';
echo '<form method="post">';
echo '<input type="hidden" name="action" value="update-allow-mobile"/>';
$checked = '';
if($allow_mobile_version){
	$checked = 'checked';
}
?>
<div class="form-check">
	<input type="checkbox" class="form-check-input" name="mobile-version" id="check1" <?php echo $checked ?>>
	<label class="form-check-label" for="check1"><?php _e('Allow mobile version') ?></label>
</div>
<?php
echo '<br>';
echo '<button type="submit" class="btn btn-primary btn-md">'._t('SAVE').'</button>';
echo '</form>';

?>
<br>
<h4>Category Icons</h4>
<br>
<form method="post" id="form-icons">
	<input type="hidden" name="action" value="update-icons-data" />
	<input type="hidden" id="data-target" name="data" value="" />
	<div class="row">
		<div class="col">
			<label>ID:</label>
		</div>
		<div class="col">
			<label>Category Slug (separated by comma):</label>
		</div>
	</div>
	<?php
	foreach ($category_icons as $key => $value) {
		?>
		<div class="row">
			<img src="<?php echo get_template_path(); ?>/images/icon/<?php echo $key; ?>.svg">
			<div class="form-group col">
				<input type="text" class="form-control t-key" name="val" value="<?php echo $key ?>" readonly required>
			</div>
			<div class="form-group col">
				<input type="text" class="form-control t-value" name="val" value="<?php echo implode(',', $value); ?>" required>
			</div>
		</div>
		<?php
	}
	?>
</form>
<button id="save-icon-conf" class="btn btn-primary btn-md">Save</button>
<script type="text/javascript">
	$(document).ready(()=>{
		$('#save-icon-conf').click(()=>{
			if(true){
				let res = '{';
				let error;
				let t1 = $('.t-key').serializeArray();
				let t2 = $('.t-value').serializeArray();
				let total = t1.length;
				for(let i=0; i<total; i++){
					if(t1[i].value && t2[i].value){
						res += '"'+t1[i].value+'"'+': '+JSON.stringify(t2[i].value.split(','))+',';
					}
				}
				if(res.slice(-1) === ','){
					res = res.slice(0, -1);
				}
				res += '}';
				let x = JSON.parse(res);
				if(res !=  '{}'){
					$('#data-target').val(res);
					$('form#form-icons').submit();
				}
			}
		});
	});
</script>