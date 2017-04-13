<?
    defined('PUBLISHING_HOUSE') || exit('NOT ACCESS');    

    global $wpdb;

    $DEBUG = FALSE;

    class AdmAct
    {

        public static function getAcExt( $filename = NULL )
        {
            $ext = explode(".", $filename);

            $ext = $ext[count($ext)-1];

            if( $ext=="jpg" || $ext=="JPG" || $ext=="png" || $ext=="jpeg" )
            {
                return TRUE;

            } else {
                return FALSE;
            }
        }

        public static function SelectTowns()
        {
            global $wpdb;

            $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."PH_Towns");

            foreach ( $results as $key => $value )
            {
                echo '<option value="'.$value->id.'">'.$value->name.'</option>'. "\r\n";
            }
        }
    
        public static function SelectHouses()
        {
            global $wpdb;

            $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."publishing_houses");

            foreach ( $results as $key => $value )
            {
                echo '<option value="'.$value->id.'">'.$value->name.'</option>'. "\r\n";
            }
        }   

    }

    if ( $_POST['ACT_PUBLISHING_HOUSES_ACT'] ) :

        $ResInsert = $wpdb->insert( $wpdb->prefix . 'publishing_houses', array( 'name' => $_POST['name'], 'logo' => $_FILES['picture']['name'], 'town' => $_POST['town'] ), array( '%s','%s','%d' )  ); 

        if( AdmAct::getAcExt( $_FILES['picture']['name'] ) ) $ResUploadPicture = move_uploaded_file($_FILES['picture']['tmp_name'], PATH_PLUGIN . '/static_upload/' . $_FILES['picture']['name'] );

        if( $ResInsert && $ResUploadPicture )
        {
            echo '<h3>Запись успешно добавлена!</h3>';
        } else {
            echo '<h3>Что то пошло не так!</h3>';
        }

    endif;

    if ( $_POST['ACT_COMICS_ACT'] ) :

        $ResInsert = $wpdb->insert( $wpdb->prefix . 'comics', array( 'name' => $_POST['name'], 'logo' => $_FILES['picture']['name'], 'house' => $_POST['house'] ), array( '%s','%s','%d' )  ); 

        $ResUploadPicture = move_uploaded_file($_FILES['picture']['tmp_name'], PATH_PLUGIN . '/static_upload/' . $_FILES['picture']['name'] );

        if( $ResInsert && $ResUploadPicture )
        {
            echo '<h3>Запись успешно добавлена!</h3>';
        } else {
            echo '<h3>Что то пошло не так!</h3>';
        }

    endif;

    if ( $DEBUG ) :
        echo '<pre>';
        print_r( $_POST );
        echo "\r\n";
        print_r( $_FILES );
        echo '<pre>';
    endif;
?>
<div>   
    <form method="post" enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>">
        <? if ( $_POST['ACT_PUBLISHING_HOUSES'] ) : ?>         
        <h2>Добавление - Publishing Houses</h2>
        <p><label>Название: <input name="name" type="text" required></label></p>
        <p><label>Город: 
            <select name="town">
              <option value="0">Город</option>
              <?=AdmAct::SelectTowns()?>
            </select>
        </label></p>
        <p><label>Картинка: <input accept="image/*,image/jpeg" name="picture" type="file" required></label></p>
        <p><input class="button button-primary button-large" name="ACT_PUBLISHING_HOUSES_ACT" type="submit" value="Отправить"></p>
        <? endif; ?>
        <? if ( $_POST['ACT_COMICS'] ) : ?> 
        <h2>Добавление - Comics</h2>
        <p><label>Название: <input name="name" type="text" required></label></p>
        <p><label>Город: 
            <select name="house">
              <option value="0">Издательство</option>
              <?=AdmAct::SelectHouses()?>
            </select>
        </label></p>
        <p><label>Картинка: <input accept="image/*,image/jpeg" name="picture" type="file" required></label></p>
        <p><input class="button button-primary button-large" name="ACT_COMICS_ACT" type="submit" value="Отправить"></p>

        <? endif; ?>
        <? if ( !$_POST['ACT_PUBLISHING_HOUSES'] && !$_POST['ACT_COMICS'] ) : ?>
            <h2>Выберите действие для заполнения формы</h2>
            <button type="submit" value="true" class="button button-primary button-large" name="ACT_PUBLISHING_HOUSES">Издательство</button><button value="true" style="margin-left: 10px;" class="button button-primary button-large" type="submit" name="ACT_COMICS">Комикс</button>
        <? endif; ?>
    </form>
</div>