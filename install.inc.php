<?php

$dir      = $REX['INCLUDE_PATH'] . '/addons/aox_ajax';
$error    = array();
$filePerm = 0755;

// lang
$I18N->appendFile($REX['INCLUDE_PATH'] . '/addons/aox_ajax/lang/');

/*
 * Prüfen
 */

// redaxo version
if (version_compare($REX['VERSION'] . '.' . $REX['SUBVERSION'] . '.' . $REX['MINORVERSION'], '4.5.0', '<='))
      $error[] = 'inst_rex_version_min';

// php version
if (version_compare(PHP_VERSION, '5.4.0', '<='))
      $error[] = 'inst_php_version_min'.PHP_VERSION;

// dir
if (!is_writable($REX['FRONTEND_PATH']))
      $error[] = 'inst_write_permission';

// eigentümer
$ownwer  = posix_getpwuid(fileowner('index.php'));
if ($ownwer['name'] !== 'www-data')
      $error[] = 'inst_owner_problem';

/*
 * Verzeichnis installieren
 */
if (!file_exists($REX['FRONTEND_PATH'] . '/ajax')) {

      xcopy($dir . '/install_files', $REX['FRONTEND_PATH'], $filePerm);
} else {
      
      rename($dir . '/install_files/ajax/index.php', $REX['FRONTEND_PATH'] . '/ajax/index.php');
      rename($dir . '/install_files/ajax/note.php', $REX['FRONTEND_PATH'] . '/ajax/note.php');
}

/*
 * install
 */
if (empty($error)) {
      $REX['ADDON']['install']['aox_ajax'] = 1;
} else {
      $msg = '<br/>';
      foreach ($error as $val) {
            $msg .= $I18N->msg('aox_ajax_' . $val . '<br/>');
      }
	$REX['ADDON']['installmsg']['aox_ajax'] = $msg;
	$REX['ADDON']['install']['aox_ajax'] = 0;
}

/**
 * Copy a file, or recursively copy a folder and its contents
 * @param       string   $source    Source path
 * @param       string   $dest      Destination path
 * @param       string   $permissions New folder creation permissions
 * @return      bool     Returns true on success, false on failure
 */
function xcopy($source, $dest, $permissions = 0755) {
      // Check for symlinks
      if (is_link($source)) {
            return symlink(readlink($source), $dest);
      }

      // Simple copy for a file
      if (is_file($source)) {
            return copy($source, $dest);
      }

      // Make destination directory
      if (!is_dir($dest)) {
            mkdir($dest, $permissions);
      }

      // Loop through the folder
      $dir   = dir($source);
      while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                  continue;
            }

            // Deep copy directories
            xcopy("$source/$entry", "$dest/$entry", $permissions);
      }

      // Clean up
      $dir->close();
      return true;
}
