<?php

/**
 * @package JabagoGallery
 */
namespace JabagoG_Inc;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class JabagoGalleryInit
{
    public static function getServices(){
        return [
            Pages\JabagoGalleryDashboard::class,
            Base\JabagoGalleryEnqueue::class,
            // Base\SettingsLinks::class
        ];
    }

    private static function instantiate($class){
        return new $class;
    }

    public static function registerServices(){
        
        foreach (self::getServices() as $class) {
            $service = self::instantiate( $class );
            if( method_exists($service, 'register')){
                $service->register();
            }
        }
    }
}