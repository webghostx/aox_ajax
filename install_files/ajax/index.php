<?php

/*
 *  wenn der Aufruf nicht per ajax gemacht wird, sofort beenden
 */
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
      header('HTTP/1.1 400 Bad Request');
      exit();
}

/*
 * REDAXO Kern und Addons laden
 */
unset($REX);
$REX['REDAXO'] = false;
$REX['GG'] = true;
$REX['HTDOCS_PATH'] = '../';
require_once realpath($REX['HTDOCS_PATH'] . 'redaxo/include/functions/function_rex_mquotes.inc.php');
require_once realpath($REX['HTDOCS_PATH'] . 'redaxo/include/master.inc.php');
require_once realpath($REX['HTDOCS_PATH'] . 'redaxo/include/addons.inc.php');
require_once $REX['ADDON']['aox_ajax']['settings']['CONTROLLER_CLASS'];

/*
 * Debug Status aus Request entnehmen
 */
if(isset($_REQUEST['DEBUG']) && (intval($_REQUEST['DEBUG']) === 1 || $_REQUEST['DEBUG'] === true))
      $REX['ADDON']['aox_ajax']['settings']['DEBUG'] = true;

/*
 * Controller starten
 */
$ajax = aoxAjaxController::run($REX, $_REQUEST, $REX['ADDON']['aox_ajax']['settings']['DEBUG']);
