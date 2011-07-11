<script type="text/javascript" src="<?php echo base_url(); ?>js/login_form.js"></script>

<div id="login_container">

	<div id="login_form">
	
		<h1 style="display: block";>Sign In</h1>
		<?php
		echo form_open('login/authenticate');
		$username_input = array('name' => 'username', 'id' => 'username_field', 'value' => 'username', 'type' => 'text', 'onclick' => "removeText(this.id)");
		echo form_input($username_input);
		$password_input = array('name' => 'password', 'id' => 'password_field', 'value' => 'password', 'type' => 'password', 'onclick' => "removeText(this.id)");
		echo form_input($password_input);
		echo '<table>';
		echo '<tr>';
		echo '<td style="width: 100%;">' . anchor('a', 'register') . "</td>";
		echo '<td rowspan="2">' . form_submit('submit', 'Login') . '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>' . anchor('a', 'recover password') . '</td>';
		echo '</tr>';
		echo '</table>';
		?>
	
	</div>
	
</div>