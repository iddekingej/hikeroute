function $(p_id)
{
	return document.getElementById(p_id);
};


function $sid(p_this,p_id)
{
	var l_item=$(p_id);
	if(!l_item) throw "Item with id="+p_id+" not found";
	p_this[p_id]=l_item;
	return l_item;
};


window.coreArray={
	assign:function(p_item,p_data){
		var l_key;
		for(l_key in p_data){
			if(typeof p_data[l_key] == "object"){
				this.assign(p_item[l_key],p_data[l_key]);
			} else {
				p_item[l_key]=p_data[l_key];
			}
		}
	}
, 	isEmpty:function(p_item)
	{
		for(var l_cnt in p_item){
			return false;
		}
		return true;
	}
};

Array.prototype.__test=function()
{
}

if (!Array.prototype.forEach)
{
  Array.prototype.forEach = function(fun /*, thisArg */)
  {
    "use strict";

    if (this === void 0 || this === null)
      throw new TypeError();

    var t = Object(this);
    var len = t.length >>> 0;
    if (typeof fun !== "function")
      throw new TypeError();

    var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
    for (var i = 0; i < len; i++)
    {
      if (i in t)
        fun.call(thisArg, t[i], i, t);
    }
  };
}


window.isIE=navigator.userAgent.toLowerCase().indexOf("msie")>=0;


window.core={
dom:{
	create:function(p_item,p_parent,p_data)
	{
		var l_item=document.createElement(p_item);
		if(p_data)coreArray.assign(l_item,p_data);
		if(p_parent) p_parent.appendChild(l_item);
		return l_item;
	},
	createImage:function(p_url,p_parent,p_data)
	{
		var l_image=this.create('img',p_parent,{src:p_url});	
		if(p_data){
			if(typeof p_data=="object"){
				if("className" in p_data) l_image.classname=p_data.className;	
				if("click" in p_data) gui.setupEvent(l_image,"click",p_data.click);	
				if("tooltip" in p_data) l_image.title=p_data.tooltip;
			}
		}
		return l_image;
		
	},
	appendText:function(p_text,p_parent)	
	{
		var l_text=p_text;
		if(l_text===null) l_text="";
		var l_new=document.createTextNode(l_text);
		p_parent.appendChild(l_new);
		return l_new;
	}

}	
	
}	




window.gui={
 
getCookie:function(p_cookie)
{
  var l_regex=/(.*?)=(.*?)(;|$)\s*/g;
  var l_info;
  while(true){
    l_info=l_regex.exec(document.cookie);
    if(!l_info) break;
    if(l_info[1]==p_cookie) return unescape(l_info[2]);    
  }
  return false;
},

setCookie:function(p_cookie,p_value)
{
  document.cookie=p_cookie+"="+escape(p_value);
},
	
getIsIe:function(){
  return navigator.userAgent.toLowerCase().indexOf("msie")>=0;
}
,pxToNum:function(p_value){
	if(p_value=="") return 0;
	return Number(p_value.substr(0,p_value.length-2));
}
,hex2:function(p_num)
{
	return (p_num<16?"0":"")+Number(p_num).toString(16).toUpperCase();
	
},
rgbToHex:function(p_text)
{
	var l_data;
	if(p_text.substr(0,4)=="rgb("){
		var l_string=p_text.substr(4,p_text.length-5);
		l_data=l_string.split(",");		
		return '#'+this.hex2(l_data[0])+this.hex2(l_data[1])+this.hex2(l_data[2]);
		
	} else {
		return p_text;
	}
},
getAbsY:function(p_element)
{
	var l_y=0;
	var l_element=p_element;
	while(l_element && l_element.offsetParent){
		l_y += l_element.offsetTop;
		l_element=l_element.offsetParent;
	}
	return l_y;
},
getAbsX:function(p_element)
{
	var l_x=0;
	var l_element=p_element;
	while(l_element.offsetParent){
		l_x += l_element.offsetLeft;
		l_element=l_element.offsetParent;
	}
	return l_x;
},
getRelYParent:function(p_element)
{
	var l_parentY=this.getAbsY(p_element.parentNode);
	var l_thisY=this.getAbsY(p_element)
	return l_thisY-l_parentY;
},
getXY:function(p_element)
{
	var l_x=this.getAbsX(p_element);
	var l_y=this.getAbsY(p_element);
	return {x:l_x,y:l_y};
},
getWindowXY:function(p_element)
{
	var l_xy;
	var l_x;
	var l_y;
	l_xy=this.windowScrollXY(window);
	l_x=this.getAbsX(p_element) - l_xy.x;
	l_y=this.getAbsY(p_element) - l_xy.y;
	return {x:l_x,y:l_y};
},
appendEndAtElement:function(p_element,p_at,p_dx,p_dy)
{	
	var l_x=this.getAbsX(p_at);
	var l_y=this.getAbsY(p_at);
	document.body.appendChild(p_element);
	p_element.style.position='absolute';
	p_element.style.left=(l_x +p_dx)+'px';
	p_element.style.top=(l_y + p_dx)+'px';
}
,scrollIntoViewIframe:function(p_element)
{
	var l_element=document.documentElement;
	var l_height=frameElement.offsetHeight;	
	var l_topY=this.getAbsY(p_element) 
	if(l_topY+p_element.offsetHeight>l_height+l_element.scrollTop||l_topY<l_element.scrollTop){
		var l_newY=l_topY-Math.round(l_height/2);
		if(l_newY<0) l_newY=0;
		window.scrollTo(0,l_newY);
	}
}
,scrollIntoViewWindow:function(p_element)
{
	var l_topY=this.getAbsY(p_element);
	var l_window=gui.windowFromElement(p_element);
	var l_scroll=gui.windowScrollXY(l_window);
	if(l_scroll.y>l_topY||l_scroll.y + l_window.innerHeight<l_topY){
		var l_newY=l_topY-l_window.innerHeight/2;
		if(l_newY<0) l_newY=0;
		window.scrollTo(l_scroll.x,l_newY);
	}
	
}
,scrollIntoView:function(p_container,p_element)
{
	var l_element=p_container;
	var l_topY=this.getAbsY(p_element) - this.getAbsY(l_element);
	if(l_element.scrollTop>l_topY){
		l_element.scrollTop=l_topY;
	} else if(l_element.scrollTop+l_element.offsetHeight/2 <l_topY+p_element.offsetHeight){
		
		l_element.scrollTop=l_topY+p_element.offsetHeight-l_element.offsetHeight/2;
	}
},

toggleDisplay:function(p_item)
{
	p_item.style.display=p_item.style.display==""?"none":"";
	return p_item.style.display=="";
}
,displayId:function(p_element_id,p_flag)
{
	this.display($(p_element_id),p_flag);
}
,
displayToggle:function(p_element)
{
	p_element.style.display=(p_element.style.display=="none"?"":"none");
},
displayToggleId:function(p_id_element)
{
	p_element.style.display=($(p_id_element).style.display=="none"?"":"none");
},
iframeContentDocument:function(p_iframe)
{
	if(p_iframe.contentDocument) return p_iframe.contentDocument;
	return p_iframe.contentWindow.document;
},
stopPropegation:function(p_event)
{
	p_event.cancelBubble = true;
	if (p_event.stopPropagation){
		p_event.stopPropagation();
		p_event.preventDefault();
	}
},
preventDefault:function(p_event)
{
		if(!this.getIsIe())p_event.event.preventDefault();
},
setStyleRules:function(p_styleSheet,p_name,p_data)
	{
		var l_item;
		if("sheet" in p_styleSheet){
			for(l_item in p_data) p_styleSheet.sheet.cssRules[0].style[l_item]=p_data[l_item];
		} else {
			for(l_item in p_data) p_styleSheet.styleSheet.rules[0].style[l_item]=p_data[l_item];
		}
	},
createDivText:function(p_text,p_data,p_parent)
{
	var l_item=this.create('div',p_data,p_parent);
	this.appendText(l_item,p_text);
	return l_item;
},
create:function(p_item,p_data,p_parent)
	{
		return core.dom.create(p_item,p_parent,p_data);
	},
createBefore:function(p_item,p_data,p_parent,p_before)
	{
		var l_item=document.createElement(p_item);
		if(p_data)coreArray.assign(l_item,p_data);
		p_parent.insertBefore(l_item,p_before);
		return l_item;
	},
appendAfter:function(p_at,p_item)
{
	p_at.parentElement.insertBefore(p_item,p_at.previousSibling);	
},
remove:function(p_item)
	{
		p_item.parentNode.removeChild(p_item);
	},
removeChilderen:function(p_item)
	{
		while(p_item.firstChild){
			p_item.removeChild(p_item.firstChild);
		}
	},
appendText:function(p_parent,p_text)	
	{
		return core.dom.appendText(p_text,p_parent);
	},

textareaText:function(p_parent,p_text)
	{
		var l_split=p_text.split("\n");
		this.removeChilderen(p_parent);
		for(var l_cnt=0;l_cnt<l_split.length;l_cnt++){
			this.appendText(p_parent,l_split[l_cnt]);
			if(l_cnt+1<l_split.length){
				this.create('br',false,p_parent);
			}	
		}
	},
replaceText:function(p_parent,p_text)
	{
		var l_text=p_text;
		if(l_text===null) l_text="";
		while(p_parent.firstChild) p_parent.removeChild(p_parent.firstChild);
		var l_textNode=document.createTextNode(l_text);
		p_parent.appendChild(l_textNode);
		return l_textNode;
	},
setupWheelEvent:function(p_item,p_function)
{
	this.setupEvent(p_item,"DOMMouseScroll",function(p_event)
		{
			var l_event=p_event?p_event:window.event;
			p_function(p_event,l_event.detail ? l_event.detail   : l_event.wheelDelta / 40);
		}
	);
}
, windowScrollXY:function(p_window)
{
	if("scrollX" in p_window){
		return {x:p_window.scrollX,y:p_window.scrollY};
	} else {
		return {x:p_window.document.body.parentElement.scrollLeft,y:p_window.document.body.parentElement.scrollTop};
	}
}
, windowFromDocument:function(p_document)
{
	if( "defaultView" in p_document) return p_document.defaultView;
	return p_document.parentWindow;
}
, windowFromElement:function(p_element)
{
	if( "location" in p_element) return p_element;

	var l_document=p_element.ownerDocument;	
	return this.windowFromDocument(l_document);
}
,_winEventFromElement:function(p_item)
{
	var l_window=this.windowFromElement(p_item);
	if(!("event" in l_window)){
		return window.event;
	} 
	return l_window.event;
},
setupEvent:function(p_item,p_event,p_function)
	{
		
		if(p_item.addEventListener){
			p_item.addEventListener(p_event,function(p_event){return p_function.call(p_item,gui.normalEvent(p_event));},false);
		} else {
			p_item.attachEvent('on'+p_event,function(){ return p_function.call(p_item,gui.normalEvent(gui._winEventFromElement(p_item)));});
		}
	},
setFloat:function(p_item,p_float)
{
	p_item.style.cssFloat=p_float;
	p_item.style.styleFloat=p_float;
}
,elementAbsTop:function(p_element)
{
	var l_element=p_element;
	var l_top=0;
	while(l_element){
		l_top +=l_element.offsetTop;
		l_element=l_element.offsetParent;
	}
	return l_top;
}
,normalEvent:function(p_event)
{
	var l_element;
	var l_x;
	var l_y;
	var l_screenX=0;
	var l_screenY=0;
	var l_clientX=0;
	var l_clientY=0;
	var l_numTouches=0;
	if("touches" in p_event){				
		l_numTouches=p_event.touches.length;
		if(l_numTouches>0){
			l_screenX=p_event.touches[0].screenX;
			l_screenY=p_event.touches[0].screenY;
			l_element=p_event.touches[0].target;
			l_clientX=p_event.touches[0].clientX;
			l_clientY=p_event.touches[0].clientY;
		}
		l_x=l_screenX;
		l_y=l_screenY;
	} else {
		l_screenX=p_event.screenX;
		l_screenY=p_event.screenY;
		l_clientX=p_event.clientX;
		l_clientY=p_event.clientY;
		if("srcElement" in p_event){
			l_element=p_event.srcElement;
			l_x=p_event.offsetX;
			l_y=p_event.offsetY;
		} else {	
			l_element=p_event.target;
			l_x=p_event.layerX;
			l_y=p_event.layerY;
		}
	}
	var l_object=l_element;
	while(l_object){
		if("_control" in l_object) break;
		l_object=l_object.parentNode;	
	}
	if(l_object){
		l_object=l_object._control;
		
	}
	var l_return={
		button:p_event.button,
		element:l_element,
		key:{code:p_event.keyCode,ctrl:p_event.ctrlKey,shift:p_event.shiftKey,alt:p_event.altKey},		
		x:l_x,
		y:l_y,
		screenX:l_screenX,
		screenY:l_screenY,
		clientX:l_clientX,
		clientY:l_clientY,
		object:l_object,
		event:p_event,
		numTouches:l_numTouches
	}
	
	return l_return;
}
,singleClick:function(p_element,p_function,p_event)
{
	var l_element=p_element;
	var l_event={};
	var l_x;
	for(l_x in p_event){
		l_event[l_x]=p_event[l_x];
	}
	if(!l_element._ctimeout) l_element._ctimeout={};

	l_element._ctimeout[p_event]=setTimeout(
		function(){
			l_element._ctimeout=false;
			p_function.call(l_element,l_event);
		}
		,250
	);

}
,doubleClick:function(p_element,p_function,p_event)
{
	var l_event=p_event;
	var l_element=p_element;
        var l_cnt;
	if(l_element._ctimeout){
		for(l_cnt in l_element._ctimeout){
			clearTimeout(l_element._ctimeout[l_cnt]);
		}
		l_element._ctimeout=new Array();
	}
	p_function.call(l_element,l_event);
}
,appendHidden:function(p_name,p_value,p_parent)
{
	var l_item=this.create("input",{"type":"hidden","value":p_value},p_parent);
	l_item.name=p_name;	
	return l_item;
}
,elementToParentHeight:function(p_element,p_extra)
{
	var l_styles=this.getComputedStyles(p_element);	
	var l_pad=this.pxToNum(l_styles["paddingTop"])+this.pxToNum(l_styles["paddingBottom"]);	
	var l_newHeight=p_element.parentNode.scrollHeight - this.getAbsY(p_element)+this.getAbsY(p_element.parentNode)-8-l_pad;
	if(p_extra !==undefined) l_newHeight -= p_extra;		
	if(l_newHeight>0){
		p_element.style.height=l_newHeight+'px';
	}
}
,elementToPageHeight:function(p_element,p_extra)
{
	var l_styles=this.getComputedStyles(p_element);	
	var l_pad=this.pxToNum(l_styles["paddingTop"])+this.pxToNum(l_styles["paddingBottom"]);
	var l_newHeight=page.height()-this.getAbsY(p_element)-8-l_pad;
	if(p_extra !==undefined) l_newHeight -= p_extra;
	if(l_newHeight>0){
		
		p_element.style.height=(l_newHeight)+'px';
	}
}
,getComputedStyles:function(p_element,p_style)
{
	if(window.getComputedStyle){
		return window.getComputedStyle(p_element);
	} else {
		return p_element.currentStyle;
	}
}
,elementToPageWidth:function(p_element)
{
	var l_styles=this.getComputedStyles(p_element);
	var l_pad=this.pxToNum(l_styles["paddingLeft"])+this.pxToNum(l_styles["paddingRight"]);

	var l_newWidth=page.width()-this.getAbsX(p_element)-l_pad;
	if(l_newWidth>0){
		p_element.style.width=(l_newWidth)+'px';
	}
}
,addOptionToSelect:function(p_element,p_value,p_text)
{
	var l_cnt;
	for(l_cnt=0;l_cnt<p_element.options.length;l_cnt++){
		if(p_element.options[l_cnt].value==p_value){
			p_element.value=p_value;
			return;
		}
	}
	var l_newOption=p_element.ownerDocument.createElement('option');
	l_newOption.text=p_text;
	l_newOption.value=p_value;
	l_newOption.selected=true;
	l_newOption.defaultSelected=true;
	p_element.options.add(l_newOption);
}
,getSelectedValue:function(p_element)
{
	var l_option=p_element.options[p_element.selectedIndex];
	if(l_option) return l_option.textContent;
	return "";
},
handleTaTab:function (p_event,p_element)
{
	var l_range;
	if(p_event.keyCode==9){
		var l_st=p_element.scrollTop;
		if(isIE){
			l_range=document.selection.createRange();
			l_range.text="\t";
		} else {
			var l_selectionStart = p_element.selectionStart;
		
			p_element.value=p_element.value.substr(0,p_element.selectionStart)+"\t"+p_element.value.substr(p_element.selectionStart,p_element.value.length-p_element.selectionStart);
		
			p_element.selectionStart = l_selectionStart+1;
			p_element.selectionEnd = l_selectionStart+1;
		}
		p_element.scrollTop=l_st;
		return false;
	}
	return true;
},
display:function(p_element,p_flag)
{
	p_element.style.visibility=p_flag?"visible":"hidden";
	p_element.style.display=p_flag?(p_element.tagName.toLowerCase()=="div"?"block":""):"none";
},
isDisplayed:function(p_element)
{
	return p_element.style.display !== "none";
},
cssTop:function(p_element)
{
	return Number(p_element.style.top.substr(0,p_element.style.top.length-2));
},
cssLeft:function(p_element)
{
	return Number(p_element.style.left.substr(0,p_element.style.left.length-2));
},
cssWidth:function(p_element)
{
	return Number(p_element.style.width.substr(0,p_element.style.width.length-2));
},
cssHeight:function(p_element)
{
	return Number(p_element.style.height.substr(0,p_element.style.height.length-2));
},
selectItem:function(p_element,p_value)
{
	var l_cnt;
	for(l_cnt=0;l_cnt<p_element.options.length;l_cnt++){
		if(p_element.options[l_cnt].value==p_value){
			p_element.value=p_value;
			return;
		}
	}
}


}

window.page={
	width:function(){
		return this.widthOf(window);		
	},
	widthOf:function(p_window)
	{
		return p_window.innerWidth != null? p_window.innerWidth: p_window.document.documentElement && p_window.document.documentElement.clientWidth ? p_window.document.documentElement.clientWidth:p_window.document.body != null? p_window.document.body.clientWidth:null;
	},
	height:function(){
		return this.heightOf(window);		
	},
	heightOf:function(p_window)
	{
		return p_window.innerHeight != null? p_window.innerHeight: p_window.document.documentElement && p_window.document.documentElement.clientHeight ? document.documentElement.clientHeight:p_window.document.body != null? p_window.document.body.clientHeight:null;
	}


}

window.validate={
	color:function(p_color)
	{
		if(p_color.length==0){	
			return true;
		} else if(p_color.length==4){
			return p_color.match('^#[0-9a-fA-F]{3}$')?true:false;
		} else if(p_color.length==7){
			return p_color.match('^#[0-9a-fA-F]{6}$')?true:false;
		} 
		return false;
	},
	number:function(p_number)
	{	
		var l_number=String(p_number);
		var l_cnt;
		for(l_cnt=0;l_cnt<l_number.length;l_cnt++){
			if(l_number.charAt(l_cnt)<'0'||l_number.charAt(l_cnt)>'9') return false;
		}
		return true;
	},
	date:function(p_date)
	{
		var l_text=String(p_date);
		var l_day;
		var l_month;
		var l_year;
		if(l_text=="") return true;
		var l_match=l_text.match('^([0-9]{1,2})[-/]([0-9]{1,2})[-/]([0-9]{4})$');
		if(!l_match) return false;
		
		
		l_day=Number(l_match[1]);	
		l_month = Number(l_match[2]);
		l_year=Number(l_match[3]);
		
		if(l_month<1||l_month>12) return false;
		if(l_day<1) return false;
		var l_date=new Date(l_year,l_month,0);
		if(l_date.getDate()<l_day) return false;
		return true;
	}	
}

var contextMenu={
	init:function()
	{
		window.contextElement=false;
		gui.setupEvent(document.body,'contextmenu',function(p_event){window.contextElement=p_event.element;});
	}
}

