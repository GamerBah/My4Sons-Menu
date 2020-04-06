<?php
if (isset($_COOKIE["auth"]) && $_COOKIE['auth'] === "admin")
    echo 0;
else
    echo 1;
