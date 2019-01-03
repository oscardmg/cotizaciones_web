<?php

class Utiles
{
    public static function redireccionar($lugar)
    {
        header("Location: " . BASE_URL . "/?p=$lugar");
        exit;
    }

    public static function salirSiTokenCSRFNoCoincide($token)
    {
        if (!self::esTokenCSRFValido($token)) {
            exit("<h1>El token CSRF no coincide</h1>");
        }
    }

    public static function generar_token_seguro($longitud)
    {
        if ($longitud < 4) {
            $longitud = 4;
        }

        return bin2hex(random_bytes(($longitud - ($longitud % 2)) / 2));
    }

    public static function esTokenCSRFValido($token)
    {
        #Aquí iniciamos la sesión si no está iniciada, esto es para leer el token que guardamos anteriormente
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        return hash_equals($_SESSION["token_csrf"], $token);
    }

    public static function obtenerTokenCSRF()
    {
        # Sólo iniciamos la sesión si no la iniciamos antes
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $token = self::generar_token_seguro(40);
        $_SESSION["token_csrf"] = $token;
        return $_SESSION["token_csrf"];
    }

}