<?php

$search = array('(CHANGELOG.md)', '(LICENSE.md)');
$replace = array('(index.php?page=aox_ajax&subpage=help&chapter=changelog)', '(index.php?page=aox_ajax&subpage=help&chapter=license)');

echo rex_aox_ajax_utils::getHtmlFromMDFile('README.md', $search, $replace);

