<?php

// database

function con_db() {
    $con = mysqli_connect('localhost', 'root', '');
    mysqli_set_charset($con, 'utf8');
    mysqli_select_db($con, 'weinhandel_test');
    return $con;
}

function uncon_db($con) {
    @mysqli_close($con);
}

function id_benutzer_check() {
    if (isset($_SESSION['benutzer'])) {
        $kunde='<a class="button" href="#">'
                .$_SESSION['benutzer']
                .'</a>';
    } else {
        $kunde='<a class="button" href="#">login/regis</a>';
    }
    $kunde.='<a class="button" href="#">Warenkorp</a>';
    return $kunde;
}
function list_output($table) {
    $con = con_db();
    if ($table == 'produkt') {
        $sql = 'SELECT produkt_nummer,produkt_name,produkt_beschr,produkt_preis FROM produkt';
    } else {
        
    }

    $res = mysqli_query($con, $sql);
    $list = '';
    while ($zeil = mysqli_fetch_assoc($res)) {
        $list .= '<div class="pro">';

        //bild
        $list .= '<div class="bildUndName">';
        $list .= '<img src="images/weinbilder/klein/w'
                . $zeil['produkt_nummer']
                . '.jpg" onerror="this.src=\'images/weinbilder/klein/blank.jpg\' ">';


        //name und kürzbeschreibung
        $list .= '<a href="#">' . $zeil['produkt_name']
                . '</a><br>'
                . $zeil['produkt_beschr'];
        $list .= '</div>';
        //Preis,Menge und Warenkorp
        $list .= '<div class="mengeUndWarenkorp"><br>';
        $list .= $zeil['produkt_preis'] . ' €/stück';
        $list .= ' <input type="button" class="warenkorp" value="warenkorp">';
        $list .= '<input type="button" class="operation" value="-" onclick="operation(\'-\','
                . $zeil['produkt_nummer'] . ')">';
        $list .= ' <input type="text" name="menge" id="'
                . $zeil['produkt_nummer']
                . '" size="3" value="1" onkeyup="menge_pruefen('
                . $zeil['produkt_nummer'] . ')">';
        $list .= '<input type="button" class="operation" value="+" onclick="operation(\'+\','
                . $zeil['produkt_nummer'] . ')">';

        $list .= '</div>';
        $list .= '</div>';
    }
    uncon_db($con);
    return $list;
}

//template
function load_tpl($load) {
    global $template;
    $template = file_get_contents($load);
}

function tpl_output() {
    global $template;
    echo $template;
}
