<?php

if ($REX['REDAXO']) {

      // init addon
      $REX['ADDON']['name']['aox_ajax'] = 'AJAX Framework';
      $REX['ADDON']['page']['aox_ajax'] = 'aox_ajax';
      $REX['ADDON']['version']['aox_ajax'] = '0.0.1';
      $REX['ADDON']['author']['aox_ajax'] = 'webghost';
      $REX['ADDON']['supportpage']['aox_ajax'] = 'forum.redaxo.org';
      $REX['ADDON']['perm']['aox_ajax'] = 'admin[]';

      // permissions
      $REX['PERM']['aox_ajax'] = 'aox_ajax[]';
      // add lang file
      $I18N->appendFile($REX['INCLUDE_PATH'] . '/addons/aox_ajax/lang/');

      if (isset($REX['USER']) && ($REX['USER']->isAdmin() || $REX['USER']->hasPerm('admin[]') || $REX['USER']->hasPerm('aox_ajax[]'))) {

            // Pages
            $REX['ADDON']['aox_ajax']['SUBPAGES'] = array(
                array('', $I18N->msg('aox_ajax_page_log')),
                array('help', $I18N->msg('aox_ajax_page_help'))
            );
      }
}//_ /endif REDAXO

/*
 * Settings
 */
$REX['ADDON']['aox_ajax']['settings'] = array(
    'CONTROLLER' => $REX['SERVER'] . 'ajax/',
    'QWEST_JS' => $REX['SERVER'] . 'files/addons/aox_ajax/qwest.min.js',
    'JQUERY_JS' => $REX['SERVER'] . 'files/addons/aox_ajax/jquery.min.js',
    'PHP_DIR' => realpath($REX['FRONTEND_PATH'] . '/ajax/php/'),
    'LOG_FILE' => realpath($REX['INCLUDE_PATH'] . '/addons/aox_ajax/log/log.txt'),
    'CONTROLLER_CLASS' => realpath($REX['INCLUDE_PATH'] . '/addons/aox_ajax/lib/aoxAjaxController.php'),
    'DEBUG' => false
);
