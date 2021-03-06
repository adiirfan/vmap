<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5b50f14919cf540eb6536b288073ea3b
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Adldap\\Tests\\' => 13,
            'Adldap\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Adldap\\Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'Adldap\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5b50f14919cf540eb6536b288073ea3b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5b50f14919cf540eb6536b288073ea3b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
