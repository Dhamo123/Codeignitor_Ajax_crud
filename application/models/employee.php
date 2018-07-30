<?php
Class Employee extends CI_Model
{		
    function get_employee()
	{		
		$this->db->select(' * ');
        $this->db->from('employee');
        
		$query = $this->db->get();
        return $result = $query->result_array();
    }
    function employee()
	{		
		$this->db->select(' * ');
        $this->db->from('employee');
        
        $query = $this->db->get();
        return $result = $query->result_array();
    }
    
	function cat_employee()
	{		

		$this->db->select(' employee.*,category.category_title ');
        $this->db->from('category');
		$this->db->join('employee', 'employee.category = category.id', 'right');
		$this->db->where('category.status','Yes');
		$this->db->group_by('employee.id');
		
       
        $query = $this->db->get();
		//echo $this->db->last_query();exit;
        return $result = $query->result_array();
       
    }
	
    function employee_insert($data){
		$this->db->insert('employee', $data);	
		return $this->db->insert_id();		
	}
	
	function update_employee($data,$id){
		$this->db->update('employee', $data, "id = ".$id);	
		return $id;
	}
	function employee_dashboard()
	{		
		$this->db->select(' * ');
        $this->db->from('employee');
        
        $query = $this->db->get();
        return $result = $query->result_array();
    }
   
	function category(){
		$this->db->select('*');
        $this->db->from('category');
        
        $query = $this->db->get();
        return $result = $query->result_array();
	}

	function get_employee_unlink_file($id)
	{
		$this->db->select('*');
        $this->db->from('employee');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $result = $query->result_array();
	}
	
	function get_employee_data($id){
		$this->db->select(' employee.*,category.category_title');
        $this->db->from('category');
		$this->db->join('employee', 'employee.category = category.id', 'right');
		$this->db->where('employee.id',$id);
		$this->db->group_by('employee.id');
        $query = $this->db->get();
        return $result = $query->row();
	}
	
	function employee_delete($id) {
        $this->db->where('id',$id);
        $this->db->delete('employee');
    }
    function bulk_employee_delete($id) {
    	//echo'<pre>';print_r($id);exit;
        $this->db->where_in('id',$id);
        $this->db->delete('employee');
    }
    
	
	
}
?>
