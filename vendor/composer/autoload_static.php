<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc197979d2e5a93202ee19f1c065975ae
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

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc197979d2e5a93202ee19f1c065975ae::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc197979d2e5a93202ee19f1c065975ae::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc197979d2e5a93202ee19f1c065975ae::$classMap;

        }, null, ClassLoader::class);
    }
}