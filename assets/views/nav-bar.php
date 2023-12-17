<nav class="nav-bar-wrapper">
    <div class="nav-bar">
        <ul>
            <h2 class="logo"><a href="index.php">Musical bot</a></h2>
            <!-- <li class="log-reg-panel"><a href="#">Ienākt</a></li> -->
            <li class="log-reg-panel">
					<?php
						if (isset($_SESSION['user'])) {
							echo '<a href="register.php">' . $_SESSION['user']['username'] . '</a>';
						} else{ 
							echo '<a href="register.php">Reģistrēties</a>';
						}
					?>
				</a>
			</li>
        </ul>
    </div>
</nav>
<?php
//Include required PHPMailer files
	require 'vendor/PHPMailer/PHPMailer.php';
	require 'vendor/PHPMailer/SMTP.php';
	require 'vendor/PHPMailer/Exception.php';
//Define name spaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	if (array_key_exists('email', $_POST)) {
		
		$email = "";
		$message = "";
		// $my_email = "emilsstrelis360@gmail.com";
		$my_email = "ilarimsa937@gmail.com";
		
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "tls";
		$mail->Port = "587";
		
		//Set gmail username
		// $mail->Username = "emilsstrelis360@gmail.com";
		$mail->Username = "ilarimsa937@gmail.com";
		
		//Set gmail password
		// $mail->Password = "cofxornytlvsojmk";
		$mail->Password = "rxexlgukwdrzgmkt";
		
		//Email message
		if(isset($_POST['message'])) {
			$message = htmlspecialchars($_POST['message']);
		}
		
		//Email subject
		$mail->Subject = "New message from Re-Books";
		
		//Visitor email
		if(isset($_POST['email'])) {
			$email = $_POST['email'];
		}
		
		//Set sender email
		$mail->setFrom($email);
		
		//Enable HTML
		$mail->isHTML(true);
		
		//Email body
		$mail->Body = 
		"
		<!DOCTYPE html>
		<html lang='en'>
		<head>
			<meta charset='UTF-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		
			<title>Document</title>
			<style>
				* {
					font-family: Roboto;
				}
				.wrapper {
					display: flex;
					flex-direction: column;
					text-align: center;
					background-color: #33383b;
					color: white;
					min-height: 300px;
					width: 600px;
					margin-right: auto;
					margin-left: auto;
					font-size: 20px;
				}
			
				.main {
					/* justify-content: center; */
					margin-right: auto;
					margin-left: auto;
					width: 600px;
					
				}
			
				label {
					color: #8f9296;
				}
			
				.name {
					height: 200px;
					font-size: 48px;
					margin-bottom: 20%;
				}
			
				.name span{
					color:  #5383d3;
					width: 600px;
			
				}
			
				.e-mail {
					display: flex;
					margin-left: 20px;
				}
			
				.message label{
					display: flex;
					margin-left: 20px;
					margin-right: 76.2%;
				}
			
				.message-text {
					display: flex;
					margin-left: 20px;
				}
				
				.footer {
					color: #8f9296;
					margin-right: auto;
					margin-left: auto;
					margin-top: 20%;
                    margin-bottom: 40px;
					font-size: 14px;
					width: 300px;
				}
			</style>
		</head>
		<body>
			<div class='wrapper'>
				<div class='main'>
					<div class='name'>
						<h1><span>Re</span>-Books</h1>
					</div>
					<div class='e-mail'>
						<label><b>E-mail:</b></label>&nbsp;<span>".$email."</span>
					</div>
					<div class='message'>
						<label><b>Message:</b></label>
						<div class='message-text'>".$message."</div>
					</div>
					<div class='footer'>
						<div>Jūs saņēmāt šo e-pasta ziņojumu, kas nosūtīta uz adresi ".$email.", jo esat reģistrējies (-usies) mūsu Re-Books lietotnē.</div>
						<div>@Re-Books Visas tiesības aizsargātas</div>
					</div>
				</div>
			</div>
		</body>
		</html>
		";
		
		//Add recipient
		// $mail->addAddress('emilsstrelis360@gmail.com');
		$mail->addAddress('ilarimsa937@gmail.com');
		
		//Finally send email
		if ( $mail->send() ) {
			echo "
			<style>
			.access-wrapper {
				position: sticky;
				z-index: 10;
				color: white;
				background-color: #04AA6D; 
				width: 100%; 
				height: 60px; 
				line-height: 60px;
			}
			
			.access-message {
				font-size: 20px;
				padding-top: auto;
				padding-bottom: auto;
				margin-left: 20px;
			}
			
			.close_button {
				font-size: 30px; 
				float: right;
				margin-right: 20px;
				background: none;
				border: none;
				color: white;
			}
			
			.close_button::selection {
				color: black;
			}

			</style>
			<div class ='access-wrapper' id='access-wrapper'>
				<div class='access-message'>
					Jūsu ziņojums tika veiksmīgi nosūtīts!
					<a class='close_button' onclick='hide()' id='close_button'>X</a>
				</div>
			</div>";
		}else{
			echo "
			<style>
			.access-wrapper {
				position: sticky;
				z-index: 10;
				color: white;
				background-color: #aa0404; 
				width: 100%; 
				height: 60px; 
				line-height: 60px;
			}
			
			.access-message {
				font-size: 20px;
				padding-top: auto;
				padding-bottom: auto;
				margin-left: 20px;
			}
			
			.close_button {
				font-size: 30px; 
				float: right;
				margin-right: 20px;
				background: none;
				border: none;
				color: white;
			}
			
			.close_button::selection {
				color: black;
			}

			</style>
			<div class ='access-wrapper' id='access-wrapper'>
				<div class='access-message'>
					Jūsu ziņojumu nevarēja nosūtīt.
					<a class='close_button' onclick='hide()' id='close_button'>X</a>
				</div>
			</div>";
		}
		
		//Closing smtp connection
		$mail->smtpClose();
		}
?>