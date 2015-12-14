<script>
	$(document).ready(function() {
		$(function() {
			$("#login_menu").dialog({
				autoOpen: false
			});
			$("#login_menu").css("display", "show");
			
			$("#register_menu").dialog({
				autoOpen: false
			});
			$("#register_menu").css("display", "show");
			
			$("#register_close").dialog({
				autoOpen: false
			});
			$("#register_close").css("display", "show");
			
			$("#cover").hide();
			
			$("#login").on("click", function() {
				$("#register_menu").dialog('close');
				$("#login_menu").dialog({
					autoOpen: true,
					resizable: false,
					draggable: false,
					width: 350,
					height: 300,
					dialogClass: 'no-close register_menu-dialog'
				});
				
				$("#cover").show();
				$("#error_username_log").hide();
				$("#error_password_log").hide();
			});
			$("#register").on("click", function() {
				$("#login_menu").dialog('close');
				$("#register_menu").dialog({
					autoOpen: true,
					resizable: false,
					draggable: false,
					width: 350,
					height: 450,
					dialogClass: 'no-close register_menu-dialog'
				});
				$("#login_menu").dialog({
					autoOpen: false
				});
				$("#cover").fadeIn();
				$("#error_fname").hide();
				$("#error_lname").hide();
				$("#error_username").hide();
				$("#error_password").hide();
				$("#error_email").hide();
			});
		});
	
		$("#close").click(function(e) {
			$('#register_close').dialog('close');
			$('#register_menu').dialog('close');
			location.reload();
		});
	});
	
	$(document).on('click','.ui-dialog-titlebar-close',function(){
		$("#cover").hide();
	});
</script>

<div class="container-fluid">
	<div class="main">
		<div id="login_menu" title="Login">
				<form>
					<br />
					<br />
					<p><input id="username_log" name="username" type="text" placeholder="Username"></p>
					<p><input id="password_log" name="password" type="password" placeholder="Password"></p>
					<p id="error_log" style="font-size:0.75em; font-weight:bold; color:#EB3B3B"></p>
					<p><button id="login_val" type="button" onclick="login_user(document.getElementById('username_log').value,document.getElementById('password_log').value)">Login</button></p>
				</form>
		</div>
		<div id="register_menu" title="Register">
			<form>
				<br />
				<label style="font-size:0.75em; color:#EB3B3B;">*All fields required*</label>
				<br />
				<p><input id="fname" name="fname" type="text" placeholder="First Name"></p>
				<p id="error_fname" style="font-size:0.75em; font-weight:bold; color:#EB3B3B">Must contain only letters</p>
				<p><input id="lname" name="lname" type="text" placeholder="Last Name"></p>
				<p id="error_lname" style="font-size:0.75em; font-weight:bold; color:#EB3B3B">Must contain only letters</p>
				<p><input id="username" name="username" type="text" placeholder="Username"></p>
				<p id="error_username" style="font-size:0.75em; font-weight:bold; color:#EB3B3B">Username must be 5 or more characters</p>
				<p><input id="password" name="password" type="password" placeholder="Password"></p>
				<p id="error_password" style="font-size:0.75em; font-weight:bold; color:#EB3B3B">Password must be 5 or more characters and alphanumeric</p>
				<p><input id="email" name="email" type="text" placeholder="Email"></p>
				<p id="error_email" style="font-size:0.75em; font-weight:bold; color:#EB3B3B">Email must be in a valid format (xxx@xxx.xxx)</p>
				<p><button id="reg_val" type="button" onclick="register_user(document.getElementById('fname').value,document.getElementById('lname').value,document.getElementById('username').value,document.getElementById('password').value,document.getElementById('email').value)">Register</button></p>
			</form>
		</div>
		<div id="register_close" title="Register">
			<form>
				<p><label style="font-size:1.25em; color:#000000;">Account created!</label></p>
				<button id="close" type="button">Close</button>
			</form>
		</div>
	</div>
</div>