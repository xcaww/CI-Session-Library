		<div id="sessions_container">
		
			<h1>Sessions</h1>
			
			<?php $this->load->view('pagebits/page_buttons'); ?>

			<div id="sessions_content">
		
				<h2>User</h2>
				<div id="top_buttons"><?php echo anchor('sessions/edit/user/' . $user['sessions'][0]['user_id'], 'edit user'); ?> - <?php echo anchor('sessions', 'overview'); ?></div>

				<?php
				
					$this->object =& get_instance();
					
					$tmpl = array (
                    'table_open'          => '<table class="user">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr class="user_data">',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr class="user_data">',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
					);

					$this->object->load->library('table');
					$this->object->table->set_template($tmpl);
					$this->object->table->add_row(array('<b>ID</b>', $user['sessions'][0]['user_id']));					
					$this->object->table->add_row(array('<b>Username</b>', $user['username']));
					$this->object->table->add_row(array('<b>Email</b>', $user['email']));
					$this->object->table->add_row(array('<b>IP Address</b>', $user['sessions'][0]['ip_address']));
					$this->object->table->add_row(array('<b>Session ID</b>', $user['sessions'][0]['session_id']));
					echo $this->object->table->generate();
	
					//<HR> spacer to seperate the data from options
					?><p><hr/></p><?php
					
					$tmpl = array (
                    'table_open'          => '<table class="overview">',

                    'heading_row_start'   => '<tr class="titles">',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th align="left">',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr class="overview_data">',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr class="overview_data">',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
					);

					$this->object->load->library('table');
					$this->object->table->set_template($tmpl);
					$this->object->table->set_heading(array('Time Created', 'Last Activity', 'Session ID', 'IP Address', 'User Agent'));
					
					foreach($user['sessions'] as $session_row){
					
						$this->object->table->add_row(array(
							date( 'h:ia d/m/y', $session_row['time_created']),
							date( 'h:ia d/m/y', $session_row['last_activity']),
							$session_row['session_id'],
							$session_row['ip_address'],
							$session_row['user_agent']
						));
						
					}
					
					echo $this->object->table->generate();					
				
				?>
			
			</div>
			
		</div>