<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- Gallery Page Start -->
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'pages'; ?>">Pages</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
        <form class="panel panel-default" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <input type="hidden" name="page[id]" value="<?php echo $result['id']; ?>">
            <div class="panel-body">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
                    <li class="nav-item">
                        <a class="nav-link active" href="#page-section" data-toggle="tab">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#meta" data-toggle="tab">Meta/Seo</a>
                    </li>
                </ul>
                <div class="tab-content pt-4">
                    <div class="tab-pane active" id="page-section">
                        <div class="form-group">
                            <label>Page Title</label>
                            <input type="text" name="page[title]" class="form-control" value="<?php echo $result['page_title'] ?>" placeholder="Enter Page Name . . .">
                        </div>
                        <div id="gallery-container" class="text-left">
                            <?php if (!empty($gallery)) { foreach ($gallery as $key => $value) { ?>
                                <div class="gallery-picture">
                                    <div><img src="../public/images/gallery/<?php echo $value['media']; ?>" alt="Gallery"></div>
                                    <input type="hidden" class="gallery-picture" value="<?php echo $value['media']; ?>">
                                    <input type="hidden" class="gallery-id" value="<?php echo $value['id']; ?>">
                                    <a data-toggle="tooltip" title="Delete"><i class="ti-trash text-danger"></i></a>
                                </div>
                            <?php } } ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="meta">
                        <div class="form-group">
                            <label>Meta Tag</label>
                            <input type="text" class="form-control" name="page[meta][tag]" value="<?php echo $result['meta_tag']; ?>" placeholder="Enter Meta Tag Title . . ." required>
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="page[meta][description]" class="form-control" placeholder="Enter Meta Tag Description . . ."><?php echo $result['meta_description']; ?></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer text-center">
                <button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-head">
                <div class="panel-title">Upload Gallery Images</div>
            </div>
            <div class="panel-body">
                <div class="gallery-upload">
                    <div class="media-upload-container">
                        <form action="index.php?route=upload/gallery" class="dropzone" id="gallery-dropzone" method="post" enctype="multipart/form-data"><div class="fallback"><input name="file" type="file" /></div></form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	
    //Gallery Image Uplaod 
    $("#gallery-dropzone").dropzone({
    	acceptedFiles: 'image/*',
    	dictDefaultMessage: 'Drop files here or click here to upload',
    	maxFilesize: 2,
        init: function() {
            var reportDropzone = this;
            reportDropzone.on("sending", function(file, xhr, formData) {
                formData.append("_token", $('.s_token').val());
            });

            reportDropzone.on("success", function(file, xhr) {
                var response = JSON.parse(xhr);
                if (response.error === false) {
                    $('#gallery-container').append('<div class="gallery-picture">'+
                        '<div><img src="../public/images/gallery/'+response.file+'" alt="Gallery"></div>'+
                        '<input type="hidden" class="gallery-picture" value="'+response.file+'">'+
                        '<input type="hidden" class="gallery-id" value="'+response.id+'">'+
                        '<a data-toggle="tooltip" data-placement="right" title="Delete"><i class="ti-trash"></i></a>'+
                        '</div>');
                    reportDropzone.removeFile(file);
                } else {
                    toastr.error('Upload Error', response.message);
                    reportDropzone.removeFile(file);
                }
            });

            reportDropzone.on("error", function(file, message) { 
                toastr.error('Upload Error', response.message);
                reportDropzone.removeFile(file); 
            });
        }
    });
    //Gallery Image Delete 
    $('#gallery-container').on('click', '.gallery-picture a',function(){
    	var ele = $(this), ele_par = ele.parent(),
    	name = ele_par.find('.gallery-picture').val(),
    	id = ele_par.find('.gallery-id').val();
    	path = $('input.site_url').val().concat('gallery/delete');
    	$.ajax({
    		method: "POST",
    		url: path,
    		data: { name: name, id: id, _token: $('.s_token').val() },
    		error: function() {
    			alert('Sorry Try Again!');
    		},
    		success: function(response) {
    			response = JSON.parse(response);
    			if (response.error === false) {
    				ele_par.remove();
    				toastr.success('Success', response.message);
    			} else {
    				toastr.error('Error', response.message);
    			}
    		}
    	});
    });
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>