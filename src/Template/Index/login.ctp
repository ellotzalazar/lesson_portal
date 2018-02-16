<?php $this->assign('title', 'home'); ?>
	<body class="login-page">
	    <div class="login-box">
	        <div class="logo">
	            <a href="javascript:void(0);"><?= SITE_NAME?></a>
	            <small><?= SITE_NAME_LONG?></small>
	        </div>
	        <div class="card">
	            <div class="body">
	                <form id="sign_in" method="POST">
	                    <div class="msg">Sign in to start your session</div>
	                    <div class="input-group">
	                        <span class="input-group-addon">
	                            <i class="material-icons">person</i>
	                        </span>
	                        <div class="form-line">
	                            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
	                        </div>
	                    </div>
	                    <div class="input-group">
	                        <span class="input-group-addon">
	                            <i class="material-icons">lock</i>
	                        </span>
	                        <div class="form-line">
	                            <input type="password" class="form-control" name="password" placeholder="Password" required>
	                        </div>
	                    </div>
	                    <div class="row">

	                        <div class="col-xs-4 pull-right">
	                            <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
	                        </div>
	                    </div>
	                    <div class="row m-t-15 m-b--20">
	                        <div class="col-xs-6">
	                            <a href="<?= SITE_URL ?>/register">Register Now!</a>
	                        </div>
	                        <div class="col-xs-6 align-right">
	                            <a href="forgot-password.html">Forgot Password?</a>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </div>

	</body>