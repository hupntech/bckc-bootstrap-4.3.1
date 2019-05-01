<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitacee1da13240b0d16f02817461e089b0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitacee1da13240b0d16f02817461e089b0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitacee1da13240b0d16f02817461e089b0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}