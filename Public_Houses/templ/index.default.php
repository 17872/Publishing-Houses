<?
    defined('PUBLISHING_HOUSE') || exit('NOT ACCESS'); 

    global $wpdb;

    $_POST['Publ_houses'] = htmlspecialchars( number_format($_POST['Publ_houses']) );

    

    class ContAct
    {

        public static function getSelectHouses()
        {
            global $wpdb;

            $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."publishing_houses");

            foreach ( $results as $key => $value )
            {
                echo '<option value="'.$value->id.'">'.$value->name.'</option>'. "\r\n";
            }
        }

        public static function getComics( $House = NULL )
        {
            global $wpdb;

            if ( $House == 0 ) $House = FALSE;

            $SqlHouse = "SELECT * FROM ".$wpdb->prefix."comics" . ($House ? ' WHERE house = '.$House : '');

            $results = $wpdb->get_results( $SqlHouse );

            if ( count($results) > 0 ) {

                foreach ( $results as $key => $value )
                {
                    echo '<p>' . $value->name . '</p>' ."\r\n";
                }

            } elseif( $House ) {
                echo '<h2>По данной категории комиксы не найдены!</h2>';
            } else {
                echo '<h2>В базе данных отсутствуют комиксы!</h2>';
            }
        }

    }

?>
<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
    <p><label>Фильтр по издательству:
        <select name="Publ.houses">
            <? if( $_POST['Publ_houses'] && $_POST['Publ_houses'] !== 0 ) : ?>
            <option value="<?=$_POST['Publ_houses']?>"><?= $wpdb->get_var( "SELECT name FROM " . $wpdb->prefix . "publishing_houses WHERE id = " . $_POST['Publ_houses'] )?></option>
            <?endif;?>
            <option value="0">Издательство:</option>
            <?=ContAct::getSelectHouses()?>
        </select>
    </label></p>
    <p><button type="submit" value="true" name="actFilter">Отфильтровать</button></p>
</form>
<? if ( $_POST['actFilter'] && $_POST['Publ_houses'] ) : ?>
<?=ContAct::getComics($_POST['Publ_houses'])?>
<? else : ?>
<?=ContAct::getComics()?>
<? endif; ?>