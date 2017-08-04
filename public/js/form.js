function form(p_id_dom)
{
	this.id=p_id_dom;
	this.form=document.getElementById(p_id_dom);
	this.checkConditions=null;
	this.form._control=this;
	this.elementNames=[];
	this.elements={};
}

form.prototype.elementId=function(p_name)
{
	return this.id + p_name;
}
form.prototype.setup=function(){
	var l_name;
	var l_element;
	var l_this=this;
	for(var l_cnt=0;l_cnt<this.elementNames.length;l_cnt++){
		l_name=this.elementNames[l_cnt];
		l_element=document.getElementById(this.elementId(l_name));
		if(l_element){
		
			l_element.onChange=function(){
				l_this.handleOnChange();
			}
			this.elements[l_name]=l_element;
		}
		
	}
}


form.prototype.handleOnChange=function()
{
}