<div class="container container-class">
    <div class="row">
        <div class="col-sm-12">
            <?php



                /************************************************************************************************************************************************************/

                // DISPLAYS EACH ATHLETES 'NZ CHAMPIONSHIPS MEDAL PERFORMANCES'

                /************************************************************************************************************************************************************/

                // Get list of athlete 'NZ Medal Performances'
                $athleteID = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : substr($this->input->post('athleteID'), -6);

                $nzchamps = get_nzchamps($athleteID);

                if( isset( $nzchamps ) && ! $this->input->post('eventID') ) // Hide the honours list when looking at athletes individual events!
                {

                echo '<br>';
                echo '<h3 id="NZCM" class="h3-four">NZ Championships Medals <small>(from 2010)</small></h3>';

                echo '<table class="table table-striped" data-toggle-column="last">
                        <thead>
                            <tr>
                                <th data-type="html">Year</th>
                                <th>Event</th>
                                <th data-breakpoints="xs">Age Group</th>
                                <th data-breakpoints="xs">Performance</th>
                                <th data-breakpoints="xs" data-type="html" class="right">Position</th>
                            </tr>
                        </thead>
                    <tbody>';


                    // Loop through and display
                    foreach ($nzchamps as $row) {

                        // Correctly label Age Groups
                        $ageGroup = $row->ageGroup;

                        switch ($ageGroup)
                        {
                            case ($ageGroup == 'MS'): $row->ageGroup = 'Open Men'; break;
                            case ($ageGroup == 'M19'): $row->ageGroup = 'Junior Men'; break;
                            case ($ageGroup == 'M18'): $row->ageGroup = 'M19'; break;
                            case ($ageGroup == 'M17'): $row->ageGroup = 'Youth Men'; break;
                            case ($ageGroup == 'M16'): $row->ageGroup = 'M16'; break;
                            case ($ageGroup == 'WS'): $row->ageGroup = 'Open Women'; break;
                            case ($ageGroup == 'W19'): $row->ageGroup = 'Junior Women'; break;
                            case ($ageGroup == 'W18'): $row->ageGroup = 'W19'; break;
                            case ($ageGroup == 'W17'): $row->ageGroup = 'Youth Women'; break;
                            case ($ageGroup == 'W16'): $row->ageGroup = 'W16'; break;
                        }


                        // START - Show medal image icon if position 1,2 or 3
                        $medal_pos = $row->position;

                        switch ($medal_pos)
                        {
                            case ( $medal_pos == '1' ):
                                $medal = array(
                                    'src' => base_url() . 'img/icon_gold.png',
                                    'alt' => 'Medal Position',
                                    'width' => '20',
                                    'height' => '20'
                                );
                                $show_medal = img($medal);
                            break;
                            case ( $medal_pos == '2' ):
                                $medal = array(
                                    'src' => base_url() . 'img/icon_silver.png',
                                    'alt' => 'Medal Position',
                                    'width' => '20',
                                    'height' => '20'
                                );
                                $show_medal = img($medal);
                            break;
                            case ( $medal_pos == '3' ):
                                $medal = array(
                                    'src' => base_url() . 'img/icon_bronze.png',
                                    'alt' => 'Medal Position',
                                    'width' => '20',
                                    'height' => '20'
                                );
                                $show_medal = img($medal);
                            break;
                            default:
                                $show_medal = $row->position;
                        }
                        // END - Show medal image icon if position 1,2 or 3

                        $edit = NULL;

                        if($this->session->userdata('is_logged_in')) // Display Admin edit link
                        {
                            $edit = anchor('admin/nzchamps_con/populate_nzchamps/' . $row->id . '/' . $this->uri->segment(4) , ' - Edit');
                        }

                        
                        echo '<tr>
                                <td>' . $row->year . ' ' . $edit . '</td>
                                <td>' . $row->eventName . '</td>
                                <td>' . $row->ageGroup . '</td>
                                <td>' . $row->performance . '</td>
                                <td class="right">' . $show_medal . '</td>
                            </tr>';
                        
                    }
                }

                echo '</tbody>';
                echo '</table>';

			?>

        </div><!-- ENDS col -->



        <div class="col-sm-12">
            <?php

                /************************************************************************************************************************************************************/

                // DISPLAYS EACH ATHLETES 'HONOURS / NZ REPRESENTATIONS'

                /************************************************************************************************************************************************************/

                // Get list of athlete 'Honours' and 'Representation'
                $athleteID = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : substr($this->input->post('athleteID'), -6);

                $reps = get_representations($athleteID);

                if( isset( $reps ) && ! $this->input->post('eventID') ) // Hide the honours list when looking at athletes individual events!
                {

                echo '<br>';
                echo '<h3 id="NZR" class="h3-four">New Zealand Representation <small>(from 2002)</small></h3>';

                echo '<table class="table table-striped" data-toggle-column="last">
                        <thead>
                            <tr>
                                <th data-type="html">Year</th>
                                <th>Competition</th>
                                <th data-breakpoints="xs">Event</th>
                                <th data-breakpoints="xs">Performance</th>
                                <th data-breakpoints="xs" data-type="html" class="right">Position</th>
                            </tr>
                        </thead>
                    <tbody>';


                    // Loop through and display
                    foreach ($reps as $row) {


                        // START - Show medal image icon if position 1,2 or 3
                        $medal_pos = $row->position;

                        switch ($medal_pos)
                        {
                            case ( $medal_pos == '1' ):
                                $medal = array(
                                    'src' => base_url() . 'img/icon_gold.png',
                                    'alt' => 'Medal Position',
                                    'width' => '20',
                                    'height' => '20'
                                );
                                $show_medal = img($medal);
                            break;
                            case ( $medal_pos == '2' ):
                                $medal = array(
                                    'src' => base_url() . 'img/icon_silver.png',
                                    'alt' => 'Medal Position',
                                    'width' => '20',
                                    'height' => '20'
                                );
                                $show_medal = img($medal);
                            break;
                            case ( $medal_pos == '3' ):
                                $medal = array(
                                    'src' => base_url() . 'img/icon_bronze.png',
                                    'alt' => 'Medal Position',
                                    'width' => '20',
                                    'height' => '20'
                                );
                                $show_medal = img($medal);
                            break;
                            default:
                                $show_medal = $row->position;
                        }
                        // END - Show medal image icon if position 1,2 or 3

                        $edit = NULL;

                        if($this->session->userdata('is_logged_in')) // Display admin edit link
                        {
                            $edit = anchor('admin/representation_con/populate_representation/' . $row->id . '/' . $this->uri->segment(4), ' - Edit');
                        }

                        
                        echo '<tr>
                                <td>' . $row->year . ' ' . $edit . '</td>
                                <td>' . $row->competition . '</td>
                                <td>' . $row->eventName . '</td>
                                <td>' . $row->performance . '</td>
                                <td class="right">' . $show_medal . '</td>
                            </tr>';
                        
                    }
                }

                echo '</tbody>';
                echo '</table>';

                ?>
        
        </div><!-- ENDS col -->



        <div class="col-sm-12">


            <?php
            	/************************************************************************************************************************************************************/

            	// DISPLAYS EACH ATHLETES PERSONAL BEST PERFORMANCES (in each 'INDIVIDUAL' event)

            	/************************************************************************************************************************************************************/
	            if( isset( $personal_bests ) )
	            {
	                
	                echo '<br>';
	                echo '<h3 id="BP" class="h3-four">Best Performances <small>(from 2008)</small></h3>';

	                echo '<table class="table table-striped" data-toggle-column="last">
	                        <thead>
	                            <tr>
	                                <th>Event</th>
	                                <th data-breakpoints="xs" muted">Implement</th>
	                                <th>Perf</th>
	                                <th data-breakpoints="sm xs">Wind</th>
	                                <th data-breakpoints="sm xs">Place</th>
	                                <th data-breakpoints="sm xs">Competition</th>
	                                <th data-breakpoints="xs">Venue</th>
	                                <th class="right">Date</th>
	                            </tr>
	                        </thead>
	                    <tbody>';
	                


	                foreach($personal_bests as $row)
	                {   
	                    // TIME/DISTHEIGHT - Is performance a time or distance/height?
	                    $performance = ( $row->time ) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);

	                    // This adds a highlight class to those rankings less than a week old!
	                    $dateClass = fresh_results($row->date); // from global_helper.php

	                    echo '<tr>
	                            <td>' . $row->eventName . '</td>
	                            <td><span class="text-muted">' . ltrim($row->implement,0) . '</span></td>
	                            <td><span class="'.$dateClass.'">' . $performance . '</span></td>
	                            <td>' . $row->wind . '</td>
	                            <td>' . $row->placing . '</td>
	                            <td>' . $row->competition . '</td>
	                            <td>' . $row->venue . '</td>
	                            <td class="right">' . $row->date . '</td>
	                        </tr>';
	                
	                }

	                echo '</tbody>';
	                echo '</table>';
	                
	            }
            
            ?>



            <?php
                /************************************************************************************************************************************************************/

                // DISPLAYS EACH ATHLETES PERSONAL BEST PERFORMANCES (in each 'MULTI' event)

                /************************************************************************************************************************************************************/
                if( isset( $personal_bests_multis ) )
                {

                    echo '<table class="table table-striped" data-toggle-column="last">
                            <thead class="hidden">
                                <tr>
                                    <td>Event</td>
                                    <td data-breakpoints="xs" muted">Implement</td>
                                    <td>Perf</td>
                                    <td data-breakpoints="sm xs">Wind</td>
                                    <td data-breakpoints="sm xs">Place</td>
                                    <td data-breakpoints="sm xs">Competition</td>
                                    <td data-breakpoints="xs">Venue</td>
                                    <th class="right">Date</th>
                                    <th data-breakpoints="lg md sm xs">Marks</th>
                                </tr>
                            </thead>
                        <tbody>';



                    foreach($personal_bests_multis as $row)
                    {

                        $performance = '<span class="strong">' . ltrim($row->MAX_points, 0) . '</span>';

                        $data='';

                        // Create an array of each 'discipline' result within the Decathlon / Heptathlon
                        $discipline = array($row->e01, $row->e02, $row->e03, $row->e04, $row->e05, $row->e06, $row->e07, $row->e08, $row->e09, $row->e10);

                        // Loop through each 'discipline' result
                        // Assign it to $mark
                        // Display it as reduce_multiples($data)
                        foreach($discipline as $mark)
                        { 
                            $data .= $mark . '&nbsp; <span class="textRed">|</span> &nbsp;'; 
                        }

                        // This adds a highlight class to those rankings less than a week old!
                        $dateClass = fresh_results($row->date); // from global_helper.php

                        echo '<tr>
                                <td>' . $row->eventName . '</td>
                                <td>&nbsp;</td>
                                <td><span class="'.$dateClass.'">' . $performance . '</span></td>
                                <td>&nbsp;</td>
                                <td>' . $row->placing . '</td>
                                <td>' . $row->competition . '</td>
                                <td>' . $row->venue . '</td>
                                <td class="right">' . $row->date . '</td>
                                <td>' . reduce_multiples($data, '&nbsp; - &nbsp;', TRUE) . '</td>
                            </tr>';

                    }

                    echo '</tbody>';
                    echo '</table>';
                }
                
           
            ?>



           	<?php
                /*
                |----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                |----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                |----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                |
                |  START 'Year by Year' PROGESSIONS HERE
                |
                |----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                |----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                |----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                */

                /************************************************************************************************************************************************************/
                // INDIVIDULAL EVENTS - DISPLAYS ATHLETES PERSONAL YEARLY PROGRESSION
                /************************************************************************************************************************************************************/

                $event = get_athlete_events(); // from profile_helper.php

                // DON'T SHOW THIS DATA IF USER HAS SELECTED 
                // TO SEE A SPECIFIC EVENT FROM THE DROP DOWNS 
                // (this would post 'token')
                if( ! $this->input->post('token') )
                {
                    
                    echo '<br>';
                    echo '<h2 id="AP"><strong>Annual</strong> Progressions</h2>';

                    foreach($event as $row)
                    {
                        
                        $progessions = progessions( $row->eventID ); // From profile_helper.php

                        // Display the Event Title heading
                        echo '<h3 class="h3-four">'. $row->eventName .'</h3>';

                        if( isset( $progessions ) )
                        {
                            
                            echo '<table class="table table-striped" style="margin-bottom:20px;" data-toggle-column="last">
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th data-breakpoints="xs" class="muted">Implement</th>
                                        <th data-type="html">Perf</th>
                                        <th data-breakpoints="sm xs">Wind</th>
                                        <th data-breakpoints="sm xs">Place</th>
                                        <th data-breakpoints="sm xs">Competition</th>
                                        <th data-breakpoints="xs">Venue</th>
                                        <th class="right">Date</th>
                                    </tr>

                                </thead>

                            <tbody>';



                                foreach($progessions as $row)
                                {
                                
                                    // TIME/DISTHEIGHT - Is performance a time or distance/height?
                                    $performance = ( $row->time ) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);


                                    // WIND - Is this is a windy performance? If so, show (w) symbol
                                    $wind = ( $row->wind > 2.0 or $row->wind == 'nwr' ) ? '(w)' : '';
                                    $hand_timed = ( $row->record == 'ht' ) ? '(ht)' : '';


                                    // IMPORTANT! - initiate this var
                                    $best_legal = FALSE;


                                    // SHOWS BEST LEGAL MARK (only if athlete best mark is wind-aided)
                                    if( in_array($row->eventID, $this->config->item('track_events_wind')) or in_array($row->eventID, $this->config->item('field_events_wind')) )
                                    {
                                        $best_legal = legal_vs_windy_profile($row->athleteID, $row->eventID, $row->year);

                                        // This adds a highlight class to those rankings less than a week old!
                                        if( $best_legal )
                                        {
                                            $dateClass = fresh_results($best_legal->date); // from global_helper.php
                                        }
                                        
                                    }

                                    
                                        /********************************************************************************************************/
                                        // Display athlete best LEGAL performance ONLY!

                                        if( $best_legal && ($row->wind > 2.0 || $row->wind === 'nwr' || $row->record === 'ht') )
                                        {
                                            $extra_row = '<tr>
                                                            <td>&nbsp;</td>
                                                            <td><span class="muted">' . ltrim($row->implement,0) . '</span></td>
                                                            <td><span class="'.$dateClass.'">' . ltrim($best_legal->legal_time, 0) . ' ' . ltrim($best_legal->legal_distHeight, 0) . '</span></td>
                                                            <td>&nbsp;</td>
                                                            <td>' . $best_legal->placing . '</td>
                                                            <td>' . $best_legal->competition . '</td>
                                                            <td>' . $best_legal->venue . '</td>
                                                            <td class="right">' . $best_legal->date . '</td>
                                                        </tr>';
                                        }
                                        else
                                        {
                                            $extra_row = '';
                                        }

                                    // Display athlete best LEGAL performance ONLY!
                                    /********************************************************************************************************/

                                    $dateClass = fresh_results($row->date); // from global_helper.php


                                    // Display athlete best performance regardless of wind reading
                                    echo    '<tr>
                                                <td>' . $row->year . '</td>
                                                <td><span class="muted">' . ltrim($row->implement,0) . '</span></td>
                                                <td><span class="'.$dateClass.'">' . $performance . '</span></td>
                                                <td>' . $wind . ' ' . $hand_timed . ' </td>
                                                <td>' . $row->placing . '</td>
                                                <td>' . $row->competition . '</td>
                                                <td>' . $row->venue . '</td>
                                                <td class="right">' . $row->date . '</td>
                                            </tr>
                                            ' . $extra_row . ' ';

                                }

                            echo '</tbody>';
                            echo '</table>';

                        }

                    }



                    /************************************************************************************************************************************************************/
                    // INDIVIDULAL EVENTS - DISPLAYS ATHLETES PERSONAL ANNUAL PROGRESSIONS
                    /************************************************************************************************************************************************************/
                    $progessions_multis = progessions_multis( $row->eventID ); // From profile_helper.php

                    if( isset( $progessions_multis ) )
                    {
                            
                            echo '<table class="table table-striped" style="margin-bottom:20px;" data-toggle-column="last">
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th data-type="html">Perf</th>
                                        <th data-breakpoints="sm xs">Place</th>
                                        <th data-breakpoints="sm xs">Competition</th>
                                        <th data-breakpoints="xs">Venue</th>
                                        <th class="right">Date</th>
                                    </tr>
                                </thead>
                            <tbody>';

                            foreach($progessions_multis as $row)
                            {
                                // This adds a highlight class to those rankings less than a week old!
                                $dateClass = fresh_results($row->date); // from global_helper.php

                                echo    '<tr>
                                            <td>' . $row->year . '</td>
                                            <td><span class="'.$dateClass.'">' . $row->points . '</span></td>
                                            <td>' . $row->placing . '</td>
                                            <td>' . $row->competition . '</td>
                                            <td>' . $row->venue . '</td>
                                            <td class="right">' . $row->date . '</td>
                                        </tr>';

                            }

                            echo '</tbody>';
                            echo '</table>';

                    }



                } // ENDS if( ! $this->input->post('token') )
           	
           	?>




















			<?php

                /************************************************************************************************************************************************************/
                
                // INDIVIDUAL EVENT LISTS - (As selected from event search box) 

                // CONFIGURE THE EVENT TITLE AND YEAR above the results (i.e., 100m / Javelin Throw)
                /************************************************************************************************************************************************************/
                $event_name = '';
                $year = '';

                if(isset($event_info))
                {

                foreach($event_info as $event):

                    if($event->eventID == $this->input->post('eventID'))
                    {
                        // Get event label
                        $event_name = $event->eventName;

                        // Get year label
                        $year = ($this->input->post('year') == 0) ? ' - All Years' : ' - ' . $this->input->post('year');
                    }

                endforeach;

                }

            ?>



            <?php
                /**************************************************************************************************/
                // PROFILE RESULTS FOR (INDIVIDUAL) EVENTS
                /**************************************************************************************************/
                if(isset($athlete_data))
                {
                    
                    // Display the Event Title heading
                    echo '<br>';
                    echo '<h2 class="h2-four"><strong>' . $event_name . '</strong> '. $year .'</h2>';

                    echo '<table class="table table-striped" style="margin-bottom:20px;" data-toggle-column="last">
                            <thead>

                                <tr>
                                    <th>Rank</th>
                                    <th data-type="html">Perf</th>
                                    <th data-breakpoints="sm xs">Wind</th>
                                    <th data-breakpoints="sm xs">Note</th>
                                    <th data-breakpoints="sm xs">Place</th>
                                    <th data-breakpoints="xs">Competition</th>
                                    <th data-breakpoints="xs">Venue</th>
                                    <th class="right">Date</th>
                                </tr>

                            </thead>
                        <tbody>';


                                
                    
                    // Initiate some label vars
                    $eventID = $this->input->post('eventID');
                    $label = FALSE;
                    $label_looped = FALSE;
                    $rank = 1;
                    $cur_performance = NULL;
                    
                    
                    /**************************************************************************************************/
                    // DISPLAY EVENTS THAT NEED TO BE SEPARATED BY IMPLEMENT WEIGHT / HURDLE HEIGHTS
                    /**************************************************************************************************/
                    // Is the selected event in the $this->config->item('seperate_performances')?
                    // If so, loop through results - separating them into implement weight or hurdle height clusters
                    
                    if(in_array($eventID, $this->config->item('seperate_performances')))
                    {
                        
                        foreach($athlete_data as $row):

                            //Indoor / outdoor performance
                            $in_out = ( $row->in_out == 'in' ) ? '<span class="strong">i</span>' : '';
                        
                            // Create implement weight / hurdle height labels to define each cluster section
                            $label = ltrim($row->implement, 0);


                            if($label_looped != $label)
                            {
                                echo '<tr><td style="font-weight:900;"><h4>' . $label . '</h4></td></tr>';
                            }

                            if($label_looped != $label)
                            {
                                $rank = 1;
                            }
                                
                                $performance = ($row->time) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);
                                
                                if($this->session->userdata('is_logged_in')) // Display editable link (on performance column)
                                {
                                    $performance = anchor('admin/results_con/populate_results/' . $row->resultID, $performance);
                                }

                                // This adds a highlight class to those rankings less than a week old!
                                $dateClass = fresh_results($row->date); // from global_helper.php

                                // When displaying 'Rank' number - show = sign if performances are the same!
                                $rank_style = ( $cur_performance === $performance ) ? '' : $rank;

                                echo '<tr>
                                            <td>' . $rank_style . '</td>
                                            <td><span class="'.$dateClass.'">' . $performance . ' ' . $in_out . '</span></td>
                                            <td>' . $row->wind . '</td>
                                            <td>' . $row->record . '</td>
                                            <td>' . $row->placing . '</td>
                                            <td>' . $row->competition . '</td>
                                            <td>' . $row->venue . '</td>
                                            <td class="right">' . $row->date . '</td>
                                        </tr>';
                                            
                                $rank++;
                                $label_looped = $label; // Monitor this value

                                // Remove 'Tied' ranked function if 'Order By Date'
                                if( $this->input->post('order_by') !=1)
                                {
                                    $cur_performance = $performance; // Monitor this value
                                }
                                                    
                                
                        endforeach;

                        //if( $this->input->post('order_by')) { echo 'by date'; }
                        
                        
                    } // ENDS if(in_array($eventID, $this->config->item('seperate_performances')))


                    
                    
                    /**************************************************************************************************/
                    // DISPLAY EVENTS THAT DON'T NEED TO BE SEPARATED BY IMPLEMENT WEIGHT / HURDLE HEIGHTS
                    /**************************************************************************************************/
                    else
                    {
                        foreach($athlete_data as $row):
                        
                            //Indoor / outdoor performance
                            if($row->in_out == 'in')
                            {
                                $in_out = '<span class="strong">i</span>';
                            }
                            else
                            {
                                $in_out = '';
                            }
                            
                        
                            $performance = ($row->time) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0);
                            
                            // Display editable link (on performance column)
                            if($this->session->userdata('is_logged_in'))
                            {
                                $performance = anchor('admin/results_con/populate_results/' . $row->resultID, $performance);
                            }


                            // This adds a highlight class to those rankings less than a week old!
                            $dateClass = fresh_results($row->date); // from global_helper.php

                            // When displaying 'Rank' number - show = sign if performances are the same!
                            $rank_style = ( $cur_performance === $performance ) ? '' : $rank;
                            
                            echo '<tr>
                                    <td>' . $rank_style . '</td>
                                    <td><span class="'.$dateClass.'">' . $performance . ' ' . $in_out . '</span></td>
                                    <td>' . $row->wind . ' </td>
                                    <td>' . $row->record . '</td>
                                    <td>' . $row->placing . '</td>
                                    <td>' . $row->competition . '</td>
                                    <td>' . $row->venue . '</td>
                                    <td class="right">' . $row->date . '</td>
                                </tr>';
                                        
                            $rank++;

                            // Remove 'Tied' ranked function if 'Order By Date'
                            if( $this->input->post('order_by') !=1)
                            {
                                $cur_performance = $performance; // Monitor this value
                            }
                        
                            
                        endforeach;
                    }

                    echo '</tbody>';
                    echo '</table>';
                    
                    
                } // ENDS if(isset($athlete_data))
                
			?>



			<?php
                /************************************************************************************/
                // PROFILE RESULTS FOR (MULTI) EVENTS
                /************************************************************************************/
                if(isset($athlete_multi_data))
                {
                    
                    echo '<br>';
                    echo '<h2 class="h2-four"><strong>' . $event_name . '</strong> '. $year .'</h2>';

                    echo '<table class="table table-striped" style="margin-bottom:20px;" data-toggle-column="last">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th data-type="html">Perf</th>
                                    <th data-breakpoints="sm xs">Wind</th>
                                    <th data-breakpoints="sm xs">Note</th>
                                    <th data-breakpoints="sm xs">Place</th>
                                    <th data-breakpoints="xs">Competition</th>
                                    <th data-breakpoints="xs">Venue</th>
                                    <th class="right">Date</th>
                                    <th data-breakpoints="lg md sm xs">Marks</th>
                                </tr>

                            </thead>
                        <tbody>';
                                
                    
                    $rank = 1;
                    $data='';
                    $cur_performance = NULL;
                    
                    foreach($athlete_multi_data as $row):

                        // Create implement weight / hurdle height labels to define each cluster section
                        $label = $row->ageGroup;

                        switch ($label) {
                            case 'MS':
                                $multi_label = 'Senior';
                            break;
                            case 'M19':
                                $multi_label = 'Junior';
                            break;
                            case 'M17':
                                $multi_label = 'Youth';
                            break;
                            case 'WS':
                                $multi_label = 'Senior';
                            break;
                            case 'W19':
                                $multi_label = 'Junior';
                            break;
                            case 'W16':
                                $multi_label = 'Youth';
                            break;
                            
                            default:
                                $multi_label = 'n/a';
                            break;
                        }

                        if($label_looped != $label)
                        {
                            echo '<tr><td style="font-weight:900;"><h4>' . $multi_label . '</h4></td></tr>';
                        }

                        if($label_looped != $label)
                        {
                            $rank = 1;
                        }


                    
                            // Create an array of each 'discipline' result within the Decathlon / Heptathlon
                            $discipline = array($row->e01, $row->e02, $row->e03, $row->e04, $row->e05, $row->e06, $row->e07, $row->e08, $row->e09, $row->e10);
                            
                            // Loop through each 'discipline' result
                            // Assign it to $mark
                            // Display it as reduce_multiples($data)
                            foreach($discipline as $mark)
                            { 
                                $data .= $mark . '&nbsp; <span class="textRed">|</span> &nbsp;'; 
                            }

                                // This adds a highlight class to those rankings less than a week old!
                                $dateClass = fresh_results($row->date); // from global_helper.php

                                // When displaying 'Rank' number - show = sign if performances are the same!
                                $rank_style = ( $cur_performance === $row->points ) ? '' : $rank;


                                $performance = $row->points;

                                if($this->session->userdata('is_logged_in')) // Display editable link (on performance column)
                                {
                                    $performance = anchor('admin/multis_con/populate_results/' . $row->resultID, $row->points);
                                }
                                
                                    
                                echo '<tr>
                                        <td>' . $rank_style . '</td>
                                        <td><span class="'.$dateClass.'">' . $performance . '</span></td>
                                        <td>&nbsp;</td>
                                        <td>' . $row->ageGroup . '</td>
                                        <td>' . $row->placing . '</td>
                                        <td>' . $row->competition . '</td>
                                        <td>' . $row->venue . '</td>
                                        <td class="right">' . $row->date . '</td>
                                        <td>' . reduce_multiples($data, '&nbsp; - &nbsp;', TRUE) . '</td>
                                    </tr>';
                            
                            $rank++;
                            $data = '';
                            $cur_performance = $row->points; // Monitor this value

                            $label_looped = $label; // Monitor this value                                
                    
                    endforeach;

                    echo '</tbody>';
                    echo '</table>';
                    
                }
            ?>

            <?php
                // if( ! isset($athlete_data) || ! isset($athlete_multi_data) ) {
                //     echo '<h3 class="h3-one" style="margin: 15px 0;">No results found</h3>';
                // }
            ?>
            

        </div><!-- END col -->


		<div class="center">
			<a class="btn btn-search btn-red" href="" id="bottom_profile">New Search &nbsp; <i aria-hidden="true" class="fa fa-chevron-up"></i></a>
		</div><!-- ENDS center -->


    </div><!-- ENDS row -->

</div><!--END container-->


<?php if( isset($athlete_data) || isset($athlete_multi_data) ) { ?>

<script>

    // ON LOAD (of results) - scroll to top of list
    // ************************************************************************
    $(window).load(function() {

        var winWidth = $( window ).width();
        var offSetDist = false;

        if( winWidth <= 752 ) {
            offSetDist = -55;
        } else {
            offSetDist = -10;
        }

        var resultsLoaded = $('.h2-four').delay(10).velocity('scroll', { offset: offSetDist, duration: 300, easing: [ 0.17, 0.67, 0.83, 0.67 ]});

    });

</script>

<?php } else { ?>

<script>

    // ON LOAD (of results) - scroll to top of list
    // ************************************************************************
    $(window).load(function() {

        var winWidth = $( window ).width();
        var offSetDist = false;

        if( winWidth <= 752 ) {
            offSetDist = -35;
        } else {
            offSetDist = 0;
        }

        var resultsLoaded = $('.search-head').delay(10).velocity('scroll', { offset: offSetDist, duration: 300, easing: [ 0.17, 0.67, 0.83, 0.67 ]});


    });

</script>

<?php } ?>




<script>

    // SCROLL TO MEDALS / ANNUAL PROGRESSIONS ETC
    // #ANCHOR SCROLL ON PAGE
    // ************************************************************************
    $(document).ready(function (){

        var winWidth = $( window ).width();
        var offSetDist = false;

        if( winWidth <= 752 ) {
            offSetDist = -50;
        } else {
            offSetDist = 0;
        }

        $('.anchors a').click(function (){
            var location = $(this).attr('href');
            $(location).velocity('scroll', { offset: offSetDist, duration: 500, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
            return false;
        });


         // BACK TO TOP (of search form)
        // ************************************************************************
        $("#bottom_profile").on('click', function (){
            $('.search-head').velocity('scroll', { duration: 750, offset: offSetDist, easing: [ 0.17, 0.67, 0.83, 0.67 ]});
            return false;
        });

    });
    

</script>