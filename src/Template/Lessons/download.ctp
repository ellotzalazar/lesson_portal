<?php $this->assign('title', 'lessons'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= SITE_URL ?>/lte/plugins/datatables/dataTables.bootstrap.css">
<!-- Main content -->
<section class="content-header">
	<div class="card">
        <div class="header">
            <h2>Download Lessons</h2>
        </div>
        <div class="body">
        	<div class="row clearfix">
        		<div class="col-sm-3">
                    <label>Department</label>
                    <select class="form-control" id='department_id' name='department_id' data-live-search="true">
                        <option value="" selected disabled="">Please select Department</option>
                        <?php foreach($departments as $key => $value) { ?>
                            <option value="<?= $key ?>" ><?=$value?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-sm-3">
                    <label>Course</label>
                    <select class="form-control" id='course_id' name='course_id' data-live-search="true">
                        <option value="" selected disabled="">Please select Course</option>
                        <?php foreach($courses as $key => $value) { ?>
                            <option value="<?= $key ?>" ><?=$value?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-sm-3">
                    <label>Subject</label>
                    <select class="form-control" id='subject_id' name='role' data-live-search="true" >
                        <option value="" selected disabled="">Please select Subject</option>
                        <?php foreach($subjects as $key => $value) { ?>
                            <option value="<?= $key ?>" ><?=$value?></option>
                        <?php } ?>
                    </select>
                </div>

	            <div class="col-sm-3">
	                <label>Teacher</label>
	                <select class="form-control show-tick" id='teacher_id' name='teacher_id' data-live-search="true">
	                    <option value="" selected disabled="">Please select Teachers</option>
	                    <?php foreach($teachers as $key => $value) { ?>
	                        <option value="<?= $key ?>" ><?=$value?></option>
	                    <?php } ?>
	                </select>
	            </div>
        	</div>
        	<input type="button" value="Start Search" id="search" class="btn btn-primary m-t-15 waves-effect sent" onclick="getdata();">
        	<div class="row clearfix">
        		<div class="card">
	                <div class="header">
	                    <h2>Lessons Lists</h2>
	                </div>
	                <!-- /.box-header -->
	                <div class="body table-responsive">
		                <table id="tblLessons" class="table table-condensed">
		                    <col width="40px">
		                    <thead>
		                        <tr>
		                            <th><?= $this->Paginator->sort('id', 'Id') ?></th>
		                            <th><?= $this->Paginator->sort('name') ?></th>
		                            <th><?= $this->Paginator->sort('created', 'Upload Date') ?></th>
		                            <th class="actions"><?= __('Click to Download') ?></th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                    </tbody>
		                </table>

		            </div>
	        	</div>
        	</div>
        </div>
    </div>
    <script src="<?=SITE_URL?>/bsb/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript">
    	function getdata(){
    		var URL = "<?= SITE_URL . '/lessons/filter'; ?>";

    		formData = {};

    		var subject_id = $('#subject_id').val();
            var section_id = $('#section_id').val();
            var teacher_id = $('#teacher_id').val();

            if (subject_id != null)
            	formData['subject_id']= subject_id;
            if (section_id != null)
            	formData['section_id'] = section_id;
            if (teacher_id != null)
            	formData['teacher_id'] = teacher_id;

            $.ajax({
				url: URL,
				context: document.body,
				dataType: 'json',
				data: formData,
				success: function(data){
					// console.log(data);
					var lessons = data.params.lessons;
					var tblLessons = document.getElementById('tblLessons');
					$(tblLessons).find('tbody tr').remove();
					for (var i in lessons){
						_content = "<tr>";

						_content += '<td>' + lessons[i].id + '</td>';
						_content += '<td>' + lessons[i].name + '</td>';
						_content += '<td>' + lessons[i].created + '</td>';
						_content += '<td><a href="' + lessons[i].dl + '"><i class="material-icons" download>file_download</i></a></td>';

						_content += "</tr>";

						$(tblLessons).find('tbody').append(_content);

					}
				},
				error: function (xhr, ajaxOptions, thrownError){
					var type = 'bg-red';
					var msgs = 'Error: ' + xhr.responseText;
					showMessage(msgs, type);
				}
            });
    	}


    </script>
</section>