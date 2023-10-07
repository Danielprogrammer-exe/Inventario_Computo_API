<?php

use App\Models\Pair;
use App\Models\Par;
use Inc\Pic;
use Inc\Rsp;
use Inc\STG;
use Inc\View;
/*SON URLS INTERNOS DEL SERVER. EXAMPE: /var/www/html/skoy.pe/api*/
/*$path_env = _PATH_ . '/inc/__ENV.php';
const URL_INTERNAL_VIEWS = _PATH_ . '/views';
const URL_INTERNAL_UPLOADS = _PATH_ . '/uploads';*/

# GLOBALS MESSAGES CRUD
const MSG_INSERT = 'Guardado correctamente';
const MSG_UPDATE = 'Actualizado correctamente';
const MSG_DELETE = 'Eliminado correctamente';
const MSG_ERROR = 'Ocurrió un error';

/*
if (file_exists($path_env)) {
    require $path_env;
} else {
    done('Es posible que el código del cliente no exista o esté pendiente.');
}*/

/* Metodo GET */
function _GET($name, $default_value = '')
{
    $val = @trim(@$_GET[$name]);
    return !empty($val) ? $val : $default_value;
}

function _GET_DATE($name, $default_value = '')
{
    $val = @trim(@$_GET[$name]);
    return !empty($val) && Util::isDate($val) ? $val : $default_value;
}

function _GET_INT($name, $default_value = 0)
{
    $val = @$_GET[$name];
    return is_numeric($val) ? $val : $default_value;
}

/* Metodo POST */
function _POST($name, $default_value = '')
{
    $val = @trim(@$_POST[$name]);
    return !empty($val) ? $val : $default_value;
}

function _POST_DATE($name, $default_value = '')
{
    $val = @trim(@$_POST[$name]);
    return !empty($val) && Util::isDate($val) ? $val : $default_value;
}

function _POST_INT($name, $default_value = 0)
{
    $val = @$_POST[$name];
    return is_numeric($val) ? $val : $default_value;
}

function _POST_ARR($name, $default_value = [])
{
    $val = @$_POST[$name];
    return is_array($val) ? $val : $default_value;
}

/* Metodo REQUEST */
function _REQ($name, $default_value = '')
{
    $val = @trim(@$_REQUEST[$name]);
    return !empty($val) ? $val : $default_value;
}

function _REQ_DATE($name, $default_value = '')
{
    $val = @trim(@$_REQUEST[$name]);
    return !empty($val) && Util::isDate($val) ? $val : $default_value;
}

function _REQ_INT($name, $default_value = 0)
{
    $val = @$_REQUEST[$name];
    return is_numeric($val) ? $val : $default_value;
}

function _REQ_ARR($name, $default_value = [])
{
    $val = @$_REQUEST[$name];
    return is_array($val) ? $val : $default_value;
}

/**
 * @param $name : ejm: Namespace\Class
 * @return string
 */
function real_class($name)
{
    if ($pos = strrpos($name, '\\')) {
        $name = substr($name, $pos + 1);
    }
    return $name;
}

/**
 * @param $name
 * @param $vars => Data dinámica para pasarle al template
 * @return View
 * Renderizar vistas
 * Directamente apunta a: /views
 * Puedes abrir el contenido de un .tpl [Automáticamente pone '.tp']
 * Example: view('pdf/voucher', ['item' => []])
 * OJO => funciona igual que: file_get_contents(_PATH_ . '/views/pdf/test.tpl'); (El plus es que puedes pasarle data dinámica)
 * Laravel ya tiene una funcion llamada view
 */
function view_($name, $vars = null)
{
    $view = new View();
    $view->name($name);

    if ($vars) {
        foreach ($vars as $k => $v) {
            $view->set($k, $v);
        }
    }

    return $view;
}

function rsp($p1 = null, $p2 = null)
{
    $rsp = new Rsp();

    if (is_bool($p1)) {
        $rsp->set('ok', $p1);
    } else if (!is_null($p1)) {
        $rsp->set('msg', $p1);
    }

    if (is_bool($p2)) {
        $rsp->set('ok', $p2);

    } else if (!is_null($p2)) {
        $rsp->set('msg', $p2);
    }

    return $rsp;
}

function par($id, $nombre)
{
    return new Par($id, $nombre);
}

function pair($id, $name)
{
    return new Pair($id, $name);
}

/**
 * Importaciones: insertDataByUrl
 * Method default: 'create'
 */

function insertDataByUrl($data = [], $nameController = '')
{
    $url = env('URL_API'). "/admin/" . $nameController . "/create";

    set_time_limit(0);
    return Util::curlUrl("POST", $url, $data, [
        //'Authorization: ' . Auth::getAuthorizationHeader(),
        'Content-Type: application/json'
    ]);
}

/**
 * Obtener total, obtener uno u asignar setting
 * @param string $name : si es nulo, asumiremos que quiere obtener todo
 * @param mixed $value : si no es nulo, asumiremos que se quiere asignar un valor
 * @return mixed
 */
function stg($name = null, $value = null)
{
    if (is_null($value)) {
        return STG::get($name);
    } else {
        return STG::set($name, $value);
    }
}

/**
 * @param $text
 */
function done($text)
{
    Util::done_rsp($text);
}

//...
function explod($str, $separator = ',')
{
    return empty($str) ? [] : explode($separator, $str);
}

function pic($pic, $thumb = false)
{
    return Pic::url($pic, $thumb);
}

function coin($amount)
{
    return Util::coin($amount);
}

function coin_format($amount, $decimals = 2)
{
    return number_format($amount, $decimals, ',', '.');
}

function human_date($date)
{
    return Util::humanDate($date);
}

function human_datetime($datetime)
{
    return Util::humanDatetime($datetime);
}

function human_time($datetime)
{
    return Util::humanTime($datetime);
}

function verbose_datetime($datetime)
{
    return Util::verboseDatetime($datetime);
}

function verbose_date($datetime)
{
    return Util::verboseDate($datetime);
}

function ago($datetime, $short = false)
{
    return Util::ago($datetime, $short);
}

function doc($num)
{
    return Util::doc($num);
}

function validaRUT($rut)
{
    $rut = preg_replace('/[^k0-9]/i', '', $rut);
    $dv = substr($rut, -1);
    $numero = substr($rut, 0, strlen($rut) - 1);
    $i = 2;
    $suma = 0;
    foreach (array_reverse(str_split($numero)) as $v) {
        if ($i == 8)
            $i = 2;

        $suma += $v * $i;
        ++$i;
    }

    $dvr = 11 - ($suma % 11);

    if ($dvr == 11)
        $dvr = 0;
    if ($dvr == 10)
        $dvr = 'K';

    if ($dvr == strtoupper($dv))
        return true;
    else
        return false;
}

$path_uploads = null;
/**
 * Obtener la ruta de uploads
 */
function uploads()
{
    global $path_uploads;
    if (is_null($path_uploads)) {
        $path_uploads = _PATH_ . '/uploads';
    }
    return $path_uploads;
}

function url_uploads()
{
    return env('URL_API') . '/uploads';
}

/**
 * Obtener la ruta de una carpeta de carga
 * Se creara la carpeta si no existe
 * @param string $folder
 * @return string
 */
function upl($folder)
{
    $path = uploads() . $folder;
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    return $path;
}

function me()
{
    //return Auth::user();
}

function in_array_key($source, $key, $value)
{
    return !empty(array_filter($source, function ($so) use ($key, $value) {
        return $so->{$key} == $value;
    }));
}

//new functions
function debugOutput($data)
{
    $format = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}

function dep($data)
{
    debugOutput(isBoolConvertStr(isNull($data)));
    exit;
}

function isBoolConvertStr($valor) {
    if (is_bool($valor)) {
        return $valor ? '1': '0';
    } else {
        return $valor;
    }
}

function isNull($valor) {
    return is_null($valor) ? 'IS NULL': $valor;
}

function depNoExit($data)
{
    debugOutput($data);
}

function getDateDB()
{
    //2022-02-25 now()
    date_default_timezone_set('America/Lima');
    return date('Y-m-d');
}

function getDayNow()
{
    $timestamp = strtotime(getDateDB());
    $day = date('D', $timestamp);
    return $day;
}

function timeCustom($time, $Addsegundo = false)
{
    //04:18:00 -> 14 h 18 min 30 seg
    $time_f = explode(":", $time);

    if ($Addsegundo) {
        return intval($time_f[0]) . ' h ' . intval($time_f[1]) . ' min ' . intval($time_f[2]) . ' seg';
    } else {
        return intval($time_f[0]) . ' h ' . intval($time_f[1]) . ' min ';
    }
}

function dateTextES($fecha)
{
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    //return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
    return $nombredia . " " . $numeroDia . " de " . $nombreMes . " " . $anio;
}

/**
 * Format value porcentaje
 */
function formatPorcDreams($value)
{
    return round($value) . '% ';
}

function getIGV($addSymbol = true)
{
    return \stg('igv').' %';
}

function apiWhatsapp($number, $text = "")
{
    /**
     * El numero si es a nivel de Perú -> puede ir sin codigo -> +51
     * https://api.whatsapp.com/send/?phone=951696362&text&type=phone_number&app_absent=0
     */
    $cleanNumber = validateNumberWhats($number);
    return 'https://api.whatsapp.com/send/?phone=' . $cleanNumber . '&text=' . $text . '&type=phone_number';
}

function validateNumberWhats($number)
{
    $numberClean = '';
    if (!empty($number)) {
        /*quitamos todos los espacios en blanco*/
        $number = str_replace(" ", "", $number);
        if (strlen($number) >= 9 && $number[0] === '9') {
            $numberClean = '+51' . $number;
        }else {
            $numberClean = $number;
        }
    }
    return $numberClean;
}

function mapPoint($point)
{
    return "https://www.google.com/maps/search/?api=1&query=$point->lat,$point->lng";
}

/**
 * REST API: Routes => trazar trayectoria A -> B
 * https://www.google.com/maps/dir/-12.0240527,-77.112036/-12.1267843,-77.0323501
 */

function mapDir($points)
{
    $text = "";
    foreach ($points as $point) {
        $text .= "/";
        $text .= @$point->lat;
        $text .= ",";
        $text .= @$point->lng;
    }

    return "https://www.google.com/maps/dir" . $text;
}

# Badge
function WChip($message = '', $background = '#616161', $color = '#FFFFFF')
{
    $smarty = new Smarty;
    $smarty->setTemplateDir('views');
    $smarty->assign('stg', STG::all());
    $smarty->assign('config', (object)['background' => $background, 'color' => $color]);
    $smarty->assign('data', (object)['message' => $message]);
    return $smarty->fetch('general/WChip.tpl');
}

# Badge
function WBadge($message = '', $background = '#616161', $color = '#FFFFFF')
{
    $smarty = new Smarty;
    $smarty->setTemplateDir('views');
    $smarty->assign('stg', STG::all());
    $smarty->assign('config', (object)['background' => $background, 'color' => $color]);
    $smarty->assign('data', (object)['message' => $message]);
    return $smarty->fetch('general/WBadge.tpl');
}

#Text bold
function WBold($message = '', $color = '#000000')
{
    $smarty = new Smarty;
    $smarty->setTemplateDir('views');
    $smarty->assign('stg', STG::all());
    $smarty->assign('config', (object)['color' => $color]);
    $smarty->assign('data', (object)['message' => $message]);
    return $smarty->fetch('general/WBold.tpl');
}

function WText($message = '', $color = '#FFFFFF')
{
    $smarty = new Smarty;
    $smarty->setTemplateDir('views');
    $smarty->assign('stg', STG::all());
    $smarty->assign('config', (object)['color' => $color]);
    $smarty->assign('data', (object)['message' => $message]);
    return $smarty->fetch('general/WText.tpl');
}

function WLink($url, $message = '', $target = '_blank', $color = '#000000')
{
    $smarty = new Smarty;
    $smarty->setTemplateDir('views');
    $smarty->assign('stg', STG::all());
    $smarty->assign('config', (object)['color' => $color]);
    $smarty->assign('data', (object)['url' => $url, 'message' => $message, 'target' => $target]);
    return $smarty->fetch('general/WLink.tpl');
}
