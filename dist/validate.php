<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
if (isset($_COOKIE["auth"]))
    echo 0;
else
    echo 1;
