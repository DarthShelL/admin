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

    public static function getControllers(): array
    {
        $controllers = [];
        self::getFilesFromDir(base_path('app/Http/Controllers'), $controllers);

        return $controllers;
    }

    public static function getFilesFromDir($dir, &$files)
    {
        foreach (scandir($dir) as $file) {
            if (!is_dir("{$dir}/{$file}")) {
                $files[] = basename($file);
            } elseif ($file !== '.' && $file !== '..') {
                self::getFilesFromDir("{$dir}/{$file}", $files);
            }
        }
    }
}
