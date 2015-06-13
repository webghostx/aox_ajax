## AJAX Framework

Mit diesem kleinen Addon kann man seine AJAX-Komponenten besser verwalten. Jeder AJAX-Request läuft über den Controllen `/ajax/index.php` . Bei jedem Request muss der Parameter `PATH` mitgesendet werden. Damit sagt man dem Controller welche Datei erforderlich ist. Optional können mit `DATA` beliebige Daten gesendet werden. Der Contoller empfängt die Daten mit `$_REQUEST[]`, somit kann entweder mit `get` oder mit `post` gearbeitet werden.

### Der Contoller versteht drei verschiedene Arten von Pfad-Angaben

*   `Beispiel/Hallo.php` das ist der empfohlene Weg. Dabei erwartet der Controller die benötigte Datei im Verzeichnis `/ajax/php` zu finden. Dieses Verzeichnis ist von aussen geschützt.
*   `/MeinVerzeichnis/test.php` durch den führenden Schrägstrich sucht der Controller vom REDAXO Frontent-Path aus, also von dem Pfad aus wo Redaxo installiert ist.
*   `http://meineDomain-oder-eine-andere.com/` Durch die Angabe eines Protokolls stellt der Controller einen Stream her. Dies ist auch auf andere Domains möglich (Cross-Origin Resource Sharing). Der Server welcher den Request empfangen soll, muss jedoch den Zugriff erlauben.

### Beispiele und Hilfe

*   Quellcode - [github](https://github.com/webghostx/aox_ajax)
*   Code-Beispiele - [Wiki](https://github.com/webghostx/aox_ajax/wiki)
*   Probleme - [Issues](https://github.com/webghostx/aox_ajax/issues)