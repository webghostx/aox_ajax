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





# Code Beispiele

Im REDAXO-Backend befindet sich ein Template mit diesen Beispielen, welches man installieren kann um zu testen. Die PHP-Komponenten befinden sich unter `/ajax/php/Beispiel`

## Post-Request mit qwest.js
In diesem Beispiel wird [qwest.js](https://github.com/pyrsmk/qwest) verwendet für den Ajax-Request. Dieses schlanke Ajax-Library eignet sich optimal für Seiten die sonst kein JS-Framework verwenden. Sie wird daher mit dem Addon mitgeliefert.
```php
<form class="form-inline">
      <div class="form-group">
            <input class="form-control" type="text" value="John" id="firstname"/>
            <input class="form-control" type="text" value="Doe" id="lastname"/>
            <button class="btn btn-primary" id="button">test</button>
      </div>
</form>
<script type="text/javascript" src="<?php echo $REX['ADDON']['aox_ajax']['settings']['QWEST_JS']; ?>"></script>
<script type="text/javascript">
      (function () {
            var button = document.getElementById('button');

            button.onclick = function () {

                  var firstname = document.getElementById('firstname').value;
                  var lastname = document.getElementById('lastname').value;

                  qwest.post('<?php echo $REX['ADDON']['aox_ajax']['settings']['CONTROLLER']; ?>', {
                        /*
                         * Die Angabe von PATH ist zwingend erforderlich
                         * Hier wird bestimmt welche Datei vom Controller angesprochen wird
                         */
                        PATH: 'Beispiel/Hallo.php',
                        /*
                         * DATA ist optional
                         * Hier können belibige Parameter übergeben werden
                         */
                        DATA: {
                              firstName: firstname,
                              lastName: lastname
                        }
                  }).then(function (response) {
                        console.log('Abtwort: ' + response);
                        alert(response);
                  }).catch(function (e, response) {
                        console.log('Error: ' + e + ' | ' + response);
                  });
                  return false;
            }
      })();
</script>
```
und hier noch der PHP Teil
```php
<?php
/*
 * unter self::$requestData stehen unsere Daten die wir uber 
 * den Parameter DATA gesendet haben. Es ist auch möglich 
 * direkt über $_REQUEST['DATA'][] an die Daten zu kommen.
 */
$requestData = (isset(self::$requestData)) ? self::$requestData : false;
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
```
wie man sieht befinden wir uns hier innerhalb des Controllers und können mit self:: auf Komponenten der Klasse zugreifen.

## Get-Request mit jQuery und rex_sql
In diesem Beispiel wird jQuery verwendet. Daten senden wir hier nicht mit. Die Ziel-Datei weiss auch so was zu tun ist.
```php
<button class="btn btn-primary" id="button2">Liste aller Online-Artikel anzeigen</button>
<div id="frame"></div>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
      $("#button2").click(function () {

            var request = $.ajax({
                  url: "<?php echo $REX['ADDON']['aox_ajax']['settings']['CONTROLLER']; ?>",
                  method: "GET",
                  data: {
                        // URL aus PHP: echo $REX['FRONTEND_PATH'] . '/ajax/php/Beispiel/Sql.php'
                        PATH: '<?php echo $REX['FRONTEND_PATH'] . '/ajax/php/Beispiel/Sql.php'; ?>',
                        DATA: {} //hier könnten wir Parameter übergeben
                  }
            });
            request.done(function (msg) {
                  $("#frame").html(msg)
            });
            request.fail(function (jqXHR, textStatus) {
                  $("#frame").html("Request failed: " + textStatus);
            });
            return;
      });
</script>
```
hier noch der PHP Teil:
```php
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
```
Da wir uns hier im Controller befinden und zuvor der REDAXO-Kern sowie alle aktiven Addons geladen wurden, können wir auch rex_sql sowie alle anderen Klassen verwenden.

## Cross-Domain-Request mit jQuery
Hier fragen wir die aktuellen Wechselkurse der EZB ab, welche im XML Format ausgeliefert werden. Bei Requests zu anderen Domains bestehen einige Einschränkungen, der entfernte Server muss den Zugriff erlauben.
```php
<button class="btn btn-primary" id="button3">Daten abrufen</button>
<div id="frame3"></div>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
      $("#button3").click(function () {

            var request = $.ajax({
                  url: "<?php echo $REX['ADDON']['aox_ajax']['settings']['CONTROLLER']; ?>",
                  method: "GET",
                  data: {
                        PATH: 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml'
                  }
            });
            request.done(function (msg) {
                  $("#frame3").html('<pre class="prettyprint" style="padding:1em;margin-top:0.5em;">' + htmlEntities(msg) + '</pre>')
            });
            request.fail(function (jqXHR, textStatus) {
                  $("#frame3").text("Request failed: " + textStatus);
            });
            function htmlEntities(str) {
                  return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
            }
            return;
      });
</script>
```
## einfacher XMLHttpRequest
Hier noch ein Beispiel ganz ohne JavaScript-Framework
```php
<form class="form-inline">
      <div class="form-group">
            <input class="form-control" type="text" value="John" id="firstname4"/>
            <input class="form-control" type="text" value="Doe" id="lastname4"/>
            <button class="btn btn-primary" id="button4">test</button>
      </div>
</form>
<div id="frame4"></div>
<script type="text/javascript">
      (function () {
            var button = document.getElementById('button4');

            button.onclick = function () {

                  var firstname = document.getElementById('firstname4').value;
                  var lastname = document.getElementById('lastname4').value;
                  // URL aus PHP: $REX['ADDON']['aox_ajax']['settings']['CONTROLLER']
                  var url = '<?php echo $REX['ADDON']['aox_ajax']['settings']['CONTROLLER']; ?>';
                  var xhr = new XMLHttpRequest();
                  xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200)
                            document.getElementById('frame4').innerHTML = '<pre>' + xhr.responseText + '</pre>';
                  }
                  xhr.open("POST", url, true);
                  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                  xhr.send(
                          "DATA[firstName]=" + firstname + '&' + 
                          "DATA[lastName]=" + lastname + '&' + 
                          'PATH=Beispiel/Hallo.php'
                          );

                  return false;
            }
      })();
</script>
```