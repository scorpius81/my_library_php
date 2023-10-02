<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd553648631023c1f003823948f73c9ea
{
    public static $files = array (
        '1d0b0faaf7045a9cddf4a8240738d14e' => __DIR__ . '/../..' . '/src/utils.php',
    );

    public static $prefixLengthsPsr4 = array (
        'g' => 
        array (
            'gsensale\\MyLibraryPhp\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'gsensale\\MyLibraryPhp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd553648631023c1f003823948f73c9ea::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd553648631023c1f003823948f73c9ea::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd553648631023c1f003823948f73c9ea::$classMap;

        }, null, ClassLoader::class);
    }
}
