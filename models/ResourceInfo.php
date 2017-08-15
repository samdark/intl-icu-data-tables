<?php
namespace app\models;

use ResourceBundle;
use yii\base\Object;

/**
 * ResourceInfo provides various info about resource bundles
 * @author Carsten Brandt <mail@cebe.cc>
 */
class ResourceInfo extends Object
{
    public static function defaultData($locale)
    {
        $r = ResourceBundle::create($locale, null);
        return self::dumpIntlResource($r);
    }

    public static function currencyData($locale)
    {
        $r = ResourceBundle::create($locale, 'ICUDATA-curr');
        return self::dumpIntlResource($r);
    }

    public static function languageData($locale)
    {
        $r = ResourceBundle::create($locale, 'ICUDATA-lang');
        return self::dumpIntlResource($r);
    }

    public static function regionData($locale)
    {
        $r = ResourceBundle::create($locale, 'ICUDATA-region');
        return self::dumpIntlResource($r);
    }

    public static function unitData($locale)
    {
        $r = ResourceBundle::create($locale, 'ICUDATA-unit');
        return self::dumpIntlResource($r);
    }

    public static function zoneData($locale)
    {
        $r = ResourceBundle::create($locale, 'ICUDATA-zone');
        return self::dumpIntlResource($r);
    }

    private static function dumpIntlResource($resourceBundle)
    {
        return self::recursiveIteratorToArray($resourceBundle);
    }

    private static function recursiveIteratorToArray($iterator)
    {
        if ($iterator === null) {
            return [];
        }

        return array_map(function ($item) {
            return $item instanceof \ResourceBundle ? self::recursiveIteratorToArray($item) : $item;
        }, iterator_to_array($iterator));
    }

    public static function getCurrencyName($iso, $locale)
    {
        return ResourceBundle::create($locale, 'ICUDATA-curr')->get('Currencies')->get($iso)[1];
    }
}
