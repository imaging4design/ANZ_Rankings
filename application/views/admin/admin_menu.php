<div class="colFull"><!--START COLLEFT-->
  
  <h3>Administration Menu</h3><br />
  
  <div class="d960 drow">
  
    <p class="strong">Add Results:</p>
    <?php
      echo anchor('admin/results_con/add_results', 'Individual Events', array('class' => 'button'));
      echo anchor('admin/multis_con/add_multis', 'Multi Events', array('class' => 'button'));
      echo anchor('admin/relays_con/add_relays', 'Relays', array('class' => 'button'));
    ?>
    <p>&nbsp;</p>
    
    <p class="strong">Add Records:</p>
    <?php
      echo anchor('admin/records_con/add_records', 'Add Records', array('class' => 'button'));
    ?>
    <p>&nbsp;</p>
    
    <p class="strong">Add Athletes:</p>
    <?php
      echo anchor('admin/athlete_con', 'New Athlete', array('class' => 'button'));
    ?>
    <p>&nbsp;</p>
    
    <p class="strong">Add News Article:</p>
    <?php
      echo anchor('admin/news_con', 'Add News/Info', array('class' => 'button'));
    ?>
  
  </div>
  

</div>