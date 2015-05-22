<?php

// hata bildirimleri.
ini_set('display_errors',true);
error_reporting(E_ALL & ~E_NOTICE);

// session.
session_start();

// veritabanı sabitleri.
define('VT_SUNUCU','localhost');
define('VT_AD','gorev');
define('VT_KULLANICI','root');
define('VT_PAROLA','pass');

// sınıflar.
include_once('class/veritabani.class.php');
include_once('class/kisi.class.php');
include_once('class/gorev.class.php');

// fonksiyonlar.
include_once('fonksiyon.php');

?>