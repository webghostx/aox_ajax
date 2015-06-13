<?php
class aoxAjaxController {

      public static $rex = array();               // REX array
      public static $request = array();           // Ziel des Requests
      public static $debug = NULL;
      //
      private static $logFile = '';
      private static $requestData = Null;          // die gesendeten Daten
      private static $requestPath = '';            // 
      private static $requestParam = array();      // Optionen zur Steuerung
      private static $setting = array();           // Einstellungen des Addons

      public static function run($rex, $request, $debug = false) {

            self::$rex = $rex;
            self::$request = $request;
            self::$debug = $debug;

            self::setAttributes();
            self::forwardRequest();

            return true;
      }

      public static function forwardRequest() {

            $slashPos = strpos(self::$requestPath, '/');
            $slashslashPos = strpos(self::$requestPath, '//');

            // URL //
            if ($slashslashPos !== false) {
                  self::stream();
                  return true;
            }

            // Interner Pfad auf /ajax/php
            if ($slashPos > 0 || $slashPos === false) {
                  self::$requestPath = self::$setting['PHP_DIR'] . '/' . self::$requestPath;
                  self::inclusion();
                  return true;
            }

            // Absoluter Pfad vom DOCUMENT_ROOT aus
            if ($slashPos === 0) {
                  self::inclusion();
                  return true;
            }

            self::log('ERROR: Der Pfad konnte nicht aufgelöst werden!', true);
            return;
      }

      public static function streamConnection() {

            $addr = gethostbyname("www.example.com");

            $client = stream_socket_client("tcp://$addr:80", $errno, $errorMessage);

            if ($client === false) {
                  throw new UnexpectedValueException("Failed to connect: $errorMessage");
            }

            fwrite($client, "GET / HTTP/1.0\r\nHost: www.example.com\r\nAccept: */*\r\n\r\n");
            echo stream_get_contents($client);
            fclose($client);
      }

      public static function stream() {

            try {
                  #ob_start();
                  readfile(self::$requestPath);
                  #$data = ob_get_clean();
                  #echo htmlentities($data);
            } catch (Exception $e) {
                  header('HTTP/1.1 404 Not Found');
                  self::log('ERROR: Die Stream-Verbindung konnte nicht erstellt werden!', true);
            }
      }

      public static function inclusion() {

            try {
                  if (!file_exists(self::$requestPath)) {

                        header('HTTP/1.1 404 Not Found');
                        self::log('ERROR: Die Zieldatei konnte nicht eingebunden werden! (' . self::$requestPath . ')', true);
                  } else {
                        require_once(self::$requestPath);
                  }
            } catch (Exception $e) {

                  $exit = false;

                  if (stripos($e->getMessage(), 'ERROR') === 0)
                        $exit = true;

                  if ($exit)
                        header('HTTP/1.1 400 Bad Request');

                  self::log($e->getMessage() . " /Code: " . $e->getCode(), $exit);
            }
            return;
      }

      /**
       * Setzt alle Eigenschaften
       */
      public static function setAttributes() {

            if (isset(self::$rex['ADDON']['aox_ajax']['settings'])) {
                  self::$setting = self::$rex['ADDON']['aox_ajax']['settings'];
            } else {
                  self::log('ERROR: Addon Settings können nicht geladen werden!', true);
            }

            if (isset(self::$request['DATA'])) {
                  self::$requestData = self::$request['DATA'];
            } else {
                  //self::log('WARNING: Der Request erfolgte ohne Daten zu übermitteln!');
            }

            if (isset(self::$request['PATH'])) {
                  self::$requestPath = self::$request['PATH'];
            } else {
                  self::log('ERROR: Es wurde kein Zielpfad übermittelt!', true);
            }

            if (isset(self::$request['PARAM'])) {
                  self::$requestParam = self::$request['PARAM'];
            } else {
                  //self::log('INFO: Es werden standard Parameter verwendet!');
            }

            return;
      }

      /**
       * Schreibt einen Eintrag in ein Logfile
       * 
       * @param string $msg
       * @param bool $exit - optional - wenn true wird exit() ausgeführt
       * @return 
       */
      private static function log($msg, $exit = false) {

            if (self::$logFile === '' && isset(self::$rex['ADDON']['aox_ajax']['settings']['LOG_FILE']))
                  self::$logFile = self::$rex['ADDON']['aox_ajax']['settings']['LOG_FILE'];

            if (self::$debug && self::$logFile !== '')
                  error_log('[' . date(DATE_RFC822) . '] ' . $msg . PHP_EOL, 3, self::$logFile);

            if ($exit === true)
                  exit();

            return;
      }

}