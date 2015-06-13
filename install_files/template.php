<?php
// errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);
?><!doctype html>
<html lang="de" dir="ltr">
      <head>
            <title>REX AjaxFramework Testseite</title>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
            <script src="http://code.jquery.com/jquery-latest.min.js"></script>
            <script defer src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" ></script>
            <script defer src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>

            <style type="text/css">
                  pre.prettyprint {
                        max-height:420px; transition: all 0.7s ease;padding:1em;
                  }
                  pre.big {
                        max-height:999px; transition: all 0.7s ease;
                  }
                  .tab-pane {
                        position: relative;
                  }
                  .resize {
                        position:absolute;right:18px;top:3px;cursor:pointer;border:1px solid #aaa;padding:0 4px;border-radius:3px;font-weight:bold;
                  }
                  section {margin-top: 20px;}
                  .anchor {
                        float:right;margin-left: 0.5em; background: #ccc; padding: 0 0.5em; border-radius: 2px; font-weight: bold; transition: all .5s ease;
                  }
                  .anchor:hover, .anchor:active, .anchor:focus {
                        text-decoration: none; background: #ddd; transition: all .5s ease;
                  }
                  #loader {
                        position: fixed; width: 200%; height: 62px; bottom:0;right:-50%; box-shadow: inset 0 -18px 22px rgba(0,0,0,0.2); background: rgba(255,255,255,0.7) url(/files/addons/aox_ajax/loading_42.gif) no-repeat center;
                  }
            </style>
            <noscript> <style type="text/css"> #loader { display: none; } </style> </noscript>
      </head>
      <body>
            <header class="page-header">
                  <div class="container">
                        <a name="top" id="top"></a>
                        <h1>REX AjaxFramework Testseite</h1>
                        <nav id="kapnav" class=""><ul class="nav nav-pills nav-stacked col-lg-8"></ul></nav>
                  </div>
            </header>
            <main id="aox-main">
                  <div class="container">
                        <div class="row">
                              <!--
                                    --
                                    SECTIONS START
                                    --
                              -->
                              <section class="col-lg-11">
                                    <div class="panel panel-default">
                                          <div class="panel-heading">
                                                <h3>1. Post-Request mit qwest.js</h3>
                                                <p>
                                                      Vor- und Nachname werden gesendet. Anhand dieser Daten gibt
                                                      das PHP-Script eine passende Begrüssung aus.
                                                </p>
                                          </div>
                                          <div class="panel-body">

                                                <ul class="nav nav-tabs" role="tablist">
                                                      <li class="active"><a href="#test1" data-toggle="tab">Ausgabe</a></li>
                                                      <li><a href="#html1" data-toggle="tab">HTML/JS</a></li>
                                                      <li><a href="#php1" data-toggle="tab">PHP</a></li>
                                                </ul>
                                                <div class="tab-content" style="margin-top: 1.2em">
                                                      <div class="tab-pane fade in active" id="test1" data-code="1">                                          
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

                  // URL aus PHP: echo $REX['ADDON']['aox_ajax']['settings']['CONTROLLER'];
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
                                                      </div>
                                                      <div class="tab-pane fade" id="html1" data-code-target="1"></div>
                                                      <div class="tab-pane fade" id="php1">
                                                            <span class="resize">&uarr;&darr;</span>
                                                            <pre class="prettyprint" style="padding:1em;">
<?php echo htmlentities(file_get_contents($REX['FRONTEND_PATH'] . '/ajax/php/Beispiel/Hallo.php')) ?>
                                                            </pre>
                                                      </div>
                                                </div>

                                          </div>
                                          <div class="panel-footer text-muted">
                                                <h5>Ablauf:</h5>
                                                <ol>
                                                      <li>Beim senden werden die Daten <code>DATA</code> mit Hilfe von <a href="https://github.com/pyrsmk/qwest">qwest.js</a> übermittelt (geht natürlich auch mit einem anderen Framework oder auch ohne)</li>
                                                      <li>Der Request erfolgt an den Ajax-Controller, welcher dann die in <code>PATH</code> angegebene Datei einbindet</li>
                                                      <li>Dort wird die Eingabe geprüft und verarbeitet. </li>
                                                      <li>Das REDAXO-Array wird hinzugezogen um den Namen der Website zu erhalten</li>
                                                </ol>
                                                <h5>Files:</h5>
                                                <ul>
                                                      <li>JS: <?php echo $REX['ADDON']['aox_ajax']['settings']['QWEST_JS']; ?></li>
                                                      <li>PHP: <?php echo $REX['FRONTEND_PATH'] . '/ajax/php/Beispiel/Hallo.php'; ?></li>
                                                </ul>
                                          </div>
                                    </div>
                              </section>
                              <!--
                                    --
                                    SECTION
                                    --
                              -->
                              <section class="col-lg-11">
                                    <div class="panel panel-default">
                                          <div class="panel-heading">
                                                <h3>2. Get-Request mit jQuery und rex_sql</h3>
                                                <p>
                                                      Es werden asynchron alle Online-Artikel abgerufen
                                                </p>
                                          </div>
                                          <div class="panel-body">

                                                <ul class="nav nav-tabs" role="tablist">
                                                      <li class="active"><a href="#test2" data-toggle="tab">Ausgabe</a></li>
                                                      <li><a href="#html2" data-toggle="tab">HTML/JS</a></li>
                                                      <li><a href="#php2" data-toggle="tab">PHP</a></li>
                                                </ul>
                                                <div class="tab-content" style="margin-top: 1.2em">
                                                      <div class="tab-pane fade in active" id="test2" data-code="1"> 
<button class="btn btn-primary" id="button2">Liste aller Online-Artikel anzeigen</button>
<div id="frame"></div>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
      $("#button2").click(function () {

            var request = $.ajax({
                  // URL aus PHP: $REX['ADDON']['aox_ajax']['settings']['CONTROLLER']
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
                                                      </div>
                                                      <div class="tab-pane fade" id="html2" data-code-target="1"></div>
                                                      <div class="tab-pane fade" id="php2">
                                                            <span class="resize">&uarr;&darr;</span>
                                                            <pre class="prettyprint" style="padding:1em;">
<?php echo htmlentities(file_get_contents($REX['FRONTEND_PATH'] . '/ajax/php/Beispiel/Sql.php')) ?>
                                                            </pre>
                                                      </div>
                                                </div>

                                          </div>
                                          <div class="panel-footer text-muted">
                                                <h5>Ablauf:</h5>
                                                <ol>
                                                      <li>Der Request erfolgt mittles <a href="http://api.jquery.com/jQuery.ajax/">jQuery</a> (geht natürlich auch mit einem anderen Framework oder auch ohne)</li>
                                                      <li>Der Request geht an den Ajax-Controller, welcher dann die in <code>PATH</code> angegebene Datei einbindet</li>
                                                      <li>Das REDAXO-Array beziehen wir aus der Controller-Klasse mit <code>self::$rex</code>, <a href="https://www.redaxo.org/de/wiki/index.php?n=R4.REXSQLBeispiele">rex_sql</a> und auch alle anderen Klassen und Funktionen stehen immer zur Verfügung</li>
                                                </ol>
                                                <h5>Files:</h5>
                                                <ul>
                                                      <li>JS: http://code.jquery.com/jquery-latest.min.js</li>
                                                      <li>PHP: <?php echo $REX['FRONTEND_PATH'] . '/ajax/php/Beispiel/Sql.php'; ?></li>
                                                </ul>
                                          </div>
                                    </div>

                              </section>
                              <!--
                                    --
                                    SECTION
                                    --
                              -->
                              <section class="col-lg-11">
                                    <div class="panel panel-default">
                                          <div class="panel-heading">
                                                <h3>3. Cross-Domain-Request mit jQuery</h3>
                                                <p>
                                                      Es werden die aktuellen Wechselkurse der EZB abgerufen. Das empfangene
                                                      XML müsste noch weiter verarbeitet werden.
                                                </p>
                                          </div>
                                          <div class="panel-body">
                                                <ul class="nav nav-tabs" role="tablist">
                                                      <li class="active"><a href="#test3" data-toggle="tab">Ausgabe</a></li>
                                                      <li><a href="#html3" data-toggle="tab">HTML/JS</a></li>
                                                </ul>
                                                <div class="tab-content" style="margin-top: 1.2em">
                                                      <div class="tab-pane fade in active" id="test3" data-code="1"> 
<button class="btn btn-primary" id="button3">Daten abrufen</button>
<div id="frame3"></div>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
      $("#button3").click(function () {

            var request = $.ajax({
                  // URL aus PHP: $REX['ADDON']['aox_ajax']['settings']['CONTROLLER']
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
                                                      </div>
                                                      <div class="tab-pane fade" id="html3" data-code-target="1"></div>
                                                </div>
                                          </div>
                                          <div class="panel-footer text-muted">
                                                <h5>Ablauf:</h5>
                                                <ol>
                                                      <li>Der Request erfolgt mittles <a href="http://api.jquery.com/jQuery.ajax/">jQuery</a> (geht natürlich auch mit einem anderen Framework oder auch ohne)</li>
                                                      <li>Der Request geht an den Ajax-Controller. Dieser erkennt dass es sich um eine URL in  <code>PATH</code> handelt und holt sich mittels <code>readfile()</code> die Ausgabe ab. Die Option <code>allow_url_fopen</code> muss aktiviert sein! </li>
                                                </ol>
                                                <h5>Files:</h5>
                                                <ul>
                                                      <li>JS: http://code.jquery.com/jquery-latest.min.js</li>
                                                </ul>
                                          </div>
                                    </div>
                              </section>
                              <!--
                                    --
                                    SECTION
                                    --
                              -->
                              <section class="col-lg-11">
                                    <div class="panel panel-default">
                                          <div class="panel-heading">
                                                <h3>4. einfacher XMLHttpRequest</h3>
                                                <p>
                                                      ...
                                                </p>
                                          </div>
                                          <div class="panel-body">
                                                <ul class="nav nav-tabs" role="tablist">
                                                      <li class="active"><a href="#test4" data-toggle="tab">Ausgabe</a></li>
                                                      <li><a href="#html4" data-toggle="tab">HTML/JS</a></li>
                                                      <li><a href="#php4" data-toggle="tab">PHP</a></li>
                                                </ul>
                                                <div class="tab-content" style="margin-top: 1.2em">
                                                      <div class="tab-pane fade in active" id="test4" data-code="1"> 
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
                                                      </div>
                                                      <div class="tab-pane fade" id="html4" data-code-target="1"></div>
                                                      <div class="tab-pane fade" id="php4">
                                                            <span class="resize">&uarr;&darr;</span>
                                                            <pre class="prettyprint" style="padding:1em;">
<?php echo htmlentities(file_get_contents($REX['FRONTEND_PATH'] . '/ajax/php/Beispiel/Hallo.php')) ?>
                                                            </pre>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="panel-footer text-muted">
                                                <h5>Ablauf:</h5>
                                                <ol>
                                                      <li>Wie beim ersten Test, nur ohne Javascript-Framework</li>
                                                </ol>
                                                <h5>Files:</h5>
                                                <ul>
                                                      <li>PHP: <?php echo $REX['FRONTEND_PATH'] . '/ajax/php/Beispiel/Hallo.php'; ?></li>
                                                </ul>
                                          </div>
                                    </div>
                              </section>
                              <!--
                                    --
                                    SECTIONS END
                                    --
                              -->
                        </div>
                  </div>
            </main>
            <footer>
                  <hr/>
                  <div class="container">
                        <p class="text-muted">License MIT - Copyright 2015 <a href="http://aoxwebdev.com/">aoxWebDev</a></p>
                  </div>
            </footer>
            <div id="loader"></div>
            <script>
                  $(document).ready(function ($) {

                        $('#loader').bind().fadeOut(900);

                        var testcodes = $('*[data-code]');

                        $.each(testcodes, function (i, val) {

                              var html = $(this).html();
                              var target = $(this).next('*[data-code-target]')
                              //target.css('position', 'relative');
                              html = htmlEntities(html);
                              target.append('<span class="resize">&uarr;&darr;</span>' +
                                      '<pre class="prettyprint" style="padding:1em;">' + html + '</pre>')
                              //target.html('<pre>' + html.toString() + '</pre>')

                        });

                        $(".resize").click(function () {
                              $(this).next('pre').toggleClass("big");
                        });

                        function htmlEntities(str) {
                              return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                        }

                        $.ajaxSetup({
                              beforeSend: function () {
                                    $('#loader').fadeIn(300)
                              },
                              complete: function () {
                                    $('#loader').fadeOut(800)
                              },
                              success: function () {
                              }
                        });

                        /*
                         * Navigation
                         */
                        var anchorId = 0;
                        $("section h3").each(function (index, value) {
                              anchorId++;
                              // Text auslesen
                              var text = $(this).text();
                              var name = 'section' + anchorId;
                              // Anker setzen
                              $(this).append('<a id="' + name + '" name="' + name + '" class="anchor" title="nach oben" href="#top">&uarr;</a>');
                              // Navi schreiben
                              $("nav#kapnav>ul").append('<li class="navlink"><a href="#' + name + '">' + text + '</a></li>');

                        });

                        /*
                         * Kapitel ansteuern
                         */
                        $('li.navlink>a').click(function () {
                              $('html, body').animate({
                                    scrollTop: $($.attr(this, 'href')).offset().top - 20 //problem mit url
                              }, 400);
                              return false;
                        });
                        $('h3>a').click(function () {
                              $('html, body').animate({
                                    scrollTop: $($.attr(this, 'href')).offset().top// - 25
                              }, 400);
                              return false;
                        });
                  });
            </script>
      </body>
</html>