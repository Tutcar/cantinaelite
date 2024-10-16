<?php
// define("SERVIDOR", "localhost");;
// define("BANCO", "tutca072_elite");
// define("USUARIO", "tutca072_elite");
// define("SENHA", "a_1t#lCD^esE");
// define("CHARSET", "UTF8");

define("SERVIDOR", "localhost");
define("BANCO", "cantinamace");
define("USUARIO", "root");
define("SENHA", "");
define("CHARSET", "UTF8");

define('CONTROLLER_PADRAO', 'homepage');
define('METODO_PADRAO', 'index');
define('NAMESPACE_CONTROLLER', 'app\\controllers\\');
define('TIMEZONE', "America/Campo_Grande");
define('CAMINHO', realpath('./'));
define("TITULO_SITE", "Cantina Elite");


define('URL_BASE', 'https://' . $_SERVER["HTTP_HOST"] . '/cantinaelite/');
define('URL_IMAGEM', "https://" . $_SERVER['HTTP_HOST'] . "/cantinaelite/UP/");
define('URL_IMAGEM_vaf', "https://" . $_SERVER['HTTP_HOST'] . "/cantinaelite/images/");



define("SESSION_LOGIN", "usuario_logado");

$config_upload["verifica_extensao"] = false;
$config_upload["extensoes"]         = array(".gif", ".jpeg", ".png", ".bmp", ".jpg");
$config_upload["verifica_tamanho"]  = true;
$config_upload["tamanho"]           = 3097152;
$config_upload["caminho_absoluto"]  = realpath('./') . '/';
$config_upload["renomeia"]          = true;
