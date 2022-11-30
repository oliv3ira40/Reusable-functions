<?php

    /**
     * Verifica se a página atual é a home
     * @return boolean
     */
    add_action('wp', 'check_home');
    function check_home() {
        if(is_home() || is_front_page()) return true;
        return false;
    }

    /**
     * Retornar imagem padrão do tema
     * @return string
     */
    function get_default_img() {
        global $barra;
        $caminho = get_template_directory_uri()."{$barra}assets{$barra}imgs{$barra}img-default.jpg";

        return $caminho;
    }

    /**
     * Função para reduzir o tamanho total da img, utilizando a função de redimencionamento nativa do WordPress,
     * e tenta utilizar a versão webp(caso exista) da imagem fornecida
     * 
     * Observação - 1: Esta função utiliza as urls das imgs já convertidas para o formato webp pelo plugin "Webp Express"
     * Observação - 2: Uso indicado em imagens que não passam pelo tratamento padrão do plugin "Webp Express", exemplo: imagens trazidas via ajax
     * @param integer $id_img: id da imagem a ser reduzida
     * @param mixed $redimencionar: usar padrões aceitos pela função "wp_get_attachment_image_src"
     * @return string
     */
    function reduce_size_img($id_img, $redimencionar = [700, 0]) {
        $img = wp_get_attachment_image_src($id_img, $redimencionar)[0];

        $url_img_webp = str_replace('uploads', 'webp-express/webp-images/uploads', $img.'.webp');
        $caminho_img_webp = str_replace(home_url(), '', $url_img_webp);
        $existe_img_webp = file_exists($_SERVER['DOCUMENT_ROOT'].$caminho_img_webp);
        if ($existe_img_webp) $img = $url_img_webp;

        return $img;
    }

/**
     * Identifica se o site está rodando em uma maquina local
     * @return boolean
     */
    function exec_local() {
        if(
            str_contains(get_site_url(), 'localhost') OR
            str_contains(get_site_url(), 'localhost')
        ) return false;
        return true;
    }
    
    /**
     * Retorna as páginas possiveis para paginação a partir da página atual
     * @return array
     */
    function get_pagination($pagina_atual, $num_links, $pagina_max) {
        $links = [];
        $link_meio = floor($num_links / 2);

        $contador = 1;
        if ($pagina_atual > 1 AND $pagina_atual <= $pagina_max) {
            $contador = abs($pagina_atual - $link_meio);
            if($contador < 1) $contador = 1;
        }

        if ($pagina_max < $num_links) $num_links = $pagina_max;
        for ($contador; count($links) < $num_links ; $contador++) { 
            if ($contador > $pagina_max) {
                array_push($links, min($links) - 1);
            } else { array_push($links, $contador); }
        }

        sort($links);
        return $links;
    }

    function format_date($date) {
        return date_i18n('M, d, Y', strtotime($date));
    }

    /**
     * Cria um menu personalizado para comportar todas as configurações/registros da página inicial
     * @return void
     */
    function custom_menu_ch() {
        add_menu_page('Config Home', 'Config Home', 'manage_options', 'menu-config-home', false, 'dashicons-admin-generic', 21);
    }
    add_action('admin_menu', 'custom_menu_ch');
    
    function custom_menu_chc() {
        add_menu_page('Config Home de categorias', 'Config Home de categorias', 'manage_options', 'menu-config-home-category', false, 'dashicons-admin-generic', 21);
    }
    add_action('admin_menu', 'custom_menu_chc');
    
    /**
     * Retorna as categorias já criadas, buscando pela taxonomia "category"
     * @return array
     */
    function custom_get_categories() {
        global $wpdb;
        $query = $wpdb->prepare("
            SELECT t.term_id as id, t.name, t.slug
            FROM wp_term_taxonomy tt
                RIGHT JOIN wp_terms t ON (tt.term_id = t.term_id)
            WHERE (UPPER(tt.taxonomy) IN ('category'))
                AND t.term_id != %1\$d", 1
        );
        $results = $wpdb->get_results($query);

        if (empty($results)) return info_result_not_found();
        return $results;
    }