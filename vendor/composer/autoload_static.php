<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite3bd81636dc7ff42b75ca5377feeeea3
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite3bd81636dc7ff42b75ca5377feeeea3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite3bd81636dc7ff42b75ca5377feeeea3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite3bd81636dc7ff42b75ca5377feeeea3::$classMap;

        }, null, ClassLoader::class);
    }
}
