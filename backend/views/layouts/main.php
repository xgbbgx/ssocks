<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
AppAsset::addCss($this,'@web/css/adm.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .row{margin-left:30px;}
    </style>
</head>
<body class="page-header-fixed">
	<?php $this->beginBody() ?>
	<?php include(dirname(__FILE__)."/include/header.php");?>
	<div class="page-container" style="margin-top: 0px;">
		<?php include(dirname(__FILE__)."/include/left.php");?>
		<div class="page-content">
			<div class="container-fluid">
			<div class="space20"></div>
			<?= Breadcrumbs::widget([  
			    'homeLink'=>[
			        'label' => '<i class="icon-home"></i>' . Html::encode(Yii::t('yii', 'Home')),
			        'url' => Yii::$app->homeUrl,
			        'encode' => false,
			     ],
                'itemTemplate'=>"<li>{link}<i class=\"icon-angle-right\"></i></li>",
                'activeItemTemplate'=>"<span>{link}</span>",
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
			<?php echo $content;?>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="footer-inner">
			2018 &copy; 自由人
		</div>
		<div class="footer-tools">
			<span class="go-top">
			<i class="icon-angle-up"></i>
			</span>
		</div>
	</div>
	<?php $this->endBody() ?>
</body>
	<script>
		jQuery(document).ready(function() {    
		   App.init();
		});
	</script>
</html>
<?php $this->endPage() ?>
