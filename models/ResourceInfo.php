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

    public static function zoneData($locale)
    {
        $r = ResourceBundle::create($locale, 'ICUDATA-zone');
        return self::dumpIntlResource($r);
    }

    private static function dumpIntlResource($r)
    {
        $result = [];
        foreach ($r as $k => $v) {
            if ($v instanceof ResourceBundle) {
                $result[$k] = self::dumpIntlResource($v);
            } else {
                $result[$k] = $v;
            }
        }
        return $result;
    }

    public static function getCurrencyName($iso, $locale)
    {
        return ResourceBundle::create($locale, 'ICUDATA-curr')->get('Currencies')->get($iso)[1];
    }
}
