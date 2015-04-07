function previewImage(data, img_element)
{
	var reader      = new FileReader();
	reader.onloadend = function()
	{
	        img_element.src = reader.result;                // document.getElementById('foo'); one of parameters which use to display result
	        $('.image_swipe').attr('href', reader.result);  // if you want to add more result to other element
	}
	reader.readAsDataURL(data);
}

function get_user()
{
	var link = link_action('form/get_user');
	$.post(link)
	.done(function(data){
		var obj = JSON.parse(data);
		$.each(obj.users, function(i, val){
			$('.list-user-dashboard').append(write_user(val));
		})
	})
}
	
function sendajax(url, data)
{
	$.ajax({
		xhr: function()
		{
			var xhr = new window.XMLHttpRequest();
		    //Upload progress
			// if($('.progress') != 'undefined')
			// {
			    xhr.upload.addEventListener("progress", function(evt){
			    	if (evt.lengthComputable) {
			    		var percentComplete = evt.loaded / evt.total;
			    		var num = percentComplete*100;
			       		var percent = num.toFixed(0);
			       		$('.progress').removeClass('sr-only');
			        	$('.progress-bar').attr('aria-valuenow',percent);
			        	$('.progress-bar').css('width',percent+'%');
			        	// $('.progress-bar').html(percent+'%');
			        	if(percent == 100)
			        	{
			       		$('.progress').remove();
			        	}
			      	}
			    }, false);
			    //Download progress
			    xhr.addEventListener("progress", function(evt){
			      	if (evt.lengthComputable) {
			        	var percentComplete = evt.loaded / evt.total;
			        	//Do something with download progress
			        	var num = percentComplete*100;
			        	// console.log(num.toFixed(2));
			      	}
			    }, false);
			// }		
		    return xhr;
		},
		type 		: 'POST',
		url 		: url,
		cache		: true,
		contentType	: false,
    	processData	: false,
		data 		: data,
		success 	: function(data)
		{
			console.log(data);
		}
	});
}