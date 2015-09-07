<?php
use app\assetbundle\BackendAsset;
use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
BackendAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= Html::encode($this->title) ?></title>
        <?php
        // Css
        $this->registerCssFile($this->theme->baseUrl . '/font-awesome/css/font-awesome.min.css', ['depends' => \yii\bootstrap\BootstrapAsset::className()]);
        $this->registerCssFile($this->theme->baseUrl . '/css/style.css', ['depends' => \yii\bootstrap\BootstrapAsset::className()]);
        ?>
        <?php $this->head() ?>
    </head>

    <body class="gray-bg">
        <?php $this->beginBody() ?>
            <?php echo $content; ?>
        <?php $this->endBody() ?>
    </body>	
</html>
<?php $this->endPage() ?>