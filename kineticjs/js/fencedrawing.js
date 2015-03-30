var adjNodeArr = [];
var linesArr = [];

/**
 * generate unique id for node
 */
var uniqueId = (function() {
    var id = 0;
    return function() {
        return 'node_'+id++;
    };
})();

/**
 * gemerate unique id for line
 */
var uniqueLineId = (function() {
    var lid = 0;
    return function() {
        return 'line_'+lid++;
    };
})();

$(function(){   
   
    var _isNewline = false;
    var _prevX = -1;
    var _prevY = -1;
    var _prevLine = 0;
   
    /** Draw Canvas**/
    var stage = new Kinetic.Stage({
        container: 'canvas-holder',
        width: 800,
        height: 600
    });   
   
    /** Draw Graph**/
    var graph = drawGraph(stage.getHeight(), stage.getWidth());
   
    /** Draw Layer**/
    var layer = new Kinetic.Layer();
   
    /** Page for draw**/
    var drawPage = new Kinetic.Rect({
          width: stage.getWidth(),
          height: stage.getHeight(),
          fill : 'transparent',
          strokeWidth : '2',
          strokeRGB : { r:204 ,g:204 , b:204 }
    });

    /**Double click mouse events**/
    drawPage.on('dblclick dbltap', function(evt) {
        if(!_isNewline){
            _prevX = evt.layerX;
            _prevY = evt.layerY;
            var nid = drawPoint(layer, _prevX,_prevY);           
           
            var nodeObj = {
                id : nid,
                posX : _prevX,
                posY : _prevY,
                adjNode : [],
                lineIds : []
            };
            adjNodeArr.push(nodeObj);
           
            _isNewline = true;
        } else {
            if(_prevLine){
                _prevLine.remove();
                _prevLine = 0;
            }
           
            var line = drawLine(layer, _prevX, _prevY, evt.layerX, evt.layerY);
            line.setId(uniqueLineId());
           
            var nid = drawPoint(layer, evt.layerX, evt.layerY);
            prevX = prevY = -1;
            _isNewline = false;
           
            var lineObj = {
                    id: line.getId(),
                    nodeS :'',
                    nodeE : '',
                };
           
            /** Store Adjoint Node*/           
            var nodeObj = {
                    id : nid,
                    posX : evt.layerX,
                    posY : evt.layerY,
                    adjNode : [],
                    lineIds : [],
                };
           
            var nodeAdj = { x:_prevX, y: _prevY, id:'' };
            var pnid = getNodeIndex(adjNodeArr, nodeAdj);
            nodeAdj.id = adjNodeArr[pnid].id;
            nodeObj.adjNode.push(nodeAdj);
            nodeObj.lineIds.push(line.getId());
            adjNodeArr.push(nodeObj);
            adjNodeArr[pnid].adjNode.push({ x:evt.layerX, y:evt.layerY, id:nid });           
            adjNodeArr[pnid].lineIds.push(line.getId());
           
            /** add line object*/
            lineObj.nodeS = adjNodeArr[pnid].id;
            lineObj.nodeE = nid;
            linesArr.push(lineObj);
        }
    });
   
    drawPage.on('mousemove touchmove', function(evt) {
        if(_isNewline){
            if(_prevLine){
                _prevLine.remove();
            }
            _prevLine = drawLine(layer, _prevX, _prevY, evt.layerX, evt.layerY);
        }       
    });
   
    layer.add(graph);
    layer.add(drawPage);   
    stage.add(layer);
   
    /**Canvas background color**/
    $('#canvas-container canvas').css('background','#eee');       
   
});

var getNodeIndex = function(dataObject,node){
    var res = $.map(dataObject, function(e, i){
        if(e.posX == node.x && e.posY == node.y){
            return i;
        }
    });
    return res;
};

/**Graph function**/
var drawGraph = function(height, width){
    var group = new Kinetic.Group({
        id : 'graph-group',
        name : 'graph-group'
    });
   
    for(var i=0; i < height; i=i+10){
        var line = new Kinetic.Line({
            points: [0, i, width, i],
            stroke: 'white',
            strokeWidth: 1,
        });   
        group.add(line);
    }
   
    for(var i=0; i < width; i=i+10){
        var line = new Kinetic.Line({
            points: [i, 0, i, height],
            stroke: 'white',
            strokeWidth: 1,
        });
        group.add(line);
    }
   
    return group;
};

/**
 * Draw Line function
 */
var drawLine = function(layer,x1, y1,x2,y2){
    var line = new Kinetic.Line({
        points: [x1,y1,x2,y2],
        fill : 'black',
        stroke: 'black',
        name : 'line',
        lineCap : 'round',
        width : 3,
        strokeWidth: 2,
    });
   
    var tooltip = new Kinetic.Label({
        x: 170,
        y: 75,
        opacity: 0.75
      });

      tooltip.add(new Kinetic.Tag({
        fill: 'black',
        pointerDirection: 'down',
        pointerWidth: 10,
        pointerHeight: 10,
        lineJoin: 'round',
        shadowColor: 'black',
        shadowBlur: 10,
        shadowOffset: 10,
        shadowOpacity: 0.5
      }));
     
      tooltip.add(new Kinetic.Text({
        text: 'Tooltip',
        fontFamily: 'Calibri',
        fontSize: 18,
        padding: 5,
        fill: 'white'
      }));
   
    layer.add(line);
    layer.drawScene();
   
    return line;
};

/**
 * Draw Point function
 */
var drawPoint = function(layer, mouseX, mouseY){   
    var circle = new Kinetic.Circle({
        x: mouseX,
        y: mouseY,
        radius: 4,
        name : 'circle',
        id: uniqueId(),
        fill: 'black',
        stroke: 'black',
        strokeWidth: 1,
    });
   
    circle.on('mouseover',function(){
        this.setAttrs({
            radius: 5,
        });
        layer.drawScene();
    });   
   
    circle.on('mouseout',function(){
        this.setAttrs({
            radius: 4,
        });
        layer.drawScene();
    });
   
    circle.on('mousedown',function(evt){
        this.setAttrs({
            draggable : true,
        });
    });
   
    circle.on('mouseup',function(){
        this.setAttrs({
            draggable : false,
        });
        layer.drawScene();
    });
   
    circle.on('dragmove', function(evt) {
        var nodeId = this.getId();       
        var nodeIndex = $.map(adjNodeArr,function(e,i){
            if(e.id==nodeId) return i;
        });
       
        if(nodeIndex >= 0){
            var adjN = adjNodeArr[nodeIndex].adjNode;       
            for(var i=0; i < adjN.length; i++){
                adjNodeId = adjN[i].id;
                var lineId = $.map(linesArr,function(e,i){
                    if((e.nodeS==nodeId && e.nodeE==adjNodeId) || (e.nodeE==nodeId && e.nodeS==adjNodeId)) return e.id;
                });
               
                var lineObj = layer.find('#'+lineId)[0];
                lineObj.setPoints([evt.layerX, evt.layerY, adjN[i].x, adjN[i].y]);
            }
        }
        layer.drawScene();
    });
   
    circle.on('dragend', function(evt) {
        var nid = this.getId();
        var nodeX = evt.layerX;
        var nodeY = evt.layerY;
        var nindex = $.map(adjNodeArr,function(e,i){
            if(e.id==nid) return i;
        });
       
       
        /** check over circle or not and update*/
        var circleObjArr = layer.find('.circle');
        var isDropped = '';
        isDropped = $.map(circleObjArr,function(e,i){           
            if( nodeX > (e.getX() - e.getWidth()/2) && nodeX < (e.getX() + e.getWidth()/2) &&
                nodeY > (e.getY() - e.getHeight()/2) && nodeY < (e.getY() + e.getHeight()/2) &&
                (nid != e.getId())
              ) {
            	return e.getId();               
            } 
        });
        
        if(isDropped.length > 0){
        	joinLineAndUpdate(layer,isDropped,nid);
        	this.remove();
        } else {
        	adjNodeArr[nindex].posX = nodeX;
            adjNodeArr[nindex].posY = nodeY;
            updateInAdjoin(layer,nindex);
            
            this.setAttrs({
                x: nodeX,
                y: nodeY,
            });
        }       
        
        layer.draw();
    });
   
    layer.add(circle);
    layer.draw();
   
    return circle.getId();
};

/**
 * Update Adjoint Node information when change its position
 */
var updateInAdjoin = function(layer,nodeIndex){

    var nodeID = adjNodeArr[nodeIndex].id; /** get node id*/
    var adjNodeId = '';
   
    if(nodeIndex>=0){
        var adjN = adjNodeArr[nodeIndex].adjNode;
       
        for(var i=0; i < adjN.length; i++){       
           
            adjNodeId = adjN[i].id; /** get adjoint node id*/
            var adjIndex = $.map(adjNodeArr,function(e,i){
                if(e.id==adjNodeId) return i;
            });
           
            adjNodeAdjList = adjNodeArr[adjIndex].adjNode;
            var adjNodeIndex = $.map(adjNodeAdjList,function(e,i){
                if(e.id==nodeID) return i;
            });
            adjNodeArr[adjIndex].adjNode[adjNodeIndex].x = adjNodeArr[nodeIndex].posX;
            adjNodeArr[adjIndex].adjNode[adjNodeIndex].y = adjNodeArr[nodeIndex].posY;
           
            var lineId = $.map(linesArr,function(e,i){
                if((e.nodeS==nodeID && e.nodeE==adjNodeId) || (e.nodeE==nodeID && e.nodeS==adjNodeId)) return e.id;
            });
           
            var lineObj = layer.find('#'+lineId)[0];
            lineObj.setPoints([adjNodeArr[nodeIndex].posX,adjNodeArr[nodeIndex].posY,adjN[i].x,adjN[i].y]);
        }
    }
};

/**
 * Join line when node is dropped another node
 * @param Object Layer
 * @param String name first node
 * @param String name second node
 */
var joinLineAndUpdate = function(layer, aNodeId, bNodeId){
	
    var aNodeIndex = $.map(adjNodeArr,function(e,i){
        if(e.id==aNodeId) return i;
    });
    
    var bNodeIndex = $.map(adjNodeArr,function(e,i){
        if(e.id==bNodeId) return i;
    });
    
    if(bNodeIndex>=0){
        var adjN = adjNodeArr[bNodeIndex].adjNode;
       
        /** Update Node information a to b*/
        adjNodeArr[aNodeIndex].adjNode = adjNodeArr[aNodeIndex].adjNode.concat(adjNodeArr[bNodeIndex].adjNode);
        adjNodeArr[aNodeIndex].lineIds = adjNodeArr[aNodeIndex].lineIds.concat(adjNodeArr[bNodeIndex].lineIds);
        
        for(var i=0; i < adjN.length; i++){       
           
            adjNodeId = adjN[i].id; /** get adjoint node id*/
            var adjIndex = $.map(adjNodeArr,function(e,i){
                if(e.id==adjNodeId) return i;
            });
           
            adjNodeAdjList = adjNodeArr[adjIndex].adjNode;
            var adjNodeIndex = $.map(adjNodeAdjList,function(e,i){
                if(e.id==bNodeId) return i;
            });
            adjNodeArr[adjIndex].adjNode[adjNodeIndex].id = adjNodeArr[aNodeIndex].id;
            adjNodeArr[adjIndex].adjNode[adjNodeIndex].x = adjNodeArr[aNodeIndex].posX;
            adjNodeArr[adjIndex].adjNode[adjNodeIndex].y = adjNodeArr[aNodeIndex].posY;
           
            var lineId = $.map(linesArr,function(e,i){
                if((e.nodeS==bNodeId && e.nodeE==adjNodeId) || (e.nodeE==bNodeId && e.nodeS==adjNodeId)) return e.id;
            });
           
            var lineObj = layer.find('#'+lineId)[0];
            lineObj.setPoints([adjNodeArr[aNodeIndex].posX,adjNodeArr[aNodeIndex].posY,adjN[i].x,adjN[i].y]);
            
            var lineIndex = $.map(linesArr,function(e,i){
                if(e.id==lineId) return i;
            });
            
            linesArr[lineIndex].nodeS = adjNodeArr[aNodeIndex].id;
            linesArr[lineIndex].nodeE = adjNodeId;
            
        }
    }
};