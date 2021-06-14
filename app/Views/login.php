<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/build/css/login.css">
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="<?php echo base_url(); ?>/assets/production/images/imigrasi.png" alt="logo">
					</div>
					<div class="row justify-content-md-center">
						<h4 class="card-title">Kantor Imigrasi</h4>
						<h4 class="card-title">Kelas I Khusus TPI Ngurah Rai</h4>
					</div>
					<div class="card fat">
						<div class="card-body">
							<!-- <h4 class="card-title">Login</h4> -->
							<div class="row justify-content-md-center h-100">
								<img src="<?php echo base_url(); ?>/assets/production/images/resize2.png" alt="logo">
							</div>
							<form method="POST" id="login" class="my-login-validation">
								<div class="form-group">

									<input id="email" type="text" class="form-control" name="username" value="" placeholder="Masukan Username" onChange="removeError('username')" autofocus >
									<div class="invalid-feedback">

									</div>
								</div>

								<div class="form-group">
									<input id="password" type="password" class="form-control" name="password" placeholder="Masukan password" onChange="removeError('password')">
									<div class="invalid-feedback">

									</div>
								</div>
								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="remember" id="remember" class="custom-control-input">
										<label for="remember" class="custom-control-label">Remember Me</label>
									</div>
								</div>
								</form>
								<div class="form-group m-0">
									<button type="submit" id="validate" class="btn btn-primary btn-block">
										Login
									</button>
								</div>
							
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2017 &mdash; Your Company
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>/assets/vendors/jquery/dist/jquery.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="<?php echo base_url(); ?>/assets/build/js/login.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
	<script>
		$(function() {
			$("#validate").click(function(e) {
				$(".error").empty();
				Nloading();
				submit();
				e.preventDefault();
			});
		});

		function submit() {
			$("#validate").addClass('disabled');
			$("#validate").addClass('disabled');
			$.ajax({
				context: this,
				url: "/login/process",
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				},
				type: "POST",
				data: $('#login').serialize(),
				dataType: "JSON",
				success: function(data) {
					if (data.status) {
						Nberhasil('Diarahkan Ke SIAP Imigrasi');
						location.href = "home";
					} else {
						$.each(data.ket, function(key, value) {
							$('#login input[name="' + key + '"]').addClass('is-invalid');
							$('#login input[name="' + key + '"]').siblings(":last").text(value);
						});
						Nwarning('Login gagal');
						$("#validate").removeClass('disabled');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					Nerror(errorThrown)
					$("#validate").removeClass('disabled');

				}
			});
		}

		function Nberhasil(text) {
			Swal.fire({
				icon: 'success',
				title: text,
				showConfirmButton: false,
				timer: 1500
			})
		}

		function Nloading() {
			Swal.fire({
				title: "Loading...",
				text: "",
				imageUrl: "<?php echo base_url(); ?>/assets/production/images/loading.gif",
				showConfirmButton: false,
				allowOutsideClick: false
			});
		}

		function Nwarning(text) {
			Swal.fire({
				icon: 'warning',
				title: 'Oops...',
				text: text
			})
		}

		function Nerror(text) {
			Swal.fire({
				icon: 'error',
				title: 'Error !!!',
				text: text
			})
		}
		function removeError(param) {
      $('input[name="' + param + '"]').removeClass('is-invalid')
    }
	</script>
</body>

</html>