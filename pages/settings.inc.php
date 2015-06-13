<?php

$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');

// save settings
if ($func == 'update') {
	$settings = (array) rex_post('settings', 'array', array());

	rex_aox_ajax_utils::replaceSettings($settings);
	rex_aox_ajax_utils::updateSettingsFile();
}
?>

<div class="rex-addon-output">
	<div class="rex-form">

		<h2 class="rex-hl2"><?php echo $I18N->msg('aox_ajax_settings'); ?></h2>

		<form action="index.php" method="post">

			<fieldset class="rex-form-col-1">
				<div class="rex-form-wrapper">
					<input type="hidden" name="page" value="<?php echo $page; ?>" />
					<input type="hidden" name="subpage" value="<?php echo $subpage; ?>" />
					<input type="hidden" name="func" value="update" />

					<div class="rex-form-row rex-form-element-v1">
						<p class="rex-form-text">
							<label for="foo"><?php echo $I18N->msg('aox_ajax_settings_foo'); ?></label>
							<input type="text" value="<?php echo $REX['ADDON']['aox_ajax']['settings']['foo']; ?>" name="settings[foo]" id="foo" class="rex-form-text">
						</p>
					</div>

					<div class="rex-form-row rex-form-element-v1">
						<p class="rex-form-checkbox">
							<label for="foo2"><?php echo $I18N->msg('aox_ajax_settings_foo2'); ?></label>
							<input type="hidden" name="settings[foo2]" value="0" />
							<input type="checkbox" name="settings[foo2]" id="foo2" value="1" <?php if ($REX['ADDON']['aox_ajax']['settings']['foo2']) { echo 'checked="checked"'; } ?>>
						</p>
					</div>

					<div class="rex-form-row rex-form-element-v1">
						<p class="rex-form-submit">
							<input type="submit" class="rex-form-submit" name="sendit" value="<?php echo $I18N->msg('aox_ajax_settings_save'); ?>" />
						</p>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>



