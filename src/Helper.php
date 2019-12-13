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
        self::getClassesFromDir(base_path('app/Http/Controllers'), $controllers);

        return $controllers;
    }

    public static function getActionsByController($controller): array
    {
        return get_class_methods($controller);
    }

    public static function extractClassName($file): string
    {
        $fp = fopen($file, 'r');
        $class = $namespace = $buffer = '';

        $i = 0;
        while (!$class) {
            if (feof($fp)) break;

            $buffer .= fread($fp, 512);
            $tokens = token_get_all($buffer);

            if (strpos($buffer, '{') === false) continue;

            for (; $i < count($tokens); $i++) {
                if ($tokens[$i][0] === T_CLASS) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j] === '{') {
                            $class = $tokens[$i + 2][1];
                        }
                    }
                }
                if ($tokens[$i][0] === T_NAMESPACE) {
                    for ($j = $i + 2; $j < count($tokens); $j++) {
                        if ($tokens[$j] === ';') {
                            break;
                        }

                        $namespace .= $tokens[$j][1];
                    }
                }
            }
        }

        fclose($fp);

        return $namespace . '\\' . $class;
    }

    public static function getClassesFromDir($dir, &$classes)
    {
        foreach (scandir($dir) as $file) {
            $path = "{$dir}/{$file}";
            if (!is_dir($path)) {
                if (self::extendsClass($path, 'Controller')) {
                    $classes[] = self::extractClassName($path);
                }
            } elseif ($file !== '.' && $file !== '..') {
                self::getClassesFromDir($path, $classes);
            }
        }
    }

    public static function extendsClass(string $file, string $ext_name): bool
    {
        $extends = $buffer = '';
        $fh = fopen($file, 'r');

        while (!$extends) {
            if (feof($fh)) break;

            $buffer = fread($fh, 512);

            if (strpos($buffer, '{') === false) continue;

            $tokens = token_get_all($buffer);


            for ($i = 0; $i < count($tokens); $i++) {
                if ($tokens[$i][0] === T_EXTENDS) {
                    $extends = $tokens[$i + 2];
                    if ($extends[1] == $ext_name) return true;
                }
            }
        }

        return false;
    }


}
