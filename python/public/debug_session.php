<?php
session_start();
echo "<h1>Current Session Data</h1>";
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
echo "<hr>";
echo "<p><a href='/python/public/menu'>Back to Menu</a></p>";
