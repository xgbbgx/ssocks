<?php 
use mdm\admin\components\MenuHelper;
?>
<div class="page-sidebar nav-collapse collapse">
	<!-- BEGIN SIDEBAR MENU -->        
	<ul class="page-sidebar-menu">
		<li>
			<div class="sidebar-toggler hidden-phone"></div>
		</li>
		<li>
			<form class="sidebar-search">
				<div class="input-box">
					<a href="javascript:;" class="remove"></a>
					<input type="text" placeholder="Search..." />
					<input type="button" class="submit" value=" " />
				</div>
			</form>
		</li>
		<li class="start">
			<a href="" rel="nofollow">
			<i class="icon-home"></i> 
			<span class="title"><?=Yii::t('common', 'home')?></span>
			<span class="selected"></span>
			</a>
		</li>
<?php
    $mainLeftRout='/'.Yii::$app->controller->getRoute();
    $i=0;foreach (MenuHelper::getAssignedMenu(\Yii::$app->user->id) as $k=>$p_menu) {
    if(!empty($p_menu['items'])){
        $if_menu=0;
        $url=parse_url($_SERVER["REQUEST_URI"]);
        $url_arr =  array_filter(explode("/", $url['path']));
        $url_items=$item_arr=[];
        //根据URL判断显示
        foreach($p_menu['items'] as $val){
            if($val['url'][0]){
                $item_arr = array_filter(explode("/", $val['url'][0]));
            }
            $url_items[]=$item_arr[1];
        }
        if(isset($url_arr[1]) && in_array($url_arr[1], $url_items)){
            $if_menu=1;
        }
  ?>
		<li class="<?php echo $if_menu==1?'active':''; ?>">
			<a href="javascript:;">
			<i class="icon-sitemap"></i> 
			<span class="title"><?=$p_menu['label']?></span>
			<span class="<?php echo $if_menu==1?'selected':''; ?>"></span>
			<span class="arrow  <?php echo $if_menu==1?'open':''; ?>"></span>
			</a>
			<?php if(!empty($p_menu['items'])){ ?>
              <ul class="sub-menu" <?php echo $if_menu==1?'style="display: block;"':''; ?>>
                  <?php foreach ($p_menu['items'] as $c_menu) {?>
                  <li class="<?php echo $mainLeftRout==$c_menu['url'][0] ? 'active':''; ?>"><a href="<?= $c_menu['url'][0] ?>"><?= $c_menu['label'] ?></a></li>
           		<?php } ?>
           	  </ul>
           <?php } ?>
        </li>
           <?php } }  ?>
	</ul>
	<!-- END SIDEBAR MENU -->
</div>
<script>
	$(".page-sidebar-menu li").each(function(i){
		if($(this).hasClass("active")){
			$(this).parent().css("display","block");
			$(this).parent().parent().addClass("open");
			$(this).parent().parent().find(".arrow").addClass("open");
			$(this).parent().parent().parent().css("display","block");
			$(this).parent().parent().parent().parent().addClass("open");
			$(this).parent().parent().parent().parent().find(".arrow").addClass("open");
		}
	});
</script>