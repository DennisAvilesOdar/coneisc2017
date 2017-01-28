<?php

    session_name("sisconeii2017");
    session_start();
    unset($_SESSION["s_nombres"]);
    unset($_SESSION["s_correo"]);
    unset($_SESSION["s_codigo_usuario"]);
    
    session_destroy();