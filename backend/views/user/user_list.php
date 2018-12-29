<?php
$this->title = '用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">
   <table class="table table-striped table-bordered" id="jq_datatable_list">
       <thead>
        <tr>
        	<th>ID</th>
        	<th>用户名</th>
        	<th>会员等级</th>
        	<th>会员有效期</th>
        	<th>会员状态</th>
        	<th class="action-column">&nbsp;</th>
        </thead>
        <tbody>
        	<?php
				for($i=0;$i<10;$i++){
					echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td></td>
                <td></td><td></td><td></td></tr>';
				}
			?>
        </tbody>
   </table>
</div>
<script type="text/javascript">
$('#jq_datatable_list').dataTable( {
	"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
	"sPaginationType": "bootstrap",
	"bStateSave": false, 
	"bAutoWidth":false,
	"bProcessing": true,
	"bServerSide": true,
	"aaSorting": [[ 2, "asc" ]],
	"sAjaxSource": "/user/get-user-list",
	"oLanguage": {
		"sUrl": "/js/jquery/cn.txt"
	},
	"fnInfoCallback":function(nRow,aData,iDataIndex){
		$('.popovers').popover({"trigger":"hover","placement":"bottom"});
	},"aoColumns": [
		{ "sName": "id" },
		{ "sName": "name",},
		{ "sName": "info" ,"bSearchable": false},
		{ "sName": "book_num" ,"bSearchable": false},
		{ "sName": "name","bSearchable": false},
        { "sName": "actions","bSearchable": false, "bSortable": false}
    ],//$_GET['sColumns']将接收到aoColumns传递数据 
    "fnServerParams": function ( aoData ) {//向服务器传额外的参数
		aoData.push( { "name": "_csrf-backend", "value": $('meta[name="csrf-token"]').attr('content') });
	}
});
</script>
