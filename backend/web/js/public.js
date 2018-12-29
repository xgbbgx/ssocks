function myclearNoNum(obj)
{
	obj.value = obj.value.replace(/[^\d.]/g,"");
	obj.value = obj.value.replace(/^\./g,"");
	obj.value = obj.value.replace(/\.{2,}/g,".");
	obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
}
function myclearNoInt(obj)
{
	obj.value = obj.value.replace(/[^\d]/g,"");
}
function form_msg(obj,msg,tag){
	$(obj).parent().parent().attr("class", "control-group");;
	$(obj).parent().find('.help-inline').html('');
	$(obj).parent().find('.help-block').html('');
	$(obj).parent().parent().addClass(tag);
	$(obj).parent().find('.help-inline').html(msg);
	$(obj).parent().find('.help-block').html('');
	return false;
}