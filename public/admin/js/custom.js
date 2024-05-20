$(document).ready(function(){
	
	window.Parsley.addValidator('mobile10', {
		validateString: function(value) {
			var digits = value.replace(/\D/g, '');
			return digits.length === 10;
		},
		messages: {
			en: 'Please enter a valid 10-digit mobile number.',
		},
	});
	$(".dropify").dropify();
	
	// $('.summernote').summernote({
	// 	placeholder: 'Description',
	// 	tabsize: 2,
	// 	height: 120,
	// 	toolbar: [
	// 		['style', ['style']],
	// 		['font', ['bold', 'underline', 'clear']],
	// 		['color', ['color']],
	// 		['para', ['ul', 'ol', 'paragraph']],
	// 		['table', ['table']],
	// 		['insert', ['link', 'picture', 'video']],
	// 		['view', ['fullscreen', 'codeview', 'help']]
	// 	]
	// });	


	$('.summernote').summernote({
		placeholder: 'Description',
		tabsize: 2,
		height: 120,
		toolbar: [
		  ['style', ['style']],
		  ['font', ['bold', 'underline', 'clear']],
		  ['color', ['color']],
		  ['para', ['ul', 'ol', 'paragraph']],
		  ['table', ['table']],
		  ['insert', ['link', 'picture', 'video']],
		  ['view', ['fullscreen', 'codeview', 'help']]
		],
		callbacks: {
			onPaste: function (e) {
			  var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('text/html');
			  e.preventDefault();
			  var div = $('<div></div>');
			  div.append(bufferText);
			  div.find('*').removeAttr('style');
			  setTimeout(function () {
				document.execCommand('insertHtml', false, div.html());
			  }, 10);
			}
		  },
		// lowercaseAttributes: false,
		codeviewFilter: false, // Disable filtering of HTML code
		codeviewIframeFilter: false // Disable filtering of HTML code inside iframe
	  });


	$(".form").parsley();
	
	// form submit 
	$(".form").submit(function(event){
		event.preventDefault();
		var csrfToken = $('meta[name="csrf-token"]').attr('content');
		var action = $(this).attr('action');
		var method = $(this).attr('method');
		var formData = new FormData(this);
		var data = {};
		formData.forEach(function(value, key){
			data[key] = value;
		});
		if ($(this).parsley().isValid()) {
			$.ajax({
				url: action,
				method: method,
				data: data,
				headers: {
					'X-CSRF-TOKEN': csrfToken
				},
				beforeSend: function() {
					$(".main-spinner").removeClass('d-none');
					$(".submitBtn").attr('disabled',true);
				},
				success:function(response){
					var jsondata  = JSON.parse(response);
					console.log(jsondata);
					if(jsondata.res =='success')
					{
						iziToast.success({
							title: 'OK',
							message: jsondata.msg,
						});
						setTimeout(function(){
							window.location.reload();
						},900);
					}
					else
					{
						iziToast.error({
							title: 'Error',
							message: jsondata.msg,
						});
						$(".main-spinner").addClass('d-none');
						$(".submitBtn").attr('disabled',false);
					}
					
				},
				error:function(response)
				{
					console.log(response);
					iziToast.error({
						title: 'Error',
						message: 'Something went wrong',
					});
					$(".main-spinner").addClass('d-none');
					$(".submitBtn").attr('disabled',false);
				}
			});
		}
	});
	
	// form submit 
	$(".form-icon").submit(function(event){
		event.preventDefault();
		var csrfToken = $('meta[name="csrf-token"]').attr('content');
		var action = $(this).attr('action');
		var method = $(this).attr('method');
		var formData = new FormData(this);
		// var data = {};
		// formData.forEach(function(value, key){
		//   data[key] = value;
		// });
		if ($(this).parsley().isValid()) {
			$.ajax({
				url: action,
				method: method,
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				headers: {
					'X-CSRF-TOKEN': csrfToken
				},
				beforeSend: function() {
					$(".main-spinner").removeClass('d-none');
					$(".submitBtn").attr('disabled',true);
				},
				success:function(response){
					var jsondata  = JSON.parse(response);
					console.log(jsondata);
					if(jsondata.res =='success')
					{
						iziToast.success({
							title: 'OK',
							message: jsondata.msg,
						});
						setTimeout(function(){
							window.location.reload();
						},900);
					}
					else
					{
						iziToast.error({
							title: 'Error',
							message: jsondata.msg,
						});
						$(".main-spinner").addClass('d-none');
						$(".submitBtn").attr('disabled',false);
					}
					
				},
				error:function(response)
				{
					console.log(response);
					iziToast.error({
						title: 'Error',
						message: 'Something went wrong',
					});
					$(".main-spinner").addClass('d-none');
					$(".submitBtn").attr('disabled',false);
				}
			});
		}
	});
	
});

function logout(url)
{
    swal({
        title: "Are you sure?",
        text: "You want to logout!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
	})
	.then((willDelete) => {
        if (willDelete) {
            $.ajax({
				url: url,
				type:"GET",
				success:function(response){
					console.log(response);
					var jsonres = JSON.parse(response);
					if(jsonres.res =='success')
					{
						swal(jsonres.res, {
							icon: "success",
						});
						}else{
						swal(jsonres.res, {
							icon: "error",
						});
					}
					if(jsonres.redirect_url != null)
                    {
						setTimeout(function() {
							window.location.href = jsonres.redirect_url;
						}, 900);
					}
					
				},
				error:function(response)
				{
					console.log(response);
				}
			});
			} else {
			swal("Your session is safe!");
		}
	});
}

function deleteItem(url)
{
	swal({
		title: "Are you sure?",
		text: "Once deleted, you will not be able to recover this data!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url: url,
				type:"GET",
				success:function(response){
					console.log(response);
					var jsonres = JSON.parse(response);
					if(jsonres.res =='success')
					{
						swal(jsonres.res, {
							icon: "success",
						});
						setTimeout(function() {
							window.location.reload();
						}, 900);   
						}else{
						swal(jsonres.res, {
							icon: "error",
						});
					}       
				},
				error:function(response)
				{
					console.log(response);
				}
			});
			} else {
			swal("Your data is safe!");
		}
	});
}
// delete multiple data 
$('.delete_all').on('click', function (e) {
	var action_url = $("#url").val();
	var allVals = [];
	$(".checkbox_animated:checked").each(function () {
		allVals.push($(this).attr('data-id'));
	}); 
	if (allVals.length <= 0) {
		alert("Please select row.");
		} else {
		WRN_PROFILE_DELETE = "Are you sure you want to delete this row?";
		var check = confirm(WRN_PROFILE_DELETE);
		if (check == true) {
			$.each(allVals, function (index, value) {
				$.ajax({
					url: action_url+'/'+value,
					type:'GET',
					success:function(res)
					{
						var jsondata = JSON.parse(res);
						if(jsondata.res =='success'){
							$('table tr').filter("[data-row-id='" + value + "']").remove();
						}
						else{
							iziToast.error({
								title: 'Error',
								message: jsondata.msg,
							});
						}
						
					},
					error:function(res)
					{
						console.log(res);	
					}
				});
			});
		}
	}
});	