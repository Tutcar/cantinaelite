<?php

use app\core\Excecao;

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_set_cookie_params(['lifetime' => 0, 'httponly' => true]);

session_start();

session_regenerate_id();

error_reporting(E_ALL & ~E_NOTICE);
require_once 'app/core/Core.php';
require_once 'app/helper/helper.php';
require_once 'app/helper/datahora.php';
require_once 'app/helper/numero.php';
require_once 'app/helper/rede.php';
require_once 'config/config.php';
require_once 'vendor/autoload.php';
date_default_timezone_set(TIMEZONE);

try {
    $core = new Core;
    $core->run();
} catch (Exception $e) {
    $erro = new Excecao($e);
    $erro->mostrar();
} catch (Error  $e) {
    $erro = new Excecao($e);
    $erro->mostrar();
}
