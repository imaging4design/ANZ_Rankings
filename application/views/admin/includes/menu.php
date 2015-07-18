<!--START HORIZONTAL MENU-->

<div id="myslidemenu" class="jqueryslidemenu">

<ul>
  <li><?php echo anchor('admin/admin_con','Main Menu'); ?></li>
  <li><?php echo anchor('#','VIEW RANKINGS'); ?></li>
  <li>
		<?php
    //Show log out button only if a user is logged in
    if($this->session->userdata('is_logged_in'))
    {
      echo anchor('admin/login_con/logout','Log Out');
    }
    ?>
  </li>
  
</ul>

<br style="clear:both;" />

</div>

<!--END HORIZONTAL MENU-->