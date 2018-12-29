<div class="header navbar navbar-inverse">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="navbar-inner">
		<div class="container-fluid">
			<!-- BEGIN LOGO -->
			<a class="brand" href="/">
				后台管理
			</a>
			<!-- END LOGO -->          
			<!-- BEGIN TOP NAVIGATION MENU -->              
			<ul class="nav pull-right">
				<li class="dropdown user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img alt="" src="<?php echo @Yii::$app->params["img_server"];?>/img/avatar.png" style="width:28px;height:28px"/>
					<span class="username"><?php echo @Yii::$app->user->identity->nickname;?></span>
					<i class="icon-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo @Yii::$app->params["adm_url"];?>/site/r-password" rel="nofollow"><i class="icon-edit"></i>  修改密码</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo @Yii::$app->params["adm_url"];?>/site/logout" rel="nofollow">退出</a></li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
			</ul>
		</div>
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>