<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class IOFRDYNBzGpVgPFgkwXWeKo extends CI_Controller {	
   
	function __construct() {

		 parent::__construct();
		$this->load->library('layout');          // Load layout library     
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('cookie');
		
		$this->load->model('category','',TRUE);
		
		$this->load->model('employee','',TRUE);
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->library('form_validation');
		
		$category_data = $this->category->category_dashboard();
		$this->category_db = $category_data;
		
		$employee_data = $this->employee->employee_dashboard();
		$this->employee_db = $employee_data;
		
		//echo '<pre>';print_r(count($cms_data));exit;
		if (!$this->session->userdata('logged_in')) {

			//return false;
			redirect('iOFRDYNBzGpVgPFgkwXWeKologin/index');

			//$this->load->view('page/admin/login',$data);
			}

	}
	
	public function dashboard()	{

		if (!$this->session->userdata('logged_in')) {			
			//return false;
			redirect('iOFRDYNBzGpVgPFgkwXWeKo/index');
			//$this->load->view('page/admin/login',$data);
		}
		
		$this->layout->title('rii - Home');
		$this->layout->description('rii - Home');   
		$this->layout->layout_view = 'layout/admin.php';
		$this->layout->view('page/admin/dashboard', $data);
	}
	

	
	public function index($data)	{   

		if ($this->session->userdata('logged_in')) {
			
			//return false;
			redirect('iOFRDYNBzGpVgPFgkwXWeKo/dashboard');
			//$this->load->view('page/admin/login',$data);
			}else{
			$this->load->view('page/admin/login', $data);
		}
	}
	

	public function logout()	{   		
		$this->session->unset_userdata('logged_in');
		
		redirect('iOFRDYNBzGpVgPFgkwXWeKologin/index');
	}
	
	
	
    
	public function add_category()	{   
		
		if(!empty($this->input->post())){
			 $this->form_validation->set_rules('category_title', 'category_title', 'required');
			 if ($this->form_validation->run() == FALSE) { 
         	$this->session->set_flashdata('msg', array('message' => validation_errors(),'class' => 'alert alert-danger  alert-dismissible','icon'=>'fa-check'));
			redirect('iOFRDYNBzGpVgPFgkwXWeKo/add_category'); 
         } 
         $category_duplicate_check = $this->category->category_duplicate_check($this->input->post('category_title'));
		if(!empty($category_duplicate_check->category_title)){
			$this->session->set_flashdata('msg', array('message' => 'Category Title Duplicate...!','class' => 'alert alert-danger alert-dismissible','icon'=>'fa-ban'));
        	redirect('iOFRDYNBzGpVgPFgkwXWeKo/add_category');
		}
			
			$this->load->helper(array('form', 'url'));
			$config['upload_path'] = './category/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['file_name']="";
			if($_FILES["photo"]['name']){
				$config['file_name'] = time().$_FILES["photo"]['name'];
			}
			
			// $config['max_size']	= '100';
			// $config['max_width']  = '1024';
			// $config['max_height']  = '768';
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('photo') && !empty($_FILES["photo"]['name']))
	        {
	            $status = 'error';
	            $msg = $this->upload->display_errors('', '');
	            $this->session->set_flashdata('msg', array('message' => 'Please upload only "gif|jpg|png" file ..!','class' => 'alert alert-danger alert-dismissible','icon'=>'fa-ban'));
	        	redirect('iOFRDYNBzGpVgPFgkwXWeKo/add_category');
	        }
	       
			
			$data = array(
				'category_title' => $this->input->post('category_title'),
				'photo'=> $config['file_name'],
				'status'=> $this->input->post('status'),
				'description'=> $this->input->post('description'),
				'created_date'=> date('Y-m-d'),

			);

			$this->category->category_insert($data);
			$this->session->set_flashdata('msg', array('message' => 'Category inserted successfully','class' => 'alert alert-success alert-dismissible','icon'=>'fa-check'));
			redirect('iOFRDYNBzGpVgPFgkwXWeKo/manage_category');
		}
		$data['get_category'] = $this->category->get_category($data);
		//echo '<pre>';print_r($data);exit;
		$this->layout->title('rii - add_category');
		$this->layout->description('rii - add_category');   
		$this->layout->layout_view = 'layout/admin.php';
		$this->layout->view('page/admin/add_category', $data);
	}
	
	public function edit_category($id)	{   
		
		if(!empty($this->input->post())){

			 $this->form_validation->set_rules('category_title', 'category_title', 'required');
			 if ($this->form_validation->run() == FALSE) { 
         		$this->session->set_flashdata('msg', array('message' => validation_errors(),'class' => 'alert alert-danger  alert-dismissible','icon'=>'fa-ban'));
				redirect("iOFRDYNBzGpVgPFgkwXWeKo/edit_category/".$id); 
        	 }

			if($this->input->post('category_title')!=$this->input->post('old_title'))
			{ 
				//$slug = strtolower($this->input->post('title'));
				$category_duplicate_check = $this->category->category_duplicate_check($this->input->post('category_title'));
				if(!empty($category_duplicate_check->category_title)){
					$this->session->set_flashdata('msg', array('message' => 'Category Title Duplicate...!','class' => 'alert alert-danger alert-dismissible','icon'=>'fa-ban'));
		        	redirect("iOFRDYNBzGpVgPFgkwXWeKo/edit_category/".$id); 
		        	
				}
			}
			$config['file_name'] ="";
			if($_FILES['photo']['name']!="")
			{
				
					$this->load->helper(array('form', 'url'));
					$config['upload_path'] = './category/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['file_name'] = time().$_FILES["photo"]['name'];
					
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('photo') && !empty($_FILES["photo"]['name']))
			        {
			            $status = 'error';
			            $msg = $this->upload->display_errors('', '');
			            $this->session->set_flashdata('msg', array('message' => 'Please upload only "gif|jpg|png" file ..!','class' => 'alert alert-danger alert-dismissible','icon'=>'fa-ban'));
			        	redirect('iOFRDYNBzGpVgPFgkwXWeKo/edit_category/'.$id);
			        }
			        unlink('category/'.$this->input->post('cover_image_hidden'));
					$cover_image_name = $config['file_name'];
					             
				
			}
			else
			{
				$cover_image_name = $this->input->post('cover_image_hidden');
			}
			$data = array(
				'category_title' => $this->input->post('category_title'),
				'photo'=> $cover_image_name,
				'status'=> $this->input->post('status'),
				'description'=> $this->input->post('description'),
				'updated_date'=> date('Y-m-d'),

			);
			//echo '<pre>';print_r($data);exit;
			$id = $this->category->update_category($data,$id);
			$this->session->set_flashdata('msg', array('message' => 'Category Page Updated successfully','class' => 'alert alert-success alert-dismissible','icon'=>'fa-check'));
			redirect('iOFRDYNBzGpVgPFgkwXWeKo/manage_category');
		}
		$data['get_category'] = $this->category->get_category($data);
		$this->layout->title('rii - Edit category');
		$this->layout->description('rii - category');   
		$this->layout->layout_view = 'layout/admin.php';

		$data['data']= $this->category->get_category_data($id);				
		$this->layout->view('page/admin/edit_category', $data);
	}
	public function category_delete($id){
		$data['data']= $this->category->get_category_unlink_file($id);
		unlink("category/".$data['data'][0]['photo']);
		$data['data']= $this->category->category_delete($id);
		$this->session->set_flashdata('msg', array('message' => 'Category deleted  successfully','class' => 'alert alert-success alert-dismissible','icon'=>'fa-check'));
		redirect('iOFRDYNBzGpVgPFgkwXWeKo/manage_category');
	}
	public function manage_category()	{   
		
		
		$data['get_category'] = $this->category->all_category($data);
		
		//echo '<pre>';print_r($data);;exit;
		$this->layout->title('rii - manage_category');
		$this->layout->description('rii - manage_category');   
		$this->layout->layout_view = 'layout/admin.php';
		$this->layout->view('page/admin/manage_category', $data);
	}
	
	public function add_employee()	{   
		
		if(!empty($this->input->post())){
			 $this->form_validation->set_rules('employee_name', 'employee name', 'required');
			 $this->form_validation->set_rules('category', 'category', 'required');
			
			 if ($this->form_validation->run() == FALSE) { 
	         	$msg=array('message' => validation_errors(),'class' => 'alert alert-danger  alert-dismissible','icon'=>'fa-ban','status' => 'failed');
	         	//ho '<pre>';print_r($msg);exit;
				
			}else{
				$this->load->helper(array('form', 'url'));
				$config['upload_path'] = './employee/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['file_name']="";
				if($_FILES["photo"]['name']){
					$config['file_name'] = time().$_FILES["photo"]['name'];
				}
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('photo') && !empty($_FILES["photo"]['name']))
		        {
		            $status = 'error';
		            $msg = $this->upload->display_errors('', '');
		            $msg=array('message' => 'Please upload only "gif|jpg|png" file ..!','class' => 'alert alert-danger alert-dismissible','icon'=>'fa-ban' ,'status' => 'failed');
		        	//redirect('iOFRDYNBzGpVgPFgkwXWeKo/manage_employee');
		        }else{
		        	$data1 = array(
						'category'=> $this->input->post('category'),
						'employee_name' => $this->input->post('employee_name'),
						'photo'=> $config['file_name'],
						'contact_no'=> $this->input->post('contact_no'),
						'hobby'=> implode(",",$this->input->post('hobby')),
						'created_date'=> date("Y-m-d"),
					);
			//echo '<pre>';print_r($data);exit;
					$this->employee->employee_insert($data1);
					$msg=array('message' => 'Employee inserted successfully','class' => 'alert alert-success alert-dismissible','icon'=>'fa-check' ,'status' => 'success');
		        	}


			}
						
		}
		$get_employee = $this->employee->cat_employee();
			$html = "";
			$html .= "<section class='content' ><div class='box'>";
			if(count($msg)>0) {
			  
			$html .="<div class='".$msg['class']."' id='message1'>
						<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
						<h4><i class='icon fa '". $msg['icon']."'></i> Message!</h4>
						".$msg['message']."
					  </div>";
			}
            //$html .= $this->load->view('page/admin/message'); 
      		 $html .="<div class='box-body'  >
          <div id='example1_wrapper' class='dataTables_wrapper form-inline dt-bootstrap'>
             <h4 class='msg1'>
            
          <button class='btn btn-sm btn-danger pull-right'  onclick='bulk_delete();'><i class='fa fa-trash'></i>Bulk Delete</button>
          <button class='btn btn-sm btn-primary pull-right' style='margin-right: 2px;' onclick='add_employee();'><i class='fa fa-plus'></i> Add Employee</button><div class='clearfix'></div></h4>

             <div class='clearfix'></div>
             <div class='row'>
                <div class='col-sm-12'>
            
                   <table id='' class='table table-bordered table-striped dataTable' role='grid' aria-describedby='example1_info'>
               
                      <thead>
                         <tr role='row'>
                            
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Name</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Select</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Contact no</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Hobby</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Category</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Profile Pic</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Platform(s): activate to sort column ascending' style='width: 199px;'>Action</th>
                           
                         </tr>
                      </thead>
                      <tbody id='data_refresh'>";
                
                foreach($get_employee as $data ) { 
                      $html.=" <tr role='row' class='odd' id='row_edit_".$data['id']."'>";
                            
                           
                $html.=" <td>". $data['employee_name'] ."</td>"; 
                 $html.=" <td><form method='post' name='select' id='select' class='select' ><input type='checkbox' name='bulk_select[]' value='".$data['id']."'></form></td>"; 
                 $html.=" <td>". substr_replace($data['contact_no'], str_repeat("X", 6), 4, 8) ."</td>";
                 $html.=" <td>". $data['hobby'] ."</td>";  
                 $html.=" <td>". $data['category_title'] ."</td>";  
            if($data['photo']!='')
                { 
                 $html.=" <td><img src='".base_url()."employee/".$data['photo']."' width='100' height='100'/></td>";   
               }
                else
                { 
                  $html.=" <td><img src='".base_url()."assets/images/img/PDF-Small.jpg' width='100' height='100'/> </td>";
              }         
                                                    
                          $html.="  <td>
                  <a href='#'><i class='fa fa-edit' title='Edit' onclick='edit_icon(".$data['id'].")' style='cursor:pointer; margin:0px 10px;' ></i></a>
                  <a href='#'><i title='Remove' onclick='employee_delete(".$data['id'].")' style='cursor:pointer; margin:0px 10px;' class='fa fa-trash-o'></i></a>
                            </td>
                            
                         </tr>";
                         }
                $html.="</tbody>
                      <tfoot>
                         <tr>
                            
                         </tr>
                      </tfoot>
                   </table>
                </div>
             </div>
             </div>
       </div>
</div>
  </section>";
  
  		$msg['record']=$html;

	echo json_encode($msg);exit;
}
	
	public function manage_employee()	{   
		
		
		$data['get_employee'] = $this->employee->cat_employee();
		$str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
		//echo '<pre>';print_r($data);;exit;
		$data['get_category'] = $this->category->get_category($data);
		$this->layout->title('rii - manage_employee');
		$this->layout->description('rii - manage_employee');   
		$this->layout->layout_view = 'layout/admin.php';
		$this->layout->view('page/admin/manage_employee', $data);
	}
	public function edit_employee($id)	{   
		
		if(!empty($this->input->post())){

			 $this->form_validation->set_rules('employee_name', 'Employee name', 'required');
			 $this->form_validation->set_rules('category', 'Category', 'required');
			 if ($this->form_validation->run() == FALSE) { 
	         	$msg = array('message' => validation_errors(),'status' =>'failed');
	         	echo json_encode($msg);exit;

				
			}
			
			$config['file_name'] ="";
			if($_FILES['photo']['name']!="")
			{
				
					$this->load->helper(array('form', 'url'));
					$config['upload_path'] = './employee/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['file_name'] = time().$_FILES["photo"]['name'];
					
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('photo') && !empty($_FILES["photo"]['name']))
			        {
			            $status = 'error';
			            $msg = $this->upload->display_errors('', '');
			            $msg= array('message' => 'Please upload only "gif|jpg|png" file ..!','class' => 'alert alert-danger alert-dismissible','icon'=>'fa-ban');
			            $msg = array('message' => 'Please upload only gif|jpg|png','status' =>'failed');
	         			echo json_encode($msg);exit;
			        	
			        }
			        unlink('employee/'.$this->input->post('cover_image_hidden'));
					$cover_image_name = $config['file_name'];
					             
				
			}
			else
			{
				$cover_image_name = $this->input->post('cover_image_hidden');
			}
			
			
			$data1 = array(
				'category'=> $this->input->post('category'),
				'employee_name' => $this->input->post('employee_name'),
				'photo'=> $cover_image_name,
				'contact_no'=> $this->input->post('contact_no'),
				'hobby'=> $this->input->post('hobby'),
				'modified_date'=> date("Y-m-d"),
			);
			
			
			$res=$this->employee->update_employee($data1,$id);
			
			
			
			
			
		}
		$get_category = $this->employee->category($id);
		
		$get_employee = $this->employee->get_employee_data($id);	
		//echo $get_employee->id ;exit;
		$html ="";
		
		
                //$html.=" <tr role='row' class='odd' id='row_edit_".$get_employee->id."'>";
                $html.=" <td>". $get_employee->employee_name ."</td>"; 
                $html.=" <td><form method='post' name='select' id='select' class='select' ><input type='checkbox' name='bulk_select[]' value='".$get_employee->id."'></form></td>"; 
                $html.=" <td>". substr_replace($get_employee->contact_no, str_repeat("X", 6), 4, 8) ."</td>";
                $html.=" <td>". $get_employee->hobby ."</td>";  
                $html.=" <td>". $get_employee->category_title ."</td>";  
            	if($get_employee->photo!='')
                { 
                	$html.=" <td><img src='".base_url()."employee/".$get_employee->photo."' width='100' height='100'/></td>";   
               	}
                else
                { 
                  	$html.=" <td><img src='".base_url()."assets/images/img/PDF-Small.jpg' width='100' height='100'/> </td>";
              	}         
                                                    
                $html.="  <td>
                  <a href='#'><i class='fa fa-edit' onclick='edit_icon(".$get_employee->id.")' title='Edit' style='cursor:pointer; margin:0px 10px;' ></i></a>
                  <a href='#'><i title='Remove' onclick='employee_delete(".$get_employee->id.")' style='cursor:pointer; margin:0px 10px;' class='fa fa-trash-o'></i></a>
                            </td>
                            
                         ";
            $msg=array('message' => 'Employee Updated successfully','status' => 'success','record' => $html);

            echo json_encode($msg);	exit;
		
	}

	public function employee_delete($id){
		$data1['data']= $this->employee->get_employee_unlink_file($id);
		unlink("employee/".$data1['data'][0]['photo']);
		$data1['data']= $this->employee->employee_delete($id);
		unlink("product_extra_img/".$data1['data'][0]['photo']);
		unlink("product_extra_img/thumb_".$data1['data'][0]['photo']);
		$get_employee = $this->employee->cat_employee();
		$msg=array('message' => 'Employee deleted  successfully','class' => 'alert alert-success alert-dismissible','icon'=>'fa-check');
		$html = "";
			$html .= "<section class='content' ><div class='box'>";
			if(count($msg)>0) {
			  
			$html .="<div class='".$msg['class']."' id='message1'>
						<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
						<h4><i class='icon fa '". $msg['icon']."'></i> Message!</h4>
						".$msg['message']."
					  </div>";
			}
            //$html .= $this->load->view('page/admin/message'); 
      		 $html .="<div class='box-body'  >
          <div id='example1_wrapper' class='dataTables_wrapper form-inline dt-bootstrap'>
             <h4 class='msg1'>
            
          <button class='btn btn-sm btn-danger pull-right'  onclick='bulk_delete();'><i class='fa fa-trash'></i>Bulk Delete</button>
          <button class='btn btn-sm btn-primary pull-right' style='margin-right: 2px;' onclick='add_employee();'><i class='fa fa-plus'></i> Add Employee</button><div class='clearfix'></div></h4>

             <div class='clearfix'></div>
             <div class='row'>
                <div class='col-sm-12'>
            
                   <table id='' class='table table-bordered table-striped dataTable' role='grid' aria-describedby='example1_info'>
               
                      <thead>
                         <tr role='row'>
                            
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Name</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Select</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Contact no</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Hobby</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Category</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Profile Pic</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Platform(s): activate to sort column ascending' style='width: 199px;'>Action</th>
                           
                         </tr>
                      </thead>
                      <tbody id='data_refresh'>";
                
                foreach($get_employee as $data ) { 
                      $html.=" <tr role='row' class='odd' id='row_edit_".$data['id']."'>";
                            
                           
                $html.=" <td>". $data['employee_name'] ."</td>"; 
                 $html.=" <td><form method='post' name='select' id='select' class='select' ><input type='checkbox' name='bulk_select[]' value='".$data['id']."'></form></td>"; 
                 $html.=" <td>". substr_replace($data['contact_no'], str_repeat("X", 6), 4, 8) ."</td>";
                 $html.=" <td>". $data['hobby'] ."</td>";  
                 $html.=" <td>". $data['category_title'] ."</td>";  
            if($data['photo']!='')
                { 
                 $html.=" <td><img src='".base_url()."employee/".$data['photo']."' width='100' height='100'/></td>";   
               }
                else
                { 
                  $html.=" <td><img src='".base_url()."assets/images/img/PDF-Small.jpg' width='100' height='100'/> </td>";
              }         
                                                    
                          $html.="  <td>
                  <a href='#'><i class='fa fa-edit' onclick='edit_icon(".$data['id'].")' title='Edit' style='cursor:pointer; margin:0px 10px;' ></i></a>
                  <a href='#'><i title='Remove' onclick='employee_delete(".$data['id'].")' style='cursor:pointer; margin:0px 10px;' class='fa fa-trash-o'></i></a>
                            </td>
                            
                         </tr>";
                         }
                $html.="</tbody>
                      <tfoot>
                         <tr>
                            
                         </tr>
                      </tfoot>
                   </table>
                </div>
             </div>
             </div>
       </div>
</div>
  </section>";

echo $html;exit;
		
	}

	public function bulk_employee_delete(){
		
		$data['data']= $this->employee->bulk_employee_delete($this->input->post('bulk_select'));
		
		$msg= array('message' => 'Employee deleted  successfully','class' => 'alert alert-success alert-dismissible','icon'=>'fa-check');
		$get_employee = $this->employee->cat_employee();
		$msg=array('message' => 'Employee deleted  successfully','class' => 'alert alert-success alert-dismissible','icon'=>'fa-check');
		$html = "";
			$html .= "<section class='content' ><div class='box'>";
			if(count($msg)>0) {
			  
			$html .="<div class='".$msg['class']."' id='message1'>
						<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
						<h4><i class='icon fa '". $msg['icon']."'></i> Message!</h4>
						".$msg['message']."
					  </div>";
			}
            //$html .= $this->load->view('page/admin/message'); 
      		 $html .="<div class='box-body'  >
          <div id='example1_wrapper' class='dataTables_wrapper form-inline dt-bootstrap'>
             <h4 class='msg1'>
            
          <button class='btn btn-sm btn-danger pull-right'  onclick='bulk_delete();'><i class='fa fa-trash'></i>Bulk Delete</button>
          <button class='btn btn-sm btn-primary pull-right' style='margin-right: 2px;' onclick='add_employee();'><i class='fa fa-plus'></i> Add Employee</button><div class='clearfix'></div></h4>

             <div class='clearfix'></div>
             <div class='row'>
                <div class='col-sm-12'>
            
                   <table id='' class='table table-bordered table-striped dataTable' role='grid' aria-describedby='example1_info'>
               
                      <thead>
                         <tr role='row'>
                            
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Name</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Select</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Contact no</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Hobby</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Category</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Browser: activate to sort column ascending' style='width: 226px;'>Profile Pic</th>
                            <th class='sorting' tabindex='0' aria-controls='example1' rowspan='1' colspan='1' aria-label='Platform(s): activate to sort column ascending' style='width: 199px;'>Action</th>
                           
                         </tr>
                      </thead>
                      <tbody id='data_refresh'>";
                
                foreach($get_employee as $data ) { 
                      $html.=" <tr role='row' class='odd' id='row_edit_".$data['id']."'>";
                            
                           
                $html.=" <td>". $data['employee_name'] ."</td>"; 
                 $html.=" <td><form method='post' name='select' id='select' class='select' ><input type='checkbox' name='bulk_select[]' value='".$data['id']."'></form></td>"; 
                 $html.=" <td>". substr_replace($data['contact_no'], str_repeat("X", 6), 4, 8) ."</td>";
                 $html.=" <td>". $data['hobby'] ."</td>";  
                 $html.=" <td>". $data['category_title'] ."</td>";  
            if($data['photo']!='')
                { 
                 $html.=" <td><img src='".base_url()."employee/".$data['photo']."' width='100' height='100'/></td>";   
               }
                else
                { 
                  $html.=" <td><img src='".base_url()."assets/images/img/PDF-Small.jpg' width='100' height='100'/> </td>";
              }         
                                                    
                          $html.="  <td>
                  <a href='#' onclick='edit_icon(".$data['id'].")' ><i class='fa fa-edit' title='Edit' style='cursor:pointer; margin:0px 10px;' ></i></a>
                  <a href='#'><i title='Remove' onclick='employee_delete(".$data['id'].")' style='cursor:pointer; margin:0px 10px;' class='fa fa-trash-o'></i></a>
                            </td>
                            
                         </tr>";
                         }
                $html.="</tbody>
                      <tfoot>
                         <tr>
                            
                         </tr>
                      </tfoot>
                   </table>
                </div>
             </div>
             </div>
       </div>
</div>
  </section>";

echo $html;exit;
	}
	
	public function get_single_emp_detaile($id){ 

		$get_category = $this->category->get_category();  
		$employee= $this->employee->get_employee_data($id);
		//echo '<pre>';print_r($employee);exit;
		$category=explode(',',$employee->hobby);
		//echo '<pre>';print_r($category);exit;
		$html="";
		$html .="<section id='edit_form' style='display:none'>

          <table id='' class='table table-bordered table-striped dataTable' role='grid' aria-describedby='example1_info'>
               
                     
                      <tbody id='data_refresh'>
                        <form method='post' name='emp_form_".$employee->id."' enctype='multipart/form-data' id='emp_form_".$employee->id."'>
                
                         <tr role='row' class='odd'>
                          <td> 
                            <input type='text' class='form-control' id='employee_name".$employee->id."' name='employee_name' placeholder='Employee Name' value='".$employee->employee_name."' required>
                          </td> 
                         <td><input type='checkbox' name='bulk_select[]' value='".$employee->id."'></td> 
                         <td><input type='text' class='form-control' onkeypress='return isNumberKey(event)' maxlength='10' id='contact_no".$employee->id."' value='".$employee->contact_no ."' name='contact_no' placeholder='Contact No' > </td> 
                         <td><input type='checkbox' name='hobby_".$employee->id."[]' value='Programing'";if(in_array("Programing", $category)){
                         $html.=" checked";
                     }
                         $html.=">";
                         $html.="Programing &nbsp; <input type='checkbox'   value='Games' name='hobby_".$employee->id."[]'";
                          if(in_array("Games", $category)){ 
                          	$html.=" checked";
                          	}
                          	$html.=">";
                          	$html.="Games &nbsp; 
                    <input type='checkbox'  value='Reading' name='hobby_".$employee->id."[]'";
                    if(in_array("Reading", $category)){ 
                          	$html.=" checked";
                          	} 
                          	$html.=">Reading &nbsp; <input type='checkbox'  name='hobby_".$employee->id."[]' value='Photography'";
                          	if(in_array("Photography", $category)){ 
                          	$html.=" checked";
                          	} 
                          	$html.= " >Photography</td> 
                          <td>
                              <select class='form-control custom-control' name='category' id='category".$employee->id."' required><option value=''>Category</option>
                            ";
                            foreach($get_category as $key => $val)
                            {
                            
                              $html.="<option value='".$val['id']."'";
                              if($employee->category == $val['id']){
                              	$html.="selected";
                              }
                              $html.=">".$val['category_title']."</option>";
                            }
                           $html.=" </select>
                          </td> ";
           					
                          $html.="<td><img src='".base_url()."employee/".$employee->photo."' width='100' height='100'/><input id='photo".$employee->id."' type='file' class='form-control' name='photo' style='width:100%'> <input type='hidden' value='".$employee->photo."' id='cover_image_hidden".$employee->id."' name='cover_image_hidden'></td>";
                          $html.=" <td>
                  			<button type='button' class='btn btn-default btn-sm' onclick='save(".$employee->id.")'>
					          <span class='glyphicon glyphicon-ok'></span> Update 
					        </button> 
                   		
 							</td>
                            
                         </tr>
                        </form>
                      </tbody>
                      
                   </table>
  </section>";
  echo $html;exit;
		
	}
	
	
	
	
}
?>
