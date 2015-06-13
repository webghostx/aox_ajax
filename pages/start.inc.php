<?php

if (rex_request('log', 'string') === 'del') 
      file_put_contents($REX['ADDON']['aox_ajax']['settings']['LOG_FILE'], '');


$log = file_get_contents($REX['ADDON']['aox_ajax']['settings']['LOG_FILE']);

if (empty($log))
      $log = $I18N->msg('aox_ajax_page_log_empty');
      


?>

<div class="rex-addon-output">
      <h2 class="rex-hl2"><?php echo $I18N->msg('aox_ajax_page_log') ?></h2>
	<div class="rex-area-content">
            <p style="float: right;">
                  <a href=" <?php echo $_SERVER['REQUEST_URI'] . '&amp;log=del';?>"><?php echo $I18N->msg('aox_ajax_page_log_del') ?></a>
            </p>
            <p>
                  <a href="javascript: document.location.reload(true);"><?php echo $I18N->msg('aox_ajax_page_log_refresh') ?></a>
            </p>
            <pre style="margin: 1em;padding: 1em;background: #fff;border: 1px solid #ccc;">
<?php echo $log; ?>
            </pre>
           
	</div>
</div>