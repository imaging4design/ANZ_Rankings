<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Graphs_con extends CI_Controller {


	function getGraph() {

		//$this->db->select_max('distHeight', 'distHeight');
		$this->db->select('time');
		$this->db->select('distHeight, implement');
		$this->db->select("DATE_FORMAT(date, '%d %b') AS year", FALSE);
		$this->db->where('athleteID', $this->input->post('athleteProfileID'));
		$this->db->where('YEAR(date)', $this->input->post('yearSelected'));
		$this->db->where('eventID', $this->input->post('postEvent'));
		$this->db->order_by('date', 'ASC');
		$query = $this->db->get('results');
		
		if($query->num_rows() >0) 
		{
			$graphs = $query->result();
		}


		if( $graphs ) {

			//start the json data in the format Google Chart js/API expects to recieve it
			$graph->cols[]=array("id"=>"","label"=>"Mark","pattern"=>"","type"=>"string");
			$graph->cols[]=array("id"=>"","label"=>"Perf","pattern"=>"","type"=>"number");

			foreach( $graphs as $row ):

				$performance = ( $row->time ) ? ltrim(str_replace(':', '', $row->time), 0) : ltrim($row->distHeight, 0);
				$unformatted = ( $row->time ) ? ltrim($row->time, 0) : ltrim($row->distHeight, 0) . ' - ('. $row->implement .')';

				//$time = ltrim($row->time, 0);
				//$distHeight = ltrim($row->distHeight, 0);

				$graph->rows[] = array('c' => array(array('v' => $row->year), array('v' => $performance,"f"=>$unformatted )));

			endforeach;

			echo json_encode($graph);

		}

		// EXAMPLE CODE ....
		// $responce->cols[]=array("id"=>"","label"=>"Mark","pattern"=>"","type"=>"string");
		// $responce->cols[]=array("id"=>"","label"=>"Javelin","pattern"=>"","type"=>"number");
		// $responce->rows[]["c"]=array(array("v"=>2000,"f"=>null),array("v"=>'121.03',"f"=>'1:21.05'));
		// $responce->rows[]["c"]=array(array("v"=>2000,"f"=>null),array("v"=>'124.23',"f"=>null));
		// $responce->rows[]["c"]=array(array("v"=>2000,"f"=>null),array("v"=>'125.00',"f"=>null));
		// $responce->rows[]["c"]=array(array("v"=>2000,"f"=>null),array("v"=>'127.00',"f"=>null));
		// $responce->rows[]["c"]=array(array("v"=>2000,"f"=>null),array("v"=>'130.00',"f"=>null));

		// echo json_encode($responce);
	}
	
	
	
	
} //ENDS Graphs_con class