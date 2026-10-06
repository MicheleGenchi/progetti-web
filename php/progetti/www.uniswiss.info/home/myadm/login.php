<?php
require("inc_config.php");
require("inc_header.php");
?>
</head>

<body class="login">
    
	<div class="wrapper wrapper-login">
         
            <div class="container container-login animated fadeIn" style="padding-top:20px;">
                    <center><img src="<?=BASE_URL;?>assets/img/logook.jpg" style="width:200px" /></center><br />
			<form id="loginForm" method="POST" action="javascript:void(null);">
				<input name="func" id="func" value="login" type="hidden" />
				<h3 class="text-center">Accedi all'area di amministrazione</h3>
				<div class="login-form">
					<div class="form-group form-floating-label">
						<input id="username" name="email" type="email" class="form-control input-border-bottom" required>
						<label for="email" class="placeholder">Email</label>
					</div>
					<div class="form-group form-floating-label">
						<input id="password" name="password" type="password" class="form-control input-border-bottom" required>
						<label for="password" class="placeholder">Password</label>
						<div class="show-password">
							<i class="icon-eye"></i>
						</div>
					</div>
					<div class="form-action mb-3">
						<button class="btn btn-primary btn-rounded btn-login" id="loginButton" name="loginButton">Accedi</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<script src="<?= BASE_URL; ?>assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="<?= BASE_URL; ?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="<?= BASE_URL; ?>assets/js/core/popper.min.js"></script>
	<script src="<?= BASE_URL; ?>assets/js/core/bootstrap.min.js"></script>
	<script src="<?= BASE_URL; ?>assets/js/atlantis.min.js"></script>
	<!-- Sweet Alert -->
	<script src="<?= BASE_URL; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- JQuery Validation -->
	<script src="<?= BASE_URL; ?>assets/js/plugin/jquery.validate/jquery.validate.min.js" type="text/javascript"></script>

	<script src="<?= BASE_URL; ?>funzionijs/login.js" type="text/javascript"></script>
         <?php if(isset($_POST['email']) AND isset($_POST['password'])){ ?>
        <script>
        $('#username').val('<?=$_POST['email'];?>');
        $('#password').val('<?=$_POST['password'];?>');
        setTimeout(function(){$('#loginButton').click();},400);
        
        </script>
        <?php  } ?>
</body>

</html>