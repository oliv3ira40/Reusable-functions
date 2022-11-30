<?php

    /**
     * Remove o campo de img destacada nativo do Wordpress, remoção feita no post_type "post"
     */
    add_action('init','remove_thumbnail_support_post');
    function remove_thumbnail_support_post() {
        remove_post_type_support('post', 'thumbnail');
    }

    /**
     * Remove o campo padrão de data padrão do Wordpress da lista de posts (Desativado temporariamente)
     * @return void
     */
    function my_remove_date_filter($months) {
        global $typenow;
        if ($typenow == 'post') return array();
        return $months;
    }
    add_filter('months_dropdown_results', 'my_remove_date_filter');

    /**
     * Adiciona novo campo de filtro de visualizações por data
     * @return void
     */
    function date_filter_post_list() {
        $after = (isset($_GET['af']) AND !empty($_GET['af'])) ? $_GET['af'] : false;
        $before = (isset($_GET['be']) AND !empty($_GET['be'])) ? $_GET['be'] : false;
        require_once plugin_dir_path(dirname(__FILE__)) . 'views/date-filter-field.php';
    }
    add_action('restrict_manage_posts', 'date_filter_post_list');
    
    /**
     * Aplica o filtro de data customizado a listagem de posts (Desativado temporariamente)
     * @return void
     */
    function custom_date_query_filter($admin_query) {
        global $pagenow;
        $post_type = (isset($_GET['post_type'])) ? $_GET['post_type'] : 'post';

        if ($post_type == 'post' && $pagenow == 'edit.php' && isset($_GET['af']) && !empty($_GET['af'])) {
            $admin_query->set(
                'date_query',
                array(
                    'after' => sanitize_text_field($_GET['af']),
                    'before' => sanitize_text_field($_GET['be']),
                    'inclusive' => true, // include the selected days as well
                    'column' => 'post_date'
                )
            );
        }
        return $admin_query;
    }
    add_action('pre_get_posts', 'custom_date_query_filter');

    // ----------

    /**
     * Exibi a coluna "Data do feriado" na lista de feriados
     * @return void
     */
    add_filter('manage_goals_analytics_posts_columns', function($columns) {
        $offset = array_search('date', array_keys($columns));
        return array_merge(
            array_slice($columns, 0, $offset),
            [
                '_record_goal' => 'Meta de registros',
                '_start_date_goal' => 'Data inicial',
                '_end_date_goal' => 'Data final',
            ],
            array_slice($columns, $offset, null)
        );
    });

    /**
     * Trata o resultado exibido na coluna "Data do feriado"
     * @return void
     */
    add_action('manage_goals_analytics_posts_custom_column', function($column_key, $post_id) {

        switch ($column_key) {
            case '_record_goal':
                $data_pm = get_post_meta($post_id, $column_key, true);
            
                if ($data_pm) {
                    echo '<span class="txt-muted txt-bold">'.$data_pm.'</span>';
                } else { echo '<span>—</span>'; }

                break;
            case '_start_date_goal':
                $data_pm = get_post_meta($post_id, $column_key, true);
            
                if ($data_pm) {
                    echo '<span class="txt-muted txt-bold">'.date('d/m/Y', strtotime($data_pm)).'</span>';
                } else { echo '<span>—</span>'; }

                break;
            case '_end_date_goal':
                $data_pm = get_post_meta($post_id, $column_key, true);
            
                if ($data_pm) {
                    echo '<span class="txt-muted txt-bold">'.date('d/m/Y', strtotime($data_pm)).'</span>';
                } else { echo '<span>—</span>'; }

                break;
            default:
                break;
        }
    }, 10, 2);

    // ----------