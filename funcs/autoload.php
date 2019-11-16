<?php

class cc_builder{

    public function __construct($title, $subtitle) {
        $root = $_SERVER["DOCUMENT_ROOT"];
        $ipAddr = $_SERVER["SERVER_ADDR"];
        $host = $_SERVER["HTTP_HOST"];

        //var_dump($_SERVER);

        $this->phpWarnings();

        echo "<title>$title</title>";
        include "$root/include/head.php";
        include "$root/include/link.php";
        include "$root/funcs/neoTable.php";
        require ("/etc/rover/neoGenesis.php");

        echo '<div class="container">';
        echo "<br>";
        echo "<h2>$title</h2>";
        echo "<h4>$subtitle</h4>";
        echo "<br>";
        }

    public function phpWarnings() {
        ini_set('html_errors', true);
        ini_set('display_errors', true);
        error_reporting(E_ALL);
    }
}
?>