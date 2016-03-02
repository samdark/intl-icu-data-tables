<?php
use app\models\ResourceInfo;
use yii\bootstrap\Html;
use yii\helpers\Inflector;

/* @var $this yii\web\View */

/* @var $locale string */
/* @var $query string */
/* @var $title string */

echo $this->render('_locale', ['locale' => $locale, 'title' => 'ICU Language Data']);

if ($locale):
?>

<h2 id="icu-data-currency">ICU Language Data <small><a href="#icu-data-currency">#</a></small></h2>

<p>In PHP you may retrieve this data using the following code:</p>
<pre>
<?= '&lt;?php' ?>

$data = ResourceBundle::create('<?= Html::encode($locale) ?>', 'ICUDATA-lang');
foreach($data as $name => $value) {
    echo "$name: " . print_r($value, true);
}
</pre>

<?= $this->render('_icuData', ['icuData' => ResourceInfo::languageData($locale)]) ?>

<?php endif; ?>