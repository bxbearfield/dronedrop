function createRequest() {
	try {
		request = new XMLHttpRequest();
		
	} catch (tryMS) {
		try {
			request = new ActiveXObject("Msxml2.XMLHTTP");
			
		} catch (otherMS) {
			try {
				request = new ActiveXObject("Microsoft.XMLHTTP");
				
			} catch (failed) {
				request = null;
			}
		}
	}
	return request;
}

function addEventHandler (obj, event, handler) {
	if(document.addEventListener) {
		obj.addEventListener(event, handler, true);
	} else if (document.attachEvent) {
		obj.attachEvent("on" + event, handler);
	}
}

HTMLElement.prototype.removeClass = function(remove) {
    var newClassName = "";
    var i;
	var classes = this.className.split(" ");
	
    for(i = 0; i < classes.length; i++) {
        if(classes[i] !== remove) {
            newClassName += classes[i] + " ";
        }
    }
    this.className = newClassName;
}

function getActivatedObject (e) {
	var obj;
	
	if (!e) { 
		//early version of IE
		obj = window.event.srcElement;
		
	} else if (e.srcElement) {
	
		// IE 7 or later
		obj = e.srcElement;
		
	} else {
		//DOM level 2 browsers
		obj = e.currentTarget;
	}
	return obj;
}
function getId(id){return document.getElementById(id)};
function getNode(s){return document.querySelector(s)}
