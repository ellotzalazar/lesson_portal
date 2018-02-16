<?php $this->assign('title', 'home'); ?>
<body class="signup-page">
    <?= $this->Html->css(SITE_URL.'/css/password-strength.css', ['plugin' => true]); ?>
    <div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);"><?= SITE_NAME?></a>
            <small><?= SITE_NAME_LONG?></small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_up" method="POST">
                    <div class="msg">Register a new user</div>
                    <div class="col-xs-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">label</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control no_special" name="first_name" id="first_name" placeholder="First Name" required autofocus maxlength="50">
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">label_outline</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control no_special" name="middle_name" id="middle_name" placeholder="Middle Name" required autofocus maxlength="50">
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">label_outline</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control no_special" name="last_name" id="last_name" placeholder="Last Name" required autofocus maxlength="50">
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <div class="form-line">
                                <input type="email" class="form-control email_filter" name="email" id="email" placeholder="Email Address" required maxlength="50">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control user_name_filter" name="username" id="username" placeholder="Username" required autofocus maxlength="50">
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="password" minlength="6" placeholder="Password" required>
                                <div class="pwstrength_viewport_progress"></div>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="confirm" minlength="6" placeholder="Confirm Password" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" id='role' name='role' required data-live-search="true">

                                <?php foreach($arrRoles as $key => $value) { ?>
                                    <?php if ($key >= 2) {?>
                                        <option value="<?= $key ?>" <?= $key == 2 ? 'selected' : ''; ?> ><?=$value?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">label_outline</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control" name="number" id="number" placeholder="Employee Number" required autofocus maxlength="50">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">SIGN UP</button>

                    <div class="m-t-25 m-b--5 align-center">
                        <a href="<?= SITE_URL ?>">You already have a membership?</a>
                    </div>
                    <script src="<?=SITE_URL?>/bsb/plugins/jquery/jquery.min.js"></script>
                    <?= $this->Html->script(SITE_URL . '/js/password-strength.js', ['plugin' => true]); ?>
                    <script type="text/javascript">

                        $('.no_special').keypress(function(e){
                            var txt = String.fromCharCode(e.which);
                            console.log(txt + ' : ' + e.which);
                            if(!txt.match(/[A-Za-z ]/))
                            {
                                return false;
                            }
                        });

                        $('.user_name_filter').keypress(function(e){
                            var txt = String.fromCharCode(e.which);
                            console.log(txt + ' : ' + e.which);
                            if(!txt.match(/[A-Za-z0-9_]/))
                            {
                                return false;
                            }
                        });

                        $('.email_filter').keypress(function(e){
                            var txt = String.fromCharCode(e.which);
                            console.log(txt + ' : ' + e.which);
                            if(!txt.match(/[A-Za-z0-9_@.]/))
                            {
                                return false;
                            }
                        });

                        $('#role').change(function(e){
                            $id = $(this).val();
                            $('#number').attr('placeholder', ($id == 2 ? 'Employee' : 'Student') + ' Number');
                        })
                    </script>
                </form>
            </div>
        </div>
    </div>
</body>