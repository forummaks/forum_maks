// prototype $
function $p() {
	var elements = new Array();
	for (var i = 0; i < arguments.length; i++) {
		var element = arguments[i];
		if (typeof element == 'string')
			element = document.getElementById(element);
		if (arguments.length == 1)
			return element;
		elements.push(element);
	}
	return elements;
}

// from http://www.dustindiaz.com/rock-solid-addevent/
function addEvent(obj, type, fn) {
	if (obj.addEventListener) {
		obj.addEventListener(type, fn, false);
		EventCache.add(obj, type, fn);
	}
	else if (obj.attachEvent) {
		obj["e" + type + fn] = fn;
		obj[type + fn] = function () {
			obj["e" + type + fn](window.event);
		}
		obj.attachEvent("on" + type, obj[type + fn]);
		EventCache.add(obj, type, fn);
	}
	else {
		obj["on" + type] = obj["e" + type + fn];
	}
}

var EventCache = function () {
	var listEvents = [];
	return {
		listEvents: listEvents,
		add: function (node, sEventName, fHandler) {
			listEvents.push(arguments);
		},
		flush: function () {
			var i, item;
			for (i = listEvents.length - 1; i >= 0; i = i - 1) {
				item = listEvents[i];
				if (item[0].removeEventListener) {
					item[0].removeEventListener(item[1], item[2], item[3]);
				}
				if (item[1].substring(0, 2) != "on") {
					item[1] = "on" + item[1];
				}
				if (item[0].detachEvent) {
					item[0].detachEvent(item[1], item[2]);
				}
				item[0][item[1]] = null;
			}
		}
	};
}();
if (document.all) {
	addEvent(window, 'unload', EventCache.flush);
}

function imgFit(img, maxW) {
	img.title = 'Размеры изображения: ' + img.width + ' x ' + img.height;
	if (typeof(img.naturalHeight) == 'undefined') {
		img.naturalHeight = img.height;
		img.naturalWidth = img.width;
	}
	if (img.width > maxW) {
		img.height = Math.round((maxW / img.width) * img.height);
		img.width = maxW;
		img.title = 'Нажмите на изображение, чтобы посмотреть его в полный размер';
		img.style.cursor = 'move';
		return false;
	}
	else if (img.width == maxW && img.width < img.naturalWidth) {
		img.height = img.naturalHeight;
		img.width = img.naturalWidth;
		img.title = 'Размеры изображения: ' + img.naturalWidth + ' x ' + img.naturalHeight;
		return false;
	}
	else {
		return true;
	}
}

function toggle_block(id) {
	var el = document.getElementById(id);
	el.style.display = (el.style.display == 'none') ? '' : 'none';
}

function toggle_disabled(id, val) {
	document.getElementById(id).disabled = (val) ? 0 : 1;
}

function rand(min, max) {
	return min + Math.floor((max - min + 1) * Math.random());
}

// Cookie functions
/**
 * name       Name of the cookie
 * value      Value of the cookie
 * [days]     Number of days to remain active (default: end of current session)
 * [path]     Path where the cookie is valid (default: path of calling document)
 * [domain]   Domain where the cookie is valid
 *            (default: domain of calling document)
 * [secure]   Boolean value indicating if the cookie transmission requires a
 *            secure transmission
 */
function setCookie(name, value, days, path, domain, secure) {
	if (days != 'SESSION') {
		var date = new Date();
		days = days || 365;
		date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
		var expires = date.toGMTString();
	} else {
		var expires = '';
	}

	document.cookie =
		name + '=' + escape(value)
			+ ((expires) ? '; expires=' + expires : '')
			+ ((path) ? '; path=' + path : ((cookiePath) ? '; path=' + cookiePath : ''))
			+ ((domain) ? '; domain=' + domain : ((cookieDomain) ? '; domain=' + cookieDomain : ''))
			+ ((secure) ? '; secure' : ((cookieSecure) ? '; secure' : ''));
}

/**
 * Returns a string containing value of specified cookie,
 *   or null if cookie does not exist.
 */
function getCookie(name) {
	var c, RE = new RegExp('(^|;)\\s*' + name + '\\s*=\\s*([^\\s;]+)', 'g');
	return (c = RE.exec(document.cookie)) ? c[2] : null;
}

/**
 * name      name of the cookie
 * [path]    path of the cookie (must be same as path used to create cookie)
 * [domain]  domain of the cookie (must be same as domain used to create cookie)
 */
function deleteCookie(name, path, domain) {
	setCookie(name, '', -1, path, domain);
}