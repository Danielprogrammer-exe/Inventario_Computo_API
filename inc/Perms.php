<?php

namespace Inc;

use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Inc\utils\Util;
use Libs\Pixie\QB;
use PHPUnit\Util\PHP\DefaultPhpProcess;
use stdClass;

class Perms
{
    /* @var Perms */
    private static $ins;

    public static function ins()
    {
        if (!static::$ins) static::$ins = new static;
        return static::$ins;
    }

    public static function newIns()
    {
        static::$ins = new static;
        return static::$ins;
    }

    private $home           = 'home';
    private $menu           = [];
    private $current_module = null;

    public function __construct()

    {
        $this->loadPerms();
    }

    public function loadPerms()
    {
        $menus = DB::table('perms as pe')
            ->select(
                'mo.id',
                'mo.name',
                'mo.url',
                'mo.icon',
                'mo.section',
                'mo.badge',
                'pe.see',
                'mo.id_parent',
                'pe.edit',
            )
            ->join('modules as mo', 'mo.id', '=', 'pe.id_module')
            ->where('pe.id_role', Auth::user()->id_role)
            ->where('mo.state', 1)
            ->orderBy('mo.sort')
            ->get();

        if ($menus) {
            foreach ($menus as $menu) {
                $this->menu[] = $menu;
                if (false && $menu->id == Auth::user()->ro_id_module)
                    $this->home = $menu->url;
                // Modulo Actual
                if (false && $menu->url == _controller::$module) {
                    $this->current_module = $menu;
                }
            }
        }
        /*if ($menus) {
            $this->menu = $menus;
        }*/
    }

    public function loadPermsFuncional()
    {
        $menus = DB::table('modules as mo')
            ->select(
                'mo.*',
            )
            ->where('mo.state', 1)
            ->orderBy('mo.sort')
            ->get();
        if ($menus) {
            $this->menu = $menus;
        }
    }


    /**
     * @return stdClass|null
     */
    public static function current()
    {
        return self::ins()->current_module;
    }

    /**
     * @param $module
     * @return stdClass|null
     */
    public static function getItem($module)
    {
        foreach (self::ins()->menu as $item) {
            if ($item->url == $module) {
                return $item;
            }
        }
        return null;
    }

    /***
     * Saber si tiene permiso de lectura
     * @param array $modules : si envia NULL se refiere al modulo actual
     * @return bool
     */
    public static function see($modules = [])
    {
        # si es root tiene acceso a todos
        if (Auth::root()) return true;
        # verificar si tiene acceso al modulo actual
        $mod = self::current();
        if ($mod && $mod->see == 1) return true;

        # si paso otros modulos, tambien lo verificamos
        if ($modules) {
            foreach (self::ins()->menu as $item) {
                if ($item->url && in_array($item->url, $modules)) {
                    if ($item->see == 1) {
                        return true;
                    }
                }
            }
        }

        return false;
    }


    /* @return array : Menu principal */
    public static function menu()
    {
        $items = [];
        foreach (self::ins()->menu as $item) {
            $items[$item->id] = (object)[
                'id'        => $item->id,
                'id_parent' => $item->id_parent,
                'title'     => $item->name,
                'type'      => $item->section ? 'group' : 'item',
                'icon'      => $item->icon,
                'see'       => ($item->see ?? 1) == '1',
                'edit'      => ($item->edit ?? 1) == '1',
                'url'       => $item->url ? '/' . $item->url : '',
                'badge'     => $item->badge ?? '',
            ];
        }
        return $items;
    }

    public static function menuAcs()
    {
        $items = [];
        foreach (self::ins()->menu as $item) {
            if ($item->see == 1) {
                $items[$item->id] = (object)[
                    'id'        => $item->id,
                    'id_parent' => $item->id_parent,
                    'title'     => $item->name,
                    'type'      => $item->section ? 'group' : 'item',
                    'icon'      => $item->icon,
                    'see'       => $item->see == '1',
                    'edit'      => $item->edit == '1',
                    'url'       => $item->url ? '/' . $item->url : '',
                    'badge'     => $item->badge ?? '',
                ];
            }
        }
        return $items;
    }


    public static function menuSorted()
    {
        return Util::ordMenu(self::menu());
    }

}
