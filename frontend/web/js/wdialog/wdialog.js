/**
 * 
 * author @zhuang
 * 2012-11-7
**/
var js_url="";
var wdialog = {
	maskLayer: null,
	dialogWrapper: null,
	imgPath: js_url+'/js/wdialog/',
	dialogs: [],
	hideTimer:null,
	settings : {
		minWidth: '960px',//for maskLayer
		html: '',
		autoHide: 3,
		vCenter: true,
		dialogWidth: 'auto',
		dialogHeight: 'auto',
		isSiblingNode: false,
		msgType: 'info',
		removeDialogNum: 0,
		onlyOne: false,
		defaultBorder: true,
		backgroundColor: '#fff',
		closeBox: true,
		paddingWidth: '0px',//10px
		callBack: null,
		cancelCallBack: null,
		params: null, //params for callback
		cancelParams: null ,// params for confirmBox cancel button callback
		move: false, // 可以拖拽
		imageFilter:false //遮幕
	},
	
	createMaskLayer: function(data){
		if(wdialog.maskLayer){return;}
		var maskLayerHeight = document.documentElement.clientHeight;
		var _scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
		wdialog.maskLayer = document.createElement('div');
		with(wdialog.maskLayer){
			style.zIndex = '100000';
			if(navigator.userAgent.indexOf('Firefox') != -1 && top != self){
				style.position = 'fixed';
			}else{
				style.position = 'absolute';
			}
			var imageFilter = typeof(data.imageFilter) == 'undefined'?wdialog.settings.imageFilter:data.imageFilter;
			if(imageFilter){
				style.backgroundColor="#10202c";//style.backgroundImage = 'url(' + wdialog.imgPath + 'maskBg.png)';//style.backgroundColor="#10202c";//
				style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=50), sizingMethod="scale")';
			}
			style.left = '0px';
			if(navigator.userAgent.indexOf('Firefox') != -1 && top != self){
				style.top = '0px';
			}else{
				style.top = _scrollTop+'px';
			}
			style.display = 'block';
			style.width = '100%';
			style.opacity='0.5';
			style.overflowY = 'scroll';
			style.height = '300%';//style.height = maskLayerHeight + 'px';
			className = '_gxqMaskLayer';
		}
		document.body.appendChild(wdialog.maskLayer);
		//新建对话框的父元素
		wdialog.dialogWrapper = document.createElement('div');
		with(wdialog.dialogWrapper){
			style.zIndex = '100001';
			if(navigator.userAgent.indexOf('Firefox') != -1 && top != self){
				style.position = 'fixed';
			}else{
				style.position = 'absolute';
			}
			style.left = '0px';
			if(navigator.userAgent.indexOf('Firefox') != -1 && top != self){
				style.top = '0px';
			}else{
				style.top = _scrollTop+'px';
			}
			style.width = '100%';
			//style.overflow = 'scroll';
			style.height = maskLayerHeight + 'px';
			id = '_dialogWrapper';
		}
		document.body.appendChild(wdialog.dialogWrapper);
		
		$('.main,.header,.footer,.content').addClass('fblur3');//jquery

		wdialog.addEvent(wdialog.dialogWrapper, 'click', wdialog.removeMaskLayer);

		//校正页面
		if(navigator.userAgent.indexOf('MSIE 6.0') != -1 || navigator.userAgent.indexOf('MSIE 7.0') != -1){
			document.documentElement.style.height = maskLayerHeight + 'px';
			//document.documentElement.style.overflow = 'hidden';
		}else{
			document.body.style.height = maskLayerHeight + 'px';
			//document.body.style.overflow = 'hidden';
		}
		if(navigator.userAgent.indexOf('MSIE 6.0') != -1){
			//ie6 透明背景解决方案
			wdialog.maskLayer.style.background = 'none';
			if(imageFilter) wdialog.maskLayer.style.filter = 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'+wdialog.imgPath+'maskBg.png", sizingMethod="scale")';
			//ie6下select挡住maskLayer的bug的解决方案
			var _iframe = document.createElement('iframe');
			with(_iframe){
				id = '_wIframe';
				style.zIndex = '99999';
				style.position = 'absolute';
				style.left = '0px';
				style.top = '0px';
				style.filter = 'alpha(opacity=0)';
				width = '100%';
				height = maskLayerHeight + 'px';
			}
			document.body.appendChild(_iframe);
		}
		wdialog.addEvent(window, 'resize', wdialog.maskLayerResize);
	},
	showDialog: function(data){
		wdialog.settings.removeDialogNum = typeof(data.removeDialogNum) == 'undefined'?wdialog.settings.removeDialogNum:data.removeDialogNum;
		if(wdialog.settings.removeDialogNum > 0){
			wdialog.removeMaskLayer();
		}
		wdialog.createMaskLayer(data);
		if(data.onlyOne || wdialog.settings.onlyOne){
			var elems = wdialog.getElementsByClass('_wDialog');
			if(elems.length > 0){return;}
		}
		var _dialog = document.createElement('div');
		var _id = '_'+Math.floor(Math.random()*1000000000);
		wdialog.dialogs.push(_dialog);
		var closeBox = typeof(data.closeBox) == 'undefined'?wdialog.settings.closeBox:data.closeBox;
		var move = typeof(data.move) == 'undefined'?wdialog.settings.move:data.move;
		
		with(_dialog){
			id = _id;
			className = '_wDialog';
			style.position = 'absolute';
			style.marginBottom = '30px';
			style.backgroundColor = data.backgroundColor || wdialog.settings.backgroundColor;
			style.overflowX = 'hidden';
			style.zIndex = '100002';
			style.width = data.dialogWidth || wdialog.settings.dialogWidth;
			style.height = data.dialogHeight || wdialog.settings.dialogHeight;
			style.padding = data.paddingWidth || wdialog.settings.paddingWidth;
			var defaultBorder = typeof(data.defaultBorder) == 'undefined'?wdialog.settings.defaultBorder:data.defaultBorder;
			if(defaultBorder){
				style.border = '1px solid #dedede';
				style.borderRadius = '6px 6px 6px 6px';
				style.boxShadow = '0px 0px 10px #939393';
			}
			if(closeBox){
				innerHTML = '<div style="background:url('+wdialog.imgPath+'/close.png) no-repeat 5px 0px;cursor:pointer;float:right;right:15px;top:15px;width:18px;height:16px;position:absolute;z-index:100002" onclick="wdialog.removeMaskLayer(event);" id="_wDialogClose" class="_wDialogClose"></div>';
			}
		}
		var innerContent = document.createElement('div');
		with(innerContent){
			className='_wDialog_container'+_id;
			if(move){
				style.cursor='move';
			}
			innerHTML = data.html;
		}
		_dialog.appendChild(innerContent);
		if(closeBox){
			var _wDialogCloseImg = wdialog.getElementsByClass('_wDialogClose', _dialog);
			if(_wDialogCloseImg.length > 0){
				_wDialogCloseImg = _wDialogCloseImg[0];
				wdialog.addEvent(_wDialogCloseImg, 'mouseover', function(){
					_wDialogCloseImg.style.backgroundPosition = '-20px 0px';
				});
				wdialog.addEvent(_wDialogCloseImg, 'mouseout', function(){
					_wDialogCloseImg.style.backgroundPosition = '5px 0px';
				});
			}
			//var imageFilter = typeof(data.imageFilter) == 'undefined'?wdialog.settings.imageFilter:data.imageFilter;
			//if(imageFilter) wdialog.addEvent(document.getElement, 'resize', wdialog.dialogResize);
		}
		if(data.isSiblingNode || wdialog.dialogs.length < 2){
			wdialog.dialogWrapper.appendChild(_dialog);
		}else{
			wdialog.dialogs[wdialog.dialogs.length - 2].appendChild(_dialog);
			_dialog.style.position = 'absolute';
		}
		if(wdialog.dialogs.length > 1){
			wdialog.getElementsByClass('_innerMaskLayer', wdialog.dialogs[wdialog.dialogs.length - 2])[0].style.display = 'block';
		}
		if(_dialog.parentNode == wdialog.dialogWrapper){
			//水平居中定位
			_dialog.style.left = '50%';
			_dialog.style.marginLeft = (0 - _dialog.clientWidth/2) + 'px';
			//垂直定位
			var windowHeight = document.documentElement.clientHeight;
			var dialogHeight = _dialog.clientHeight;
			if(windowHeight <= dialogHeight){
				_dialog.style.top = '5px';
			}else{
				_dialog.style.top = (windowHeight - dialogHeight)/2 + 'px';
			}
		}else{
			_dialog.style.left = (wdialog.dialogs[wdialog.dialogs.length - 2].clientWidth - _dialog.clientWidth)/2 + 'px';
			var parentNodeHeight = wdialog.dialogs[wdialog.dialogs.length - 2].clientHeight;
			var dialogHeight = _dialog.clientHeight;
			if(parentNodeHeight <= dialogHeight){
				_dialog.style.top = '5px';
			}else{
				_dialog.style.top = (parentNodeHeight - dialogHeight)/2 + 'px';
			}
		}
		
		wdialog.addEvent(window, 'resize', wdialog.dialogResize);
		var autoHide = typeof(data.autoHide) == 'undefined'? wdialog.settings.autoHide:data.autoHide;
		if(autoHide){
			wdialog.hideTimer = setTimeout(function(){
				wdialog.removeMaskLayer();
			}, autoHide*1000);
		}

		/*每个弹窗预置一个遮罩层*/
		var innerMaskLayer = document.createElement('div');
		with(innerMaskLayer){
			style.position = 'absolute';
			style.left = '0px';
			style.top = '0px';
			style.width = _dialog.clientWidth + 'px';
			style.height = _dialog.clientHeight + 'px';
			style.backgroundColor = 'gray';
			style.zIndex = '100002';
			style.opacity = 0.2;
			if(navigator.userAgent.indexOf('MSIE') != -1){
				style.filter = 'alpha(opacity=20)';
			}
			style.display = 'none';
			className = '_innerMaskLayer';
		}
		_dialog.appendChild(innerMaskLayer);

		//绑定confirm的callback函数
		if(data.callBack){
			wdialog.addEvent(wdialog.getElementsByClass('_wConfirm', _dialog)[0], 'click', function(){setTimeout(function(){data.callBack(data.params || wdialog.settings.params);}, 50);});
		}
		//绑定confirm的cancelCallBack函数
		if(data.cancelCallBack){
			wdialog.addEvent(wdialog.getElementsByClass('_wCancel', _dialog)[0], 'click', function(){setTimeout(function(){data.cancelCallBack(data.cancelParams || wdialog.settings.cancelParams);}, 50);});
		}	
	},
	msgBox:function(data){
		data.html = '<table width="100%" class="_msgBox" style="margin:10px;"><tr><td width="50px"><img src="'+wdialog.imgPath+(data.msgType||wdialog.settings.msgType)+'.gif"/></td><td align="center">'+data.html+'</td></tr></table>';
		var _id = wdialog.showDialog(data);
		return _id;
	},
	confirmBox: function(data){
		data.html = '<table width="100%" border="0" class="_confirmBox" style="margin:10px;"><tr><td colspan="2" height="30px" align="center">'+data.html+'</td></tr><tr><td align="right" height="30px"><img src="'+wdialog.imgPath+'confirm.png" style="cursor:pointer;" class="_wConfirm" id="_wConfirm"/>&nbsp;&nbsp;</td><td align="left">&nbsp;&nbsp;<img src="'+wdialog.imgPath+'cancel.png" style="cursor:pointer;" id="_wDialogClose" class="_wCancel"/></td></tr></table>';
		var _id = wdialog.showDialog(data);
		return _id;
	},
	addEvent:function(elem, eventType, fn, useCapture){
		if(arguments.length < 4){
			useCapture = false;
		}
		if(elem.addEventListener){
			elem.addEventListener(eventType, fn, useCapture);
		}else if(elem.attachEvent){
			elem.attachEvent('on' + eventType, fn);
		}else{
			elem['on' + eventType] = fn;
		}
	},
	removeEvent:function(elem, eventType, fn, useCapture){
		if(arguments.length < 4){
			useCapture = false;
		}
		if(elem.removeEventListener){
			elem.removeEventListener(eventType, fn, useCapture);
		}else if(elem.detachEvent){
			elem.detachEvent('on' + eventType, fn);
		}
	},
	getElementsByClass: function(searchClass, node, tag){
		var classElements = new Array();
		if(node == null){
			node = document;
		}
		if(tag == null){
			tag = '*';
		}
		var els = node.getElementsByTagName(tag);
		var elsLen = els.length;
		var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
		for(i = 0, j = 0; i < elsLen; i++){
			if( pattern.test(els[i].className)){
				classElements[j] = els[i];
				j++;
			}
		}
		return classElements;
	},
	removeMaskLayer:function(){
		var event = arguments[0] || window.event;
		var target = null;
		if(event){
			target = event.target || event.srcElement;
		}
		if(target && target != wdialog.dialogWrapper && target.id != '_wDialogClose' && target.id != '_wConfirm'){
			// && target.constructor != XMLHttpRequest){
			if(typeof(XMLHttpRequest)!= 'undefined' && target.constructor != XMLHttpRequest){
				return;
			}
			if(typeof(XMLHttpRequest) == 'undefined'){
				return;
			}
		}
		if(target && (target.id == '_wDialogClose' || target.id == '_wConfirm')){
			wdialog.stopBubble(event);
		}
		if(wdialog.maskLayer){
			$('.main,.header,.footer,.content').removeClass('fblur3');//jquery
			for(var i=0; i<= wdialog.settings.removeDialogNum; i++){
				if(wdialog.dialogs.length > 0){
					var lastDialog = wdialog.dialogs[wdialog.dialogs.length-1];
					if(wdialog.hideTimer){
						clearTimeout(wdialog.hideTimer);
						wdialog.hideTimer = null;
					}
					if(wdialog.dialogs.length > 1){
						wdialog.getElementsByClass('_innerMaskLayer', wdialog.dialogs[wdialog.dialogs.length - 2])[0].style.display = 'none';
						if(wdialog.dialogWrapper !== lastDialog.parentNode){
							wdialog.dialogs[wdialog.dialogs.length-2].removeChild(lastDialog);
						}else{
							wdialog.dialogWrapper.removeChild(lastDialog);
						}
					}else{
						wdialog.dialogWrapper.removeChild(lastDialog);
					}
					
					wdialog.dialogs.pop();
				}
			}
			if(wdialog.dialogs.length == 0){
				document.body.removeChild(wdialog.dialogWrapper);
				if(navigator.userAgent.indexOf('MSIE 6.0') != -1){
					document.body.removeChild(document.getElementById('_wIframe'));
				}
				document.body.removeChild(wdialog.maskLayer);
				
				if(navigator.userAgent.indexOf('MSIE 6.0') != -1 || navigator.userAgent.indexOf('MSIE 7.0') != -1){
					document.documentElement.style.height = '100%';
					document.documentElement.style.overflow = 'scroll';
				}else{
					document.body.style.height = '100%';
					document.body.style.overflow = 'scroll';
				}
				wdialog.removeEvent(wdialog.dialogWrapper, 'click', wdialog.removeMaskLayer);
				wdialog.maskLayer = null;
				wdialog.dialogWrapper = null;
			}
		}
	},
	maskLayerResize: function(){
		if(wdialog.maskLayer){
			var maskLayerHeight = document.documentElement.clientHeight;
			wdialog.maskLayer.style.height = maskLayerHeight + 'px';
			wdialog.dialogWrapper.style.height = maskLayerHeight + 'px';
		}
	},
	dialogResize: function(){
		if(wdialog.dialogs.length > 0){
			var windowHeight = document.documentElement.clientHeight;
			for(var i in wdialog.dialogs){
				if(wdialog.dialogs[i].parentNode == wdialog.dialogWrapper){
					var dialogHeight = wdialog.dialogs[i].clientHeight;
					if(windowHeight <= dialogHeight){
						wdialog.dialogs[i].style.top = '5px';
					}else{
						wdialog.dialogs[i].style.top = (windowHeight - dialogHeight)/2 + 'px';
					}
				}
			}
		}
	},
	stopBubble:function(e){
		if(e && e.stopPropagation){
			e.stopPropagation();
		}
		else{//ie专用
			window.event.cancelBubble = true;
		}
	}
};