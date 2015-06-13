<?php

/*
 * Es wird nicht schaden die empfangenen Daten zu prüfen
 */
$requestData = (isset($_REQUEST['DATA'])) ? $_REQUEST['DATA'] : false;
$firstName = filter_var($requestData['firstName'], FILTER_SANITIZE_STRING);
$lastName = filter_var($requestData['lastName'], FILTER_SANITIZE_STRING);

/*
 * Falls das REDAXO-Array benötigt wird
 */
$REX = self::$rex;

/*
 * Zum testen Debug aktivieren damit Fehler in die Log-Datei
 * geschrieben werden
 */
self::$debug = true;

if ($firstName && $lastName) {
      /*
       * Wenn alles passt erzeugen wir die Ausgabe
       */
      echo 'Hallo ' . $firstName . ' ' . $lastName . PHP_EOL;
      echo 'Willkommen bei ' . $REX['SERVERNAME'] . PHP_EOL;
} else {
      /*
       * Eventuell machen wir auch sonst eine Ausgabe
       */
      echo 'Hallo unbekannter';

      /*
       * Wir können den Fehler auch festhalten in dem
       * wir in ins Log schreiben. Dazu muss Debug aktiviert
       * sein. Wenn Debug aus ist, wird der geworfene 
       * Fehler ignoriert.
       */
      throw new Exception('WARNING: Name unvollständig!');
      /*
       * Diese Meldung wird dann direkt in die Logdatei geschrieben
       * und wird im Backend angezeigt.
       * 
       * Mit dem Schlüsselwort "ERROR" ganz am Anfang der Meldung,
       * können wir das Script auch gleich noch beenden.
       * 
       * throw new Exception('ERROR: Name unvollständig!');
       * 
       * Hierbei wird ein 400 Bad Request gesendet gefolgt
       * von exit() - auch ohne Debug aktiviert zu haben
       */
}