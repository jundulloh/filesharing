<style type="text/css">
	.main-dashboard
	{
		margin-top: 1em;
	}
	.active_row
	{
		background-color: whitesmoke !important;
	}
	.table>tbody>tr
	{
		cursor: default;
	}
	.on-hide
	{
		display: none;
	}
	.onselectedFile
	{
		margin: .3em .3em 1em .3em;
	}

	.fileupload
	{
		display: none;
	}
</style>
<div class="main-dashboard">
	<div class="row">
		<div class="col-md-3">
			<div class="list-group">
				<a href="#" class="list-group-item"><span class="glyphicon glyphicon-file"></span> Files <span class="glyphicon glyphicon-chevron-right pull-right"></span></a>
				<a href="#" class="list-group-item"><span class="glyphicon glyphicon-picture"></span> Photos <span class="glyphicon glyphicon-chevron-right pull-right"></span></a>
				<a href="#" class="list-group-item"><span class="glyphicon glyphicon-duplicate"></span> Documents <span class="glyphicon glyphicon-chevron-right pull-right"></span></a>
				<a href="#" class="list-group-item"><span class="glyphicon glyphicon-copy"></span> Share <span class="glyphicon glyphicon-chevron-right pull-right"></span></a>
				<a href="#" class="list-group-item"><span class="glyphicon glyphicon-link"></span> Links <span class="glyphicon glyphicon-chevron-right pull-right"></span></a>
			</div>
			<div class="list-group list-user-dashboard">
				<a href="#" class="list-group-item active"> Send File To </a>
				
			</div>
		</div>
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="onselectedFile on-hide pull-left">
								<div class="btn-group" role="group" aria-label="...">
									<button type="button" class="btn btn-default btn-sm">Download</button>
									<button type="button" class="btn btn-default btn-sm">Delete</button>
									<button type="button" class="btn btn-default btn-sm">Rename</button>
									<button type="button" class="btn btn-default btn-sm">Move</button>
									<button type="button" class="btn btn-default btn-sm">Copy</button>
								</div>
									<button type="button" class="btn btn-default btn-sm close-selectedFile">Close</button>
							</div>
							<div class="btn btn-primary pull-right uploadFile"> Upload File </div>
						</div>
					</div>
					<hr>
					<!-- table file -->
					<table class="table table-bordered table-hover table-file">
						<thead>
							<tr>
								<th>No.</th>
								<th> Name </th>
								<th> Kind </th>
								<th> Created </th>
								<th> Action </th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload New File</h4>
      </div>
      <div class="modal-body">
      	
      </div>
      <div class="modal-footer">
      	<button class="btn btn-default btn-addupload pull-left" type="button">Add More Files</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>

<div class="sr-only">
	<!-- property dashboard -->

	<!-- user list -->

</div>

<script type="text/javascript">
	function write_alert(type, text, element, using)
	{
		var alert = '<div class="alert alert-'+type+'">'+text+'</div>';
		if(using == 'prepend')
		{
			$(element).prepend(alert);
		}else if(using == 'append')
		{
			$(element).append(alert);
		}
	}
	function write_list_queue(file)
	{
		var list = '<div class="list-group-item"> <div class="row"> <div class="col-md-4">'+file.name+'</div>';
		list += '<div class="col-md-5"><div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">0% Complete</span></div></div> </div>';
		list += ' <span class="badge"> '+file.size+' kb </span> ';
		list += '</div></div>';
		return list;
	}

	function write_user(data)
	{
		var userlist =	'<a href="'+link_action('pages/sent_file_to/'+data.user_qr)+'" class="list-group-item sent_file_user"> '
		userlist +=	'<span class="glyphicon glyphicon-user"></span> '+data.fname;
		userlist +=	'</span></a>'
		return userlist;
	}
	
	$(function(){
		var dataFile 	= link_action('file_controller/file_list');
		var table = $('.table-file').DataTable( {
	        ajax: dataFile
	    });

		get_user();
		$(document).delegate('.table-file tbody tr', 'click', function(){
			if($('.table-file tbody tr td').hasClass('dataTables_empty') == true)
			{
				return false
			}else
			{

			 	$('.table tbody tr').removeClass('active_row');
			 	$(this).addClass('active_row');
			 	$('.onselectedFile').removeClass('on-hide');
			}
		})

		$('.container').on('click', function(){
		 	$('.table tbody tr').removeClass('active_row');
		 	// $('.onselectedFile').addClass('on-hide');	
		})

		$('.close-selectedFile').on('click', function(){
		 	$('.table tbody tr').removeClass('active_row');
		 	$('.onselectedFile').addClass('on-hide');	
		})

		$(document).delegate('.uploadFile', 'click', function(){
			var link_upload = link_action('pages/uploadfile');
			$('#modalUpload .modal-body').load(link_upload);

		 	$('#modalUpload').modal({
		 		keyboard: false,
		 		backdrop: 'static'
		 	});
		})

		$(document).delegate('.sent_file_user, .btn-share', 'click', function(event){
			event.preventDefault();
			var link_upload = $(this).attr('href');
			$('#modalUpload .modal-body').load(link_upload);

		 	$('#modalUpload').modal({
		 		keyboard: false,
		 		backdrop: 'static'
		 	});
		})

		$('#modalUpload').on('hidden.bs.modal', function (e) {
		  	// do something...
		  	table.ajax.reload();
		  	$('#modalUpload .modal-body').html('');
		})

		$(document).delegate('.btn-addupload', 'click', function(){
			$('#fileupload').trigger('click');
		});

		$(document).delegate('.btn-submit-share', 'click', function(event){
			event.preventDefault();
			var href = $('#share-form').attr('action');
			var data = $('#share-form').serializeArray();
		    $.post(href, data)
		    .done(function(data){
		    	$('#modalUpload').modal('hide');
		    	alert('file has been share');
		    })
			// console.log(data);
		});


		$(document).delegate('#fileupload', 'change', function(){
			var value = $(this).val();
		    if(value == '')
		    {
		        return false;
		    }
		    var formdata = new FormData();
		    var formupl = $('#form_uploadfile').attr('action');
		    var file = document.getElementById('fileupload').files;
		    console.log(file);
		    $.each(file, function(i, val){
			    var data_append = write_list_queue(val);
			    $('.list-queue-upload').append(data_append)
	            
	            $.each(file[i], function(index, filedata) {
		            formdata.append('file-'+i, val);
		        });

		    })
		    sendajax(formupl, formdata);
	    	write_alert('success', 'Your File has been successfully uploaded', '.modal-body', 'prepend');
		    setTimeout(function(){
		    	$('.modal-body .alert').remove();
		    }, 2000);
		})

	})
</script>