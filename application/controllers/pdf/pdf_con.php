<?php

class Pdf_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('pdf/results_model');
		$this->load->model('pdf/multis_model');
		
	} //ENDS __construct()
	
	
	
	/**************************************************************/
	// Page Header
	/**************************************************************/
	function pageHeader() {
		
		$this->fpdf->AddFont('DINReg','','DIN-Regular.php');
		$this->fpdf->AddFont('DINMed','','DIN-Medium.php');
		
	} //END Header()
	
	
	
	
	/**************************************************************/
	// Build table function
	/**************************************************************/
	function BuildTable($header, $data) {

		//Colours, line width and bold font
		$this->fpdf->SetFillColor(245, 245, 245);
		$this->fpdf->SetTextColor(0, 0, 0);
		$this->fpdf->SetDrawColor(255, 255, 255);
		$this->fpdf->SetLineWidth(.1);
		
		$this->fpdf->SetFont('DINMed', '', 9);
		//Header
		//Make an array for the column widths
		$w = array(6,12,9,8,36,8,18,10,40,36,17);
		//send the headers to the pdf document
		for($i=0; $i<count($header); $i++):
		
			//Set alignment to left except right column
			$align = 'L';
			
			if($i==8 or $i==9 or $i==10) { $align = 'R'; }
			if($i==6 or $i==7) { $align = 'C'; }
		
		$this->fpdf->Cell($w[$i], 6, $header[$i], 1, 0, $align, 1);
		
		endfor;
				
				
		$this->fpdf->Ln();
		
		//Color and font restoration
		$this->fpdf->SetFillColor(245, 245, 245);
		$this->fpdf->SetTextColor(0);
		$this->fpdf->SetFont('DINReg', '', 8);

		//now spool out the data from the $data array
		$fill = 0; //used to alternate row color backgrounds
		
		foreach($data as $row):

				$this->fpdf->Cell($w[0], 6, $row[0], 'LRTB', 0, 'L', $fill); //Date
				$this->fpdf->Cell($w[1], 6, $row[1], 'LRTB', 0, 'R', $fill); //Work Details
				$this->fpdf->Cell($w[2], 6, $row[2], 'LRTB', 0, 'R', $fill); //Additional Costs
				$this->fpdf->Cell($w[3], 6, $row[3], 'LRTB', 0, 'L', $fill); //Time
				$this->fpdf->Cell($w[4], 6, $row[4], 'LRTB', 0, 'L', $fill); //Time
				$this->fpdf->Cell($w[5], 6, $row[5], 'LRTB', 0, 'L', $fill); //Time
				$this->fpdf->Cell($w[6], 6, $row[6], 'LRTB', 0, 'C', $fill); //Time
				$this->fpdf->Cell($w[7], 6, $row[7], 'LRTB', 0, 'C', $fill); //Time
				$this->fpdf->Cell($w[8], 6, $row[8], 'LRTB', 0, 'R', $fill); //Time
				$this->fpdf->Cell($w[9], 6, $row[9], 'LRTB', 0, 'R', $fill); //Time
				$this->fpdf->Cell($w[10], 6, $row[10], 'LRTB', 0, 'R', $fill); //Time

				$this->fpdf->Ln();
				$fill =! $fill;
				
		endforeach;

	} //ends build table function
	
	
	
	
	/**************************************************************/
	// START MAIN PDF OUTPUT HERE!!!
	/**************************************************************/
	function results_PDF() {
		
		// SET SOME GLOBAL CONFIG SETTINGS FOR THE PDF
		$this->load->library('fpdf');
		$this->fpdf->FPDF( 'P', 'mm', 'A4'); //set document to portrait, mm and A4
		define('FPDF_FONTPATH', $this->config->item('fonts_path')); //set master fonts path
		
		$this->fpdf->Open();
		$this->fpdf->AddPage();
		
		$this->fpdf->Image('img/background.jpg', 0, 0, 210, 297);
		$this->fpdf->SetDisplayMode('fullpage', 'continuous'); // Opens PDF in 'full page mode'
		$this->fpdf->SetMargins(5, 5, 5); //set page marging to 10mm (top, left and right)
		$this->fpdf->SetAutoPageBreak('auto', 5);
		
		$this->pageHeader(); //print header
		
		
		
						
		/**************************************************************/
		// GET DATA TO FEED INTO PDF TABLE
		/**************************************************************/
			$data = array();
										
			// Set up $this->config->item('xxxxxxx') vars
			$eventID = $this->session->userdata('eventID');
			$track_events = $this->config->item('track_events');
			$track_events_wind = $this->config->item('track_events_wind');
			$field_events = $this->config->item('field_events');
			$field_events_wind = $this->config->item('field_events_wind');
			$multi_events = $this->config->item('multi_events');
			$relay_events = $this->config->item('relay_events');
			
			
			// WHAT IS THE EVENT NAME?
			// Converts the eventID to a human friendly eventName 
			$event = convertEventID(); // see global helper
			
			
			// WHAT IS THE AGE GROUP?
			// Pass the session(ageGroup) throug the $this->config->item('ageGroups') array
			// foreach($this->config->item('ageGroups') as $key => $value):
			
			// 	if($this->session->userdata('ageGroup') == $key)
			// 	{
			// 		$ageGroup = $value.'studd';
			// 	}
				
			// endforeach;

			// NEW! .. This gives the new correct 'Age Group' Labels
			if( $this->session->userdata('ageGroup') ) {

				$ageGroup = ageGroupLabels( $this->session->userdata('ageGroup') ); // see global_helper

			}
			else
			{
				$ageGroup = FALSE;
			}
			
			
			// WHAT IS THE YEAR?
			if($this->session->userdata('year') == 0)
			{
				$year = 'All since 2008';
			}
			else
			{
				$year = $this->session->userdata('year');
			}
			
			
			// WHAT IS THE NUMBER OF RESULTS?
			$numResults = $this->session->userdata('list_depth');
			
			
			// WHAT IS THE SEARCH TYPE (by athlete or by performance)
			if($this->session->userdata('list_type') == 0)
			{
				$listType = 'Athletes';
			}
			else
			{
				$listType = 'Performances';
			}
			
			
			/**************************************************************/
			// Output 'legal' wind track events 
			/**************************************************************/
			if(in_array($eventID, $track_events) && in_array($eventID, $track_events_wind)) 
			{
				if($query = $this->results_model->results_legal_wind())
				{
					$results = $query;
				}
								
			} // end
			
			
			/**************************************************************/
			// Output wind 'irrelevant' track events 
			/**************************************************************/
			if(in_array($eventID, $track_events) && !in_array($eventID, $track_events_wind))
			{
				if($query = $this->results_model->results())
				{
					$results = $query;
				}
				
			} // end
			
			
			/**************************************************************/
			// Output 'legal' wind field events 
			/**************************************************************/
			if(in_array($eventID, $field_events) && in_array($eventID, $field_events_wind))
			{
				if($query = $this->results_model->results_legal_wind())
				{
					$results = $query;
				}
				
			} // end
			
			
			/**************************************************************/
			// Output 'non-implement' affected field events 
			/**************************************************************/
			if(in_array($eventID, $field_events) && !in_array($eventID, $field_events_wind))
			{
				if($query = $this->results_model->results())
				{
					$results = $query;
				}
				
			} // end
			
			
			/**************************************************************/
			// Output 'multi' events 
			/**************************************************************/
			if(in_array($eventID, $multi_events))
			{
				// Select ALL multi events
				if($query = $this->multis_model->multis())
				{
					$result_multi = $query;
				}
				
			} // end
		
		
		
		//Output 'TAX INVOICE'
		$this->fpdf->SetFont('DINMed', '', 12);
		$this->fpdf->Write(3.5, $event->eventName . ' | ' . $ageGroup . ' | ' . $year . ' | Top ' . $numResults . ' ' .$listType);
		$this->fpdf->Ln(10);
		
		
		
		$header = array(' ', 'Result', 'Wind', ' ', 'Name', 'Cen', 'DOB', 'Plc', 'Competition', 'Venue', 'Date');
		
		
		
		/*******************************************************************************************************/
		// SET UP PDF RESULTS BLOCK FOR 'INDIVIDUAL' BASED EVENTS
		/*******************************************************************************************************/
		$rank = 1;
		
		if(isset($results)) {
			
			foreach($results as $row):
			
			//Determind if track event (time) or field event (distHeight)
			if($row->time)
			{
				// Left trim leading 0's
				$performance = ltrim($row->time, 0);
			}
			else
			{
				// Left trim leading 0's
				$performance = ltrim($row->distHeight, 0);
			}
			
			//Determind if indoor or outdoors
			if($row->in_out == 'in')
			{
				$in_out = 'i';
			}
			else
			{
				$in_out = '';
			}
			
			// Create $data[] array of results
			$data[] = array($rank, $performance . ' '. $in_out, $row->wind, $row->record, $row->nameFirst . ' ' . strtoupper($row->nameLast), $row->centreID, $row->DOB, $row->placing, $row->competition, $row->venue, $row->date);
				
			$rank++;
			
			endforeach;
			
		}
		
		
		
		/*******************************************************************************************************/
		// SET UP PDF RESULTS BLOCK FOR 'MULTI' BASED EVENTS
		/*******************************************************************************************************/
		
		if(isset($result_multi)) {
			
			foreach($result_multi as $row):
			
			// Create $data[] array of results
			$data[] = array($rank, $row->points, '', $row->record, $row->nameFirst . ' ' . strtoupper($row->nameLast), $row->centreID, $row->DOB, $row->placing, $row->competition, $row->venue, $row->date);
				
			$rank++;
			
			endforeach;
			
		}
		
		
		// Start writing the results in tabular format ...
		$this->BuildTable($header, $data);
		
		// Output the file and name it ANZ_Rankings.pdf
		// 'I' means output pdf as continuous page .. 
		// 'D' means output pdf as single page .. 
		$this->fpdf->Output($event->eventName . '_' . $ageGroup . '_' . $year . '_Top ' . $numResults . '_' .$listType.'.pdf', 'I'); 
		
		
	} //END results_PDF()
	
	
	

} // END Pdf_con class