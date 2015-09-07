<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo \yii\helpers\Html::encode($name) ?></title>

    <?php
    $this->registerCssFile($this->theme->baseUrl . '/font-awesome/css/font-awesome.css', ['depends' => \yii\bootstrap\BootstrapAsset::className()]);
    $this->registerCssFile($this->theme->baseUrl . '/css/animate.css', ['depends' => \yii\bootstrap\BootstrapAsset::className()]);
    $this->registerCssFile($this->theme->baseUrl . '/css/style.css', ['depends' => \yii\bootstrap\BootstrapAsset::className()]);
    
    $this->head();
    ?>
</head>
<body class="gray-bg">
    <?php $this->beginBody() ?>
    <div class="middle-box text-center animated fadeInDown">
        <!--<h1>Error</h1>-->
        <h3 class="font-bold"><?= $name ?></h3>
        <div class="error-desc">
            <?= $message ?>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

