		<div id="footer">
		
			<p style="text-align: right; margin-bottom: 15px;"><?php if($this->uri->segment(1) != 'login'){ echo anchor('login/quit', 'logout'); } ?></p>
			<p>xSession Library</p>
			<p>&copy; 2011 Blake J</p>
			<p class="powered_by">Powered by <a href="http://codeigniter.com/">CodeIgniter <img src="<?php echo base_url(); ?>images/ci.png" width="20" height="22" /></a></p>
			
		</div>
	
	</body>
	
</html>