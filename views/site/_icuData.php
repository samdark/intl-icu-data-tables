<?php

use yii\bootstrap\Html;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

/* @var $this yii\web\View */
/* @var $icuData array */

if (isset($icuData['%%Parent'])) {
    echo '<p>Parent Locale: ' . Html::a(Html::encode($icuData['%%Parent']), ['', 'locale' => $icuData['%%Parent']]) . '</p>';
    unset($icuData['%%Parent']);
}

foreach($icuData as $key => $data) {
    $id = 'icu-data-' . Inflector::slug($key);
    echo "<h3 id=\"$id\">" . Html::encode($key) . " <small><a href=\"#$id\">#</a></small></h3>";
    echo '<pre>';
    VarDumper::dump($data, 10, true);
    echo '</pre>';
}
