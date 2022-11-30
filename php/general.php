<?php

    /**
     * Debug de valores
     * @return void
     */
    function dd(...$valores) {
        array_map(function ($valor) {
            echo '<pre>';
            print_r($valor);
        }, $valores);
        exit;
    }

    /**
     * Retornar true caso o usuário esteja usando um dispositivo mobile
     * @return boolean
     */
    function disp_mobile() {
        return preg_match("
            /(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i",
            $_SERVER["HTTP_USER_AGENT"
        ]);
    }

    /**
     * Retornar os parametros na url passados como get
     * @param array $params: os parametros que serão buscados
     * @param string $retorno_padrao: valor padrao, caso não encontre o parametro procurado
     * @return array
     */
    function get_params_url($params = [], $retorno_padrao = false) {
        $resultado = [
        'params_array' => [],
        'params_url' => '',
        ];
        foreach ($params as $param) {
        $req = $_REQUEST[$param] ?? $retorno_padrao;
        
        $resultado['params_array'][$param] = $req;
        if (isset($_REQUEST[$param])) {
            $resultado['params_url'] .= "&$param=$req";
        }
        }
        return $resultado;
    }

    /**
     * Registra uma string na sessão
     * @return void
     */
    function register_msg_in_session($msg) {
        $_SESSION['msg'] = $msg;
    }

    /**
     * Retornar a msg salvar na sessão, após o retorno da função a msg é excluída da sessão
     * @return string
     */
    function display_session_msg() {
        if(isset($_SESSION['msg'])) {
            $message = $_SESSION['msg'];
            unset($_SESSION['msg']);
            return $message;
        }
    }