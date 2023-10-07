<?php namespace Inc;

use App\Models\Setting;
use stdClass;

class STG extends stdClass
{
    public $module = '';
    //public $url_api = env('URL_API');
    //public $url_web = URL_WEB;

    private static $ins;

    static function ins()
    {
        if (!self::$ins) {
            self::$ins = new self();
            $os = Setting::all('name', 'value');
            foreach ($os as $o) {
                self::$ins->{$o->name} = $o->value;
            }

            self::$ins->interval = self::$ins->interval + 0;
            self::$ins->lat = (self::$ins->lat ?? '0') + 0;
            self::$ins->lng = (self::$ins->lng ?? '0') + 0;
            self::$ins->debug = env('APP_DEBUG');
        }
        return self::$ins;
    }

    static function get($name)
    {
        return self::ins()->$name;
    }

    static function bool($name)
    {
        return self::get($name) == 1;
    }

    static function num($name)
    {
        return self::get($name) + 0;
    }

    static function set($name, $value)
    {
        return self::ins()->$name = $value;
    }

    static function all()
    {
        return self::ins();
    }

}
