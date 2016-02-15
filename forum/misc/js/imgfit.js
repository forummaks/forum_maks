function imgFit_Onload (context)
{
	var context = context || 'body';
	var $img = $('img.postImg', $(context));
	if ($.browser.msie || context == 'body') {
		$img.each(function(){ imgFit(this); });
	} else {
		$img.load(function(){ imgFit(this); });
	}
	$img.click(function(){ return imgFit(this); });
}

function imgFit (img, maxW)
{
	if (typeof(img.naturalWidth) == 'undefined') {
		img.naturalHeight = img.height;
		img.naturalWidth  = img.width;
	}
	if (!maxW) {
		var id = img.getAttribute('id');
		var wd = img.width;

		if (id && wd) {
			if (id == 'postImg' && wd >= postImg_MaxWidth) {
				maxW = postImg_MaxWidth;
			}
			else if (id == 'postImgAligned' && wd >= postImgAligned_MaxWidth) {
				maxW = postImgAligned_MaxWidth;
			}
			else if (id == 'attachImg' && wd >= attachImg_MaxWidth) {
				maxW = attachImg_MaxWidth;
			}
		}
		else {
			return false;
		}
	}

	if (img.width > maxW) {
		img.height = Math.round((maxW/img.width)*img.height);
		img.width  = maxW;
		img.title  = 'Click image to view full size';
		img.style.cursor = 'move';
		return false;
	}
	else if (img.width == maxW && img.width < img.naturalWidth) {
		img.height = img.naturalHeight;
		img.width  = img.naturalWidth;
		img.title  = 'Click to fit in the browser window';
		return false;
	}

	return true;
}