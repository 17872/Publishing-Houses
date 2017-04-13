<?php
    
define('PUBLISHING_HOUSE', TRUE);
define('PATH_PLUGIN', realpath(dirname(__FILE__).'/') );

/*
Plugin Name: Public Houses
Plugin URI: http://www.example.com
Description: Description Public Houses
Version: 1
Author: Public Houses Author
Author URI: http://www.example.com
*/

add_action('admin_menu', 'PublicHousesAdminMenu');

function PublicHousesActivation()
{
    global $wpdb;

    $TableTowns = $wpdb->prefix . 'PH_Towns';
    $TablePublishingHouses = $wpdb->prefix . 'publishing_houses';
    $TableComics = $wpdb->prefix . 'comics';

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    if($wpdb->get_var("SHOW TABLES LIKE '$TableTowns'") != $TableTowns) {
        $sql = "CREATE TABLE IF NOT EXISTS `$TableTowns` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

            INSERT INTO `$TableTowns` (`id`, `name`) VALUES
            (1, 'New-York'),
            (2, 'Boston'),
            (3, 'Chikago'),
            (4, 'San-Francisco');";        
        dbDelta($sql);
    }

    if($wpdb->get_var("SHOW TABLES LIKE '$TablePublishingHouses'") != $TablePublishingHouses) {
        $sql = "CREATE TABLE IF NOT EXISTS `$TablePublishingHouses` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `logo` varchar(255) NOT NULL,
          `town` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";        
        dbDelta($sql);
    }

    if($wpdb->get_var("SHOW TABLES LIKE '$TableComics'") != $TableComics) {
        $sql = "CREATE TABLE IF NOT EXISTS `$TableComics` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `logo` varchar(255) NOT NULL,
          `house` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";        
        dbDelta($sql);
    }
}

function PublicHousesDeactivation()
{
    global $wpdb;
}

function PublicHousesAdminMenu()
{
    add_options_page('PublicHouses', 'PublicHousesAdmin', 8, __FILE__, 'defAdminAction');
}

function defAdminAction()
{
    include __DIR__ . '/templ/index.admin.php';
}

function DefRoute()
{
    include __DIR__ . '/templ/index.default.php';
}


register_activation_hook(__FILE__, 'PublicHousesActivation');

register_deactivation_hook(__FILE__, 'PublicHousesDeactivation');

add_shortcode( 'publishing_house', 'DefRoute' );

?>