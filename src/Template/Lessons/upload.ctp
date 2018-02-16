<?php $this->assign('title', 'lessons'); ?>
<!-- Main content -->
<section class="content-header">
    <!-- Dropzone Css -->
    <link href="<?= SITE_URL ?>/bsb/plugins/dropzone/dropzone.css" rel="stylesheet">
    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <h2>Upload Lessons</h2>
            </div>
            <div class="body">


                <div class="col-sm-4">
                    <label>Department</label>
                    <select class="form-control" id='department_id' name='department_id' data-live-search="true">
                        <option value="" selected disabled="">Please select Department</option>
                        <?php foreach($departments as $key => $value) { ?>
                            <option value="<?= $key ?>" ><?=$value?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-sm-4">
                    <label>Course</label>
                    <select class="form-control" id='course_id' name='course_id' data-live-search="true">
                        <option value="" selected disabled="">Please select Course</option>
                        <?php foreach($courses as $key => $value) { ?>
                            <option value="<?= $key ?>" ><?=$value?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-sm-4">
                    <label>Subject</label>
                    <select class="form-control" id='subject_id' name='role' data-live-search="true" >
                        <option value="" selected disabled="">Please select Subject</option>
                        <?php foreach($subjects as $key => $value) { ?>
                            <option value="<?= $key ?>" ><?=$value?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- File Upload | Drag & Drop OR With Click & Choose -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    Files to upload (*.doc, *.docx)
                                </h2>
                            </div>
                            <div class="body">
                                <form action="<?= SITE_URL . '/lessons/files'  ?>" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">touch_app</i>
                                        </div>
                                        <h3>Drop files here or click to upload.</h3>
                                        <em>File only accepted: <strong>MS Word (*.doc, *docx), PDF file (*.pdf)</strong></em>
                                    </div>
                                    <div class="fallback">
                                        <input name="file" type="file" multiple/> <!--  accept="application/msword, application/pdf, application/vnd.ms-excel, application/vnd.ms-powerpoint,"-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# File Upload | Drag & Drop OR With Click & Choose -->

                <!-- <button type="submit" class="btn btn-primary m-t-15 waves-effect sent" >Save</button> -->
                <input type="button" value="Start Upload" id="save" class="btn btn-primary m-t-15 waves-effect sent">
                <input type="button" value="Clear Files" id="clear" class="btn btn-primary m-t-15 waves-effect sent">

            </div>
        </div>


    </div>
    <script src="<?=SITE_URL?>/bsb/plugins/jquery/jquery.min.js"></script>
    <!-- Dropzone Plugin Js -->
    <script src="<?= SITE_URL ?>/bsb/plugins/dropzone/dropzone.js"></script>
    <script type="text/javascript">

        //Dropzone
        var urls = "<?= SITE_URL . '/lessons/files'  ?>"
        var subject_id = null;
        var section_id = null;

        var myDropzone = new Dropzone("#frmFileUpload",
        {
            paramName: "file",
            autoProcessQueue: false,
            // maxFilesize: 2, // MB
            acceptedFiles: 'application/msword, application/msppt, application/pdf,.docx', // MB
            init: function() {
                this.on("success", function(file, responseText) {
                    console.log(responseText);
                    params = responseText['params']

                    var msgs = params['filename'] +
                                    ((params['response'] == 'success') ?
                                        ':Upload Successful' :
                                        ':Upload Error')
                                   ;
                    var type = (params['response'] == 'success') ? 'bg-black' : 'bg-red';

                    showMessage(msgs, type);

                });
                this.on("processing", function(file) {
                    this.options.url = urls + '?subject_id=' + $('#subject_id').val() + '&department_id=' + $('#department_id').val() +  '&course_id=' + $('#course_id').val();
                });
            }
        });

        var button = document.getElementById('save');

        button.onclick = function() {
            department_id = $('#department_id').val();
            course_id     = $('#course_id').val();
            subject_id    = $('#subject_id').val();

            if (( subject_id == null) || ( department_id == null) || ( course_id == null)){
                var msgs = 'Please select department, course and subject';
                var type = 'bg-red';

                showMessage(msgs, type);

            } else {

                myDropzone.processQueue();
            }
        };

        var btnClear = document.getElementById('clear');

        btnClear.onclick = function() {
            myDropzone.removeAllFiles();
        };

        var Upload = function (file) {
            this.file = file;
        };

        Upload.prototype.getType = function() {
            return this.file.type;
        };
        Upload.prototype.getSize = function() {
            return this.file.size;
        };
        Upload.prototype.getName = function() {
            return this.file.name;
        };
        Upload.prototype.doUpload = function () {
            var that = this;
            var formData = new FormData();

            // add assoc key values, this will be posts values
            formData.append("file", this.file, this.getName());
            formData.append("upload_file", true);

                $.ajax({
                type: "POST",
                url: urls,
                xhr: function () {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', that.progressHandling, false);
                    }
                    return myXhr;
                },
                success: function (data) {
                    // your callback here
                    console.log(data);
                },
                error: function (error) {
                    // handle error
                    console.log('error');
                },
                async: true,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 60000
            });
        };
    </script>
</section>