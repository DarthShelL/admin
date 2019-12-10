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

//        $meth = [];
//        foreach ($controllers as $controller) {
//            $meth[$controller] = get_class_methods($controller);
//        }
//        dd($meth);
//        dd(get_class_methods(self::extractClassName(base_path('app/Http/Controllers') . '/Auth/ForgotPasswordController.php')));

        return $controllers;
    }

    public static function getActionsByController($controller)
    {
    }

    public static function extractClassName($file)
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

        return $namespace . '\\' . $class;
    }

    public static function getClassesFromDir($dir, &$classes)
    {
        foreach (scandir($dir) as $file) {
            if (!is_dir("{$dir}/{$file}")) {
                $classes[] = self::extractClassName("{$dir}/{$file}");
            } elseif ($file !== '.' && $file !== '..') {
                self::getClassesFromDir("{$dir}/{$file}", $classes);
            }
        }
    }
}
