<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdcb7b0e665f0de3cedb6fe8105788d3f
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Notihnio\\RequestParser\\' => 23,
            'Notihnio\\MultipartFormDataParser\\' => 33,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Notihnio\\RequestParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/notihnio/php-request-parser/src',
        ),
        'Notihnio\\MultipartFormDataParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/notihnio/php-multipart-form-data-parser/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdcb7b0e665f0de3cedb6fe8105788d3f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdcb7b0e665f0de3cedb6fe8105788d3f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
