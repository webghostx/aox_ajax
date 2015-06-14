<?php

/*
 * Falls das REDAXO-Array benötigt wird
 */
$REX = self::$rex;

/*
 * Zum testen Debug aktivieren damit Fehler in die Log-Datei
 * geschrieben werden
 */
self::$debug = true;

$sql = rex_sql::factory();
// $sql->debugsql = 1; //Ausgabe Query
$sql->setQuery("SELECT * FROM rex_article WHERE status=1");

$output = '<ul>';
for ($i = 0; $i < $sql->getRows(); $i++) {
      $name = $sql->getValue('name');
      $output .= '<li>' . $name . '</li>';

      $sql->next();
}
$output .= '</ul>';

print '<h5>Online-Artikel auf ' . $REX['SERVERNAME'] . ':</h5> ';
print $output;
