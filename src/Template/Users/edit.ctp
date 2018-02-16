<?php $this->assign('title', 'users'); ?>
<!-- Main content -->
<section class="content-header">
    <div class="col-md-12">
        <div class="block-header">
            <h2>Edit <?= $this->request->session()->read('Auth.User.id') == $user->id ? 'Profile' : 'User' ?></h2>
        </div>
        <?= $this->Form->create($user, ['role' => 'form', 'enctype' => 'multipart/form-data']) ?>
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h2>Upload Image</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="#" onClick="clearImage(this); return false;" title="Remove">
                                Clear Image
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="body">

                    <div class="form-group">
                        <div id="img">
                            <img class="profile-user-img img-responsive img-circle" id="img_src" name="img_src" src="<?= SITE_URL . '/img/users/' . (!empty($user->image) ? $user->image : 'default-user.png'); ?>" style="width: 200px ;height: 200px;" />
                            <div class="img_caption"></br></div>
                        </div>
                        <input type="file" id="image" name='image' onChange = "readURL(this)" accept="image/*" style="width: 100%; ">
                        <p class="help-block"><?= IMG_SIZE_NOTE ?></p>
                        <script src="<?=SITE_URL?>/bsb/plugins/jquery/jquery.min.js"></script>
                        <script type="text/javascript">
                            function readURL(input) {

                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    target_img = $(input).parent().parent().find('div');

                                    reader.onload = function (e) {
                                        $(target_img).find('img').attr('src', e.target.result);
                                        $(target_img).show();
                                    }
                                    reader.readAsDataURL(input.files[0]);

                                    $(target_img).find('input[id="img_del"]').remove();
                                }
                            }


                            function clearImage(input){
                                //alert('here');
                                //$('div[id="img"]').hide();
                                $(input).parent().parent().parent().parent().parent().append('<input id="img_del" name="img_del" type = "hidden"/>' );
                                $('input[id="logo"]').val('');
                                $(input).parent().parent().parent().parent().parent().find('img').attr('src','<?= SITE_URL . "/img/users/default-user.png"?>');
                            }

                            $.fn.ImageResize = function (options) {
                                var defaults = {
                                    maxWidth: Number.MAX_VALUE,
                                    maxHeigt: Number.MAX_VALUE,
                                    onImageResized: null
                                }
                                var settings = $.extend({}, defaults, options);
                                var selector = $(this);

                                selector.each(function (index) {
                                    var control = selector.get(index);
                                    if ($(control).prop("tagName").toLowerCase() == "input" && $(control).attr("type").toLowerCase() == "file") {
                                        $(control).attr("accept", "image/*");
                                        $(control).attr("multiple", "true");

                                        control.addEventListener('change', handleFileSelect, false);
                                    }
                                    else {
                                        console.log("Invalid file input field");
                                    }
                                });

                                function handleFileSelect(event) {
                                    //Check File API support
                                    if (window.File && window.FileList && window.FileReader) {
                                        var count = 0;
                                        var files = event.target.files;

                                        for (var i = 0; i < files.length; i++) {
                                            var file = files[i];
                                            //Only pics
                                            if (!file.type.match('image')) continue;

                                            var picReader = new FileReader();
                                            picReader.addEventListener("load", function (event) {
                                                var picFile = event.target;
                                                var imageData = picFile.result;
                                                var img = new Image();
                                                img.src = imageData;
                                                img.onload = function () {
                                                    if (img.width > settings.maxWidth || img.height > settings.maxHeigt) {
                                                        var width = settings.maxWidth;
                                                        var height = settings.maxHeigt;

                                                        if (img.width > settings.maxWidth) {
                                                            width = settings.maxWidth;
                                                            var ration = settings.maxWidth / img.width;
                                                            height = Math.round(img.height * ration);
                                                        }

                                                        if (height > settings.maxHeigt) {
                                                            height = settings.maxHeigt;
                                                            var ration = settings.maxHeigt / img.height;
                                                            width = Math.round(img.width * ration);
                                                        }

                                                        var canvas = $("<canvas/>").get(0);
                                                        canvas.width = width;
                                                        canvas.height = height;
                                                        var context = canvas.getContext('2d');
                                                        context.drawImage(img, 0, 0, width, height);
                                                        imageData = canvas.toDataURL();

                                                        if (settings.onImageResized != null && typeof (settings.onImageResized) == "function") {
                                                            settings.onImageResized(imageData);
                                                        }
                                                    }

                                                }
                                                img.onerror = function () {

                                                }
                                            });
                                            //Read the image
                                            picReader.readAsDataURL(file);
                                        }
                                    } else {
                                        console.log("Your browser does not support File API");
                                    }
                                }
                            }

                            $('input[id="logo"]').ImageResize(
                            {
                                maxWidth: 200,
                                maxHeigth: 200,
                                onImageResized: function (imageData) {
                                    $('img[id="img_src"]').attr('src', imageData);
                                }
                            });
                            <?php if (isset($_logo)){ ?>
                                _logo = "<?= $_logo ?>";
                                // alert(_logo);
                                if(_logo == "")
                                    $('div[id="img"]').hide();
                                // else
                                //     $('img[id="img_src"]', {
                                //         'src': _logo
                                //     });
                            <?php } ?>

                            $('input').iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%' // optional
                            });

                            $('form').validate({
                                rules: {
                                    new_password: "",
                                    confirm_password: {
                                        equalTo: "#new_password"
                                    }
                                }
                            });
                            //Money Euro
                                 $("[data-mask]").inputmask();
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <?php if($this->request->session()->read('Auth.User.role') == 3){ ?>
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h2>Assignments</h2>
                    </div>
                    <div class="body">
                        <h2 class="card-inside-title">Department</h2>
                        <div class="demo-checkbox">

                            <?php foreach ($departments as $key => $value): ?>

                                <input type="checkbox" name="department[]" id="department-<?= $key?>" value="<?= $key?>"
                                    <?= in_array($key, $assigments['departments']) ? 'checked' : '' ?> >
                                <label for="department-<?= $key?>"><?= $value?></label>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="card-inside-title">Year level</h2>
                        <div class="demo-checkbox">
                            <?php foreach ($yearlevels as $key => $value): ?>
                                <input type="checkbox" name="yearlevel[]" id="yearlevel-<?= $key?>" value="<?= $key?>"
                                    <?= in_array($key, $assigments['yearlevels']) ? 'checked' : '' ?> >
                                <label for="yearlevel-<?= $key?>"><?= $value?></label>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="card-inside-title">Section</h2>
                        <div class="demo-checkbox">
                            <?php foreach ($sections as $key => $value): ?>
                                <input type="checkbox" name="section[]" id="section-<?= $key?>" value="<?= $key?>"
                                    <?= in_array($key, $assigments['sections']) ? 'checked' : '' ?> >
                                <label for="section-<?= $key?>"><?= $value?></label>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="card-inside-title">Course</h2>
                        <div class="demo-checkbox">
                            <?php foreach ($courses as $key => $value): ?>
                                <input type="checkbox" name="course[]" id="course-<?= $key?>" value="<?= $key?>"
                                    <?= in_array($key, $assigments['courses']) ? 'checked' : '' ?> >
                                <label for="course-<?= $key?>"><?= $value?></label>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="card-inside-title">Subject</h2>
                        <div class="demo-checkbox">
                            <?php foreach ($subjects as $key => $value): ?>

                                <input type="checkbox" name="subject[]" id="subject-<?= $key?>" value="<?= $key?>"
                                    <?= in_array($key, $assigments['subjects']) ? 'checked' : '' ?> >
                                <label for="subject-<?= $key?>"><?= $value?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h2>Login Information</h2>
                </div>
                <div class="body">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="username" name = "username" placeholder="UserName" value="<?= $user->username?>"  readonly>
                    </div>

                    <?php if($this->request->session()->read('Auth.User.id') == $user->id){ ?>

                        <p class="help-block">Leave blank if no password changes</p>

                        <div class="form-group">
                            <input type="password" class="form-control" id="old_password" name = "old_password" placeholder=" Old Password">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" id="new_password" name = "new_password" placeholder=" New Password">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" id="confirm_password" name = "confirm_password" placeholder=" Confirm Password">
                        </div>


                    <?php } else { ?>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name = "password" placeholder="Password">
                        </div>
                    <?php } ?>

                    <p class="help-block">User Informations</p>

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="first_name" name = "first_name" placeholder="First Name" value="<?= $user->first_name?>">
                    </div>

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="last_name" name = "last_name" placeholder="Last Name"  value="<?= $user->last_name?>">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" id="email" name = "email" placeholder="Email" value="<?= $user->email?>">
                    </div>

                    <?php if($this->request->session()->read('Auth.User.role') == 1){ ?>
                        <div class="form-group">
                            <select class="form-control show-tick" id='role' name='role' onChange="changeCountry(this);" value="1">
                                <?php foreach($arrRoles as $key => $value) { ?>

                                    <option value="<?= $key ?>" <?= ($key == $user->role) ? 'selected' : '' ?>><?=$value?></option>

                                <?php } ?>
                            </select>
                        </div>

                    <?php } else if($this->request->session()->read('Auth.User.role') == 3){ ?>

                        <!-- <div class="form-group">
                            <label>Role</label>
                            <select class="form-control show-tick" id='role' name='role' onChange="changeCountry(this);" value="2">
                                <?php foreach($arrRoles as $key => $value) { ?>
                                    <?php if ($key >= 2) {?>
                                        <option value="<?= $key ?>" <?= ($key == $user->role) ? 'selected' : '' ?>><?=$value?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div> -->
                    <?php } ?>


                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>

                </div>
            </div>
        </div>


        <?= $this->Form->end() ?>

    </div>
</section>