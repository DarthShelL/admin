<?php


namespace DarthShelL\Admin;


class Helper
{
    private static $menu_handler;

    public static function getMenu(): Menu
    {
        if (is_null(static::$menu_handler)) {
            static::$menu_handler = new Menu();
        }
        return static::$menu_handler;
    }
}
