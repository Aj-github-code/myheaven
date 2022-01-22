<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
	if(isset($modules))
	{
		foreach($modules as $index=>$value)
		{
			echo Modules::run($modules[$index]."/".$methods[$index]);
		}
	}
	else
	{
		echo $this->load->view($content);
	}

	if(isset($loggedin) && $loggedin == 'yes')
	{
		echo '</div></div></div>';
	}
?>