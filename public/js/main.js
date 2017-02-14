var core={
		display:function(p_element,p_flag){
			p_element.style.display=p_flag?"":"none";
		},
		displayId:function(p_id,p_flag){
			this.display(document.getElementById(p_id),p_flag);
		}
}

function RouteMap(p_id_element)
{
	var l_layer=new ol.layer.Tile({source: new ol.source.OSM()});
	
	this.id_element=p_id_element;
	this.element=document.getElementById(p_id_element);
	
	this.layers=[l_layer];
	this.minLon=false;
	this.maxLon=false;
	this.minLat=false;
	this.maxLat=false;
	this.centerLon=false;
	this.centerLat=false;
	this.gpxFile="";
	this.style = {
		        'Point': new ol.style.Style({
		          image: new ol.style.Circle({
		            fill: new ol.style.Fill({
		              color: 'rgba(255,255,0,0.4)'
		            }),
		            radius: 5,
		            stroke: new ol.style.Stroke({
		              color: '#ff0',
		              width: 1
		            })
		          })
		        }),
		        'LineString': new ol.style.Style({
		          stroke: new ol.style.Stroke({
		            color: '#f00',
		            width: 3
		          })
		        }),
		        'MultiLineString': new ol.style.Style({
		          stroke: new ol.style.Stroke({
		            color: '#0f0',
		            width: 3
		          })
		        })
		      };
}



RouteMap.prototype.setGpxRoute=function(p_url)
{
	var l_sourceConfig={
			url:p_url,
			format: new ol.format.GPX()
	}
	var l_this=this;
    var  l_vector = new ol.layer.Vector({
        source: new ol.source.Vector(l_sourceConfig),
        style: function(feature) {
          return l_this.style[feature.getGeometry().getType()];
        }
      });
	this.layers.push(l_vector);
}

RouteMap.prototype.setSize=function(p_minLat,p_maxLat,p_minLon,p_maxLon)
{
	this.minLon=p_minLon;
	this.maxLon=p_maxLon;
	this.minLat=p_minLat;
	this.maxLat=p_maxLat;	
	this.centerLon=(p_minLon+p_maxLon)/2;
	this.centerLat=(p_minLat+p_maxLat)/2;
}

RouteMap.prototype.createView=function()
{
	var l_viewConfig={
			 center:[this.centerLon,this.centerLat]
			,projection:"EPSG:4326"			
	}
	if(this.minLat !== false){
		var l_width=this.maxLon-this.minLon;
		var l_height=this.maxLat-this.minLat;
		
		var l_resolution=Math.max(l_width/this.element.offsetWidth,l_height/this.element.offsetHeight);
		l_viewConfig.resolution=l_resolution;
	} else {
		l_viewConfig.center=[]
		l_viewConfig.zoom=20;
	}
	return new ol.View(l_viewConfig);
}

/**
 *  Display map 
 */
RouteMap.prototype.displayMap=function()
{

	var l_controls=ol.control.defaults({
		attributeOptions:({
			collapsible:false
		})
	});
		
	var l_view=this.createView();
	
	var l_mapConfig={
		 layers:this.layers
		,target:this.element
		,controls:l_controls
		,view:l_view
	}
	var l_map=new ol.Map(l_mapConfig);
	
	return l_map;
}


