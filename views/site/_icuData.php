<?php

use yii\bootstrap\Html;
use yii\helpers\Inflector;

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
    print_r($data);
    echo '</pre>';
}
