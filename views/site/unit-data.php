<?php
use app\models\ResourceInfo;
use yii\bootstrap\Html;

/* @var $this yii\web\View */

/* @var $locale string */
/* @var $query string */
/* @var $title string */

echo $this->render('_locale', ['locale' => $locale, 'title' => 'ICU Unit Data']);

if ($locale):
?>

<h2 id="icu-data-unit">ICU Unit Data <small><a href="#icu-data-unit">#</a></small></h2>

<p>In PHP you may retrieve this data using the following code:</p>
<pre>
<?= '&lt;?php' ?>

$data = ResourceBundle::create('<?= Html::encode($locale) ?>', 'ICUDATA-unit');
foreach($data as $name => $value) {
    echo "$name: " . print_r($value, true);
}
</pre>

<?= $this->render('_icuData', ['icuData' => ResourceInfo::unitData($locale)]) ?>

<?php endif; ?>