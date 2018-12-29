<?php
use yii\helpers\Html;


use backend\assets\AppAsset;
use backend\assets\LoginAsset;
AppAsset::register($this);

LoginAsset::register($this);
//AppAsset::addCss($this,'@web/css/metronic/error.css');
//AppAsset::addCss($this,'@web/css/metronic/login.css');
//AppAsset::addJs($this,'@web/js/wdialog/wdialog.js');
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
</head>

<body class="login">
<?php $this->beginBody() ?>
	<div class="logo">
		
	</div>
	<!-- BEGIN LOGIN -->
	<div class="content">
		<?php echo $content;?>
	</div>
	<div class="copyright">
		2016 &copy; 管理后台
	</div>
	<?php $this->endBody() ?>
<script>
		 var handleUniform = function () {
				if (!jQuery().uniform) {
					return;
				}
				var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)");
				if (test.size() > 0) {
					test.each(function () {
							if ($(this).parents(".checker").size() == 0) {
								$(this).show();
								$(this).uniform();
							}
						});
				}
			}
		handleUniform()
	</script>
</body>
</html>
<?php $this->endPage() ?>
