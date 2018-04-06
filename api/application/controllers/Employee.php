<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
  
  function __construct()
  {
    parent::__construct();
    $this->load->model('EmployeeModel', 'employee', TRUE);
		$this->load->helper('url');
  }
  
  public function get_all(){
		$employees = $this->employee->get_all();
		$response = array();
		foreach($employees as $emp){
			$employee = array();
			$employee["id"] = $emp->id;
			$employee["first_name"] = $emp->first_name;
			$employee["surname"] = $emp->surname;
			$employee["position"] = $emp->position;
      $employee["mobile_phone"] = $emp->mobile_phone;
      $employee["email"] = $emp->email;
			$convert_date = explode(" ", $emp->date_birth);
			$convert_date = implode("/",array_reverse(explode("-",$convert_date[0])));
      $employee["date_birth"] = $convert_date;
      $employee["img"] = $emp->img;
 			array_push($response, $employee);
		}
		echo json_encode($response);
	}
  public function delete(){
		$msg = "";
		$request = array();
		$json = file_get_contents('php://input');
    $request = json_decode($json, true);
    $id = "";
    if(!empty($request))
    {
    	foreach ($request as $key => $val) 
    	{
				if($key == "id"){
					$id = $val;	
				}
      }
    }
    $this->db->set('status', 'deleted');
    $this->db->where('id', $id);
    if($this->db->update('employees')){
      $msg = "deleted";
    }
    else{
      $msg = "erro";
    }
    echo $msg;
  }
	public function add(){
		$msg = "";
		$request = array();
		$json = file_get_contents('php://input');
    $request = json_decode($json, true);
    $first_name = "";
		$surname = "";
		$position = "";
		$mobile_phone = "";
		$email = "";
		$date_birth = "";
    	if(!empty($request))
    	{
    		foreach ($request as $key => $val) 
    		{
		        if($key == "first_name"){
		        	$first_name = $val;
		        }else
					  if($key == "surname"){
		        	$surname = $val;
		        }else
		        if($key == "position"){
		        	$position = $val;
		        }else
		        if($key == "mobile_phone"){
		        	$mobile_phone = $val;
		        }else
		        if($key == "email"){
		        	$email = $val;
		        }else
		        if($key == "date_birth"){
		        	$date_birth = $val;
		        }else{
							$msg = "valor enviado invalido";
						}		        
		    }
				$new_date =  implode("-",array_reverse(explode("/",$date_birth)));
				$dados = array(
            'first_name' => $first_name,
						'surname' => $surname,
						'position' => $position,
						'mobile_phone' => $mobile_phone,
            'email' => $email,
            'date_birth' => $new_date,
						'status' => 'valid'
        );
				
				if($this->db->insert('employees', $dados)){
					$insert_id = $this->db->insert_id();
					$msg = $insert_id."|sucesso";
				}else{
					$msg = "Ocorreu algum erro";
				}				
		}
		else
		{
		    $msg = "Erro ao enviar os dados";
		}
		echo $msg;
	}
	public function edit(){
		$msg = "";
		$request = array();
		$json = file_get_contents('php://input');
    $request = json_decode($json, true);
    $first_name = "";
		$surname = "";
		$position = "";
		$mobile_phone = "";
		$email = "";
		$date_birth = "";
		$id;
    	if(!empty($request))
    	{
    		foreach ($request as $key => $val) 
    		{
					 if($key == "id"){
		        	$id = $val;
		        }else
		        if($key == "first_name"){
		        	$first_name = $val;
		        }else
					  if($key == "surname"){
		        	$surname = $val;
		        }else
		        if($key == "position"){
		        	$position = $val;
		        }else
		        if($key == "mobile_phone"){
		        	$mobile_phone = $val;
		        }else
		        if($key == "email"){
		        	$email = $val;
		        }else
		        if($key == "date_birth"){
		        	$date_birth = $val;
		        }else{
							$msg = "valor enviado invalido";
						}		        
		    }
				$new_date =  implode("-",array_reverse(explode("/",$date_birth)));
				$dados = array(
            'first_name' => $first_name,
						'surname' => $surname,
						'position' => $position,
						'mobile_phone' => $mobile_phone,
            'email' => $email,
            'date_birth' => $new_date,
						'status' => 'valid'
        );
				$this->db->where('id',$id);
				if($this->db->update('employees',$dados)){
					$msg = $id."|sucesso";
				}else{
					$msg = "Ocorreu algum erro";
				}				
		}
		else
		{
		    $msg = "Erro ao enviar os dados";
		}
		echo $msg;
	}
	public function get_employee_by_id($id){
		$employees = $this->employee->get_by_id($id);
		$response = array();
		$employee = array();
		foreach($employees as $emp){
			//$employee = array();
			$employee["id"] = $emp->id;
			$employee["first_name"] = $emp->first_name;
			$employee["surname"] = $emp->surname;
			$employee["position"] = $emp->position;
      $employee["mobile_phone"] = $emp->mobile_phone;
      $employee["email"] = $emp->email;
			$convert_date = explode(" ", $emp->date_birth);
			$convert_date = implode("/",array_reverse(explode("-",$convert_date[0])));
      $employee["date_birth"] = $convert_date;
			//$employee["date_birth"] = $emp->date_birth;
      $employee["img"] = $emp->img;
 			//array_push($response, $employee);
		}
		echo json_encode($employee);
		
	}
}	