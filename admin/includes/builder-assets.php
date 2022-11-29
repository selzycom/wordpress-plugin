<?php
function wpselzy_get_builder_css_urls()
{
    $plugin_root_url = WPSELZY_PLUGIN_URL;
    $plugin_root_dir = WPSELZY_PLUGIN_DIR;
    $builder_assets_dir = $plugin_root_dir . DIRECTORY_SEPARATOR . 'builder' . DIRECTORY_SEPARATOR . 'dist';
    $builder_css_dir = $builder_assets_dir . DIRECTORY_SEPARATOR . 'css';
    $dist_root_url = $plugin_root_url . '/builder/dist';

    $css_urls = [];
    $chunk_files = glob($builder_css_dir . DIRECTORY_SEPARATOR . 'chunk*.css');
    foreach ($chunk_files as $chunk_file) {
        $css_urls[$chunk_file] = $dist_root_url . '/css/' . basename($chunk_file);
    }

    $app_files = glob($builder_css_dir . DIRECTORY_SEPARATOR . 'app*.css');
    foreach ($app_files as $app_file) {
        $css_urls[$app_file] = $dist_root_url . '/css/' . basename($app_file);
    }

    return $css_urls;
}

function wpselzy_get_builder_js_urls()
{
    $plugin_root_url = WPSELZY_PLUGIN_URL;
    $plugin_root_dir = WPSELZY_PLUGIN_DIR;
    $builder_assets_dir = $plugin_root_dir . DIRECTORY_SEPARATOR . 'builder' . DIRECTORY_SEPARATOR . 'dist';
    $builder_js_dir = $builder_assets_dir . DIRECTORY_SEPARATOR . 'js';
    $dist_root_url = $plugin_root_url . '/builder/dist';

    $js_urls = [];
    $chunk_files = glob($builder_js_dir . DIRECTORY_SEPARATOR . 'chunk*.js');
    foreach ($chunk_files as $chunk_file) {
        $js_urls[$chunk_file] = $dist_root_url . '/js/' . basename($chunk_file);
    }

    $app_files = glob($builder_js_dir . DIRECTORY_SEPARATOR . 'app*.js');
    foreach ($app_files as $app_file) {
        $js_urls[$app_file] = $dist_root_url . '/js/' . basename($app_file);
    }

    return $js_urls;
}