
<style>
      code {
            background: #fff; color: darkred;
      }
</style>
<div class="rex-addon-output">
	<h2 class="rex-hl2">AJAX Framework <?php echo $I18N->msg('aox_ajax_page_help') ?></h2>
	<div class="rex-area-content">
            <p>
                  Mit diesem kleinen Framework kann man seine AJAX-Komponenten besser verwalten.
                  Jeder AJAX-Request läuft über den Controllen <code>/ajax/index.php</code> .
                  Bei jedem Request muss der Parameter <code>PATH</code> mitgesendet werden.
                  Damit sagt man dem Controller welche Datei erforderlich ist. Optional
                  können mit <code>DATA</code> beliebige Daten gesendet werden.
                  Der Contoller empfängt die Daten mit <code>$_REQUEST[]</code>, somit kann entweder
                  mit <code>get</code> oder mit <code>post</code> gearbeitet werden.
            </p>
            <br/>
            <h3>
                  Der Contoller versteht drei verschiedene Arten von Pfad-Angaben
            </h3>
            <ul>
                  <li>
                        <code>Beispiel/Hallo.php</code> das ist der empfohlene Weg. Dabei erwartet
                        der Controller die benötigte Datei im Verzeichnis <code>/ajax/php</code>
                        zu finden. Dieses Verzeichnis ist von aussen geschützt.
                  </li>
                  <li>
                        <code>/MeinVerzeichnis/test.php</code> durch den führenden Schrägstrich
                        sucht der Controller vom REDAXO Frontent-Path aus, also von dem Pfad aus wo Redaxo 
                        installiert ist.
                  </li>
                  <li>
                        <code>http://meineDomain-oder-eine-andere.com/</code> Durch die Angabe eines 
                        Protokolls stellt der Controller einen Stream her. Dies ist auch auf andere 
                        Domains möglich (Cross-Origin Resource Sharing). Der Server welcher den
                        Request empfangen soll, muss jedoch den Zugriff erlauben.
                  </li>
            </ul>
            <h3>Beispiele und Hilfe</h3>
            
            <ul>
                  <li>
                        Quellcode - 
                        <a href="https://github.com/webghostx/aox_ajax" target="_blank">github</a>
                  </li>
                  <li>
                        Code-Beispiele -
                        <a href="https://github.com/webghostx/aox_ajax/wiki" target="_blank">Wiki</a>
                  </li>
                  <li>
                        Probleme -
                        <a href="https://github.com/webghostx/aox_ajax/issues" target="_blank">Issues</a>
                  </li>
            </ul>
            
            <h3>Testseite</h3>
            <p>
                  Für Tests oder als Beispiel kann auch folgendes Template in REDAXO angelegt werden. Das 
                  Template hat keine Artikel-Ausgabe, sondern beinhaltet nur einige Tests. Es reicht daher
                  einen leeren Atikel anzulegen und das Template zu wählen.
            <pre id="tmplPre" style="margin: 1em;padding: 1em;background: #fff;border: 1px solid #ccc; max-height: 400px; overflow: auto">
<?php echo htmlentities(file_get_contents(realpath($REX['INCLUDE_PATH'] . '/addons/aox_ajax/install_files/template.php'))); ?>
            </pre>
            </p>
	</div>
</div>
<script type="text/javascript">
(function () {
      var tmplPre = document.getElementById('tmplPre');
      tmplPre.onclick = function () {
            if (document.selection) {
                  var range = document.body.createTextRange();
                  range.moveToElementText(document.getElementById('tmplPre'));
                  range.select();
            }
            else if (window.getSelection) {
                  var range = document.createRange();
                  range.selectNode(document.getElementById('tmplPre'));
                  window.getSelection().addRange(range);
            }
      }
})();
</script>