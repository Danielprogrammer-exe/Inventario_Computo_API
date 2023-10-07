<?php

class Date
{
    const HUMAN_DATE = 'd/m/Y';
    const HUMAN_TIME = 'h:i a'; //12:24 p. m.
    const HUMAN_DATETIME = 'd/m/Y h:i a';
    const SYSTEM_DATE = 'Y-m-d';
    const SYSTEM_TIME = 'H:i:s';
    const SYSTEM_DATETIME = 'Y-m-d H:i:s';
    const TEXT = 'd MMMM y'; //28 octubre 2022
    const XLSX = '(YYYY-MM-DD)';

    static $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    static $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
        'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    static $months_short = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SET', 'OCT', 'NOV', 'DIC'];


    public $timestamp;

    protected $_parts;

    public function __construct($timestamp = null)
    {
        $this->timestamp = $timestamp
            ? is_numeric($timestamp)
                ? $timestamp
                : strtotime($timestamp)
            : time();
    }


    public static function now($formatOutput = 'Y-m-d H:i:s') {
        date_default_timezone_set('America/Lima');
        return date($formatOutput);
    }

    /**
     * @param $datetime
     * @return int|void
     * Obtener la fecha y hora actual
     * Si le pasas datetime como parametro: '2023-05-13 14:30:00'
     */
    public static function timestamp($datetime = '')
    {
        if(empty($datetime)){
            return time();
        }else{
            return strtotime($datetime);
        }
    }

    public function humanDate()
    {
        return date('d/m/Y', $this->timestamp);
    }

    public function humanTime()
    {
        return date('h:i A', $this->timestamp);
    }

    public function humanDatetime()
    {
        return date('d/m/Y H:m', $this->timestamp);
    }

    public function verboseDatetime($onlyDate = false)
    {
        $dayWeek = $this->sDayWeek(); # dia de la semana
        $dayMonth = $this->part('mday'); # dia del mes sin ceros
        $month = $this->sMonth();
        $year = $this->part('year');

        $result = $dayWeek . ', ' . $dayMonth . ' de ' . strtolower($month) . ' de ' . $year;

        if (!$onlyDate) {
            $result .= ' a las ' . $this->humanTime();
        }

        return $result;
    }

    public function verboseDate()
    {
        return $this->verboseDatetime(true);
    }

    public function sHour()
    {
        $hour = $this->part('hours');

        if ($hour <= 6) {
            return 'madrugada';
        } else if ($hour <= 12) {
            return 'mañana';
        } else if ($hour <= 18) {
            return 'tarde';
        } else {
            return 'noche';
        }
    }

    public function sDayWeek()
    {
        $dayWeek = $this->part('wday');
        return isset(self::$days[$dayWeek]) ? self::$days[$dayWeek] : '';
    }

    public function sMonth()
    {
        $month = $this->part('mon') - 1;
        return isset(self::$months[$month]) ? self::$months[$month] : '';
    }


    // calcular tiempo transcurrido: 'hace 1 min'
    public function ago($short = false)
    {
        $periods = $short
            ? ['seg', 'min', 'hor', 'día', 'sem', 'mes', 'año', 'dec']
            : ['seg', 'min', 'hora', 'día', 'sem', 'mes', 'año', 'dec'];
        $lengths = ['60', '60', '24', '7', '4.35', '12', '10'];

        $difference = $this->timestamp - time();
        if ($short) {
            $prefx = $difference < 0 ? '-' : '+';
        } else {
            $prefx = $difference < 0 ? 'Hace' : 'En';
        }
        $difference = abs($difference);

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1 && !$short) {
            if ($lengths[$j] == '12')
                $periods[$j] .= 'e';
            $periods[$j] .= 's';
        }

        return $prefx . ' ' . $difference . ' ' . $periods[$j];
    }

    public function age()
    {
        $dob = new DateTime();
        $dob->setTimestamp($this->timestamp);
        $now = new DateTime();
        $difference = $now->diff($dob);
        return $difference->y;
    }

    public function sAge()
    {
        if ($age = $this->age()) {
            return $age . ' años';
        } else {
            return '';
        }
    }

    public function year()
    {
        return $this->part('year');
    }

    public function format($format = 'Y-m-d H:i:s')
    {
        return date($format, $this->timestamp);
    }

    function parts()
    {
        if (!$this->_parts)
            $this->_parts = getdate($this->timestamp);
        return $this->_parts;
    }

    function part($part)
    {
        return $this->parts()[$part];
    }


    /**
     * Converter [datetime or date] -> time: [time() PHP]
     * @param $datetime
     * @return false|int
     */
    public static function datetimeToSeg($datetime)
    {
        return strtotime($datetime);
    }

    //TODO: Check si una fecha está dentro de un rango de fechas
    //time() >= Util::datetimeToSeg($o->date_start) && time() <= Util::datetimeToSeg($o->date_end)
    public static function whereBetween($datetimeDB, $dateStart, $dateEnd)
    {
        return $datetimeDB >= self::datetimeToSeg($dateStart) && $datetimeDB <= self::datetimeToSeg($dateEnd);
    }

    /**
     * @param $day
     * @param $dateInit
     * @return string
     * Sumar dias a la fecha actual: return: YYYY-MM-DD
     * $dateInit: si es null: add days a fecha actual
     * si no pasas ningun parametro, return 'date now'
     */
    public static function addDays($day = 0, $dateInit = null)
    {
        return  date('Y-m-d', strtotime(is_null($dateInit)
            ? '+'.$day.' days'
            : $dateInit. '+'.$day.' days'));
    }
    public static function sustractDays($day = 0, $dateInit = null)
    {
        return  date('Y-m-d', strtotime(is_null($dateInit)
            ? '-'.$day.' days'
            : $dateInit. '-'.$day.' days'));
    }

    #Check si un datetime db ya pasó
    public static function hasPassed($datetimeDB)
    {
        return self::datetimeToSeg($datetimeDB) > time();
    }

    public static function hasNotPassed($datetimeDB)
    {
        return self::datetimeToSeg($datetimeDB) < time();
    }

    #Get los ultimos años
    public static function getAnios($cant = 10)
    {
        $yearNow = intval(date("Y"));
        $rsp = [];
        for ($i = 0; $i < $cant; $i++) {
            $rsp[$i] = $yearNow - $i;
        }
        return $rsp;
    }

    /**
     * @param $fecha
     * @return string
     * Convertir un formato de fecha a cualquier otro
     * input: str
     * output: str
     * Skoy
     */

    public static function convertAny($date, $formatInput = 'Y-m-d', $formatOutput = 'd-m-Y') {
        if(empty($date) || is_null($date)){
            return '';
        }
        $newDate = DateTime::createFromFormat($formatInput, $date);
        return $newDate ? $newDate->format($formatOutput) : '';
    }

    /**
     * @param $date
     * '2023-05-19 20:00' IS VALID?
     */
    static function isValidDatetime($datetime)
    {
        return str_contains($datetime, ' ');
    }

    /**
     * @param $hora
     * @return array|string|string[]|null
     * '7:00' => '07:00'
     */
    static function completarCeroAlInicioHora($hora) {
        return preg_replace('/^(\d):/', '0$1:', $hora);
    }

    static function isHoraEnRango($hora, $horaInicio, $horaFin) {
        $horaActual = DateTime::createFromFormat('H:i:s', $hora);
        $inicio = DateTime::createFromFormat('H:i:s', $horaInicio);
        $fin = DateTime::createFromFormat('H:i:s', $horaFin);

        if ($horaActual === false || $inicio === false || $fin === false) {
            return '';
        }

        return $horaActual >= $inicio && $horaActual <= $fin;
    }

    /**
     * @param $datetime
     * @param $formatExtract
     * @return string
     * Puedes extraer cual parte de un datetime: hora, fecha y en el formato que quieras
     */
    static function extractPart($datetime, $formatExtract = Date::SYSTEM_TIME) {
        return date($formatExtract, strtotime($datetime));
    }

    # HELPERS

    public static function ins($time = null)
    {
        return new static($time);
    }

    public function __toString()
    {
        return $this->format();
    }


}
