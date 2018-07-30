
<div id="msg">
<section class="content-header">
      <h1>
        Manage Employee
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>iOFRDYNBzGpVgPFgkwXWeKo/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>        
        <li class="active">Manage Employee</li>
      </ol>
</section>

<!-- Main content -->
<section class="content" >
          <!-- Small boxes (Stat box) -->
         <div class="box">
      
       <div class="box-body" >
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
             <h4 class="msg1">
            
          <button class="btn btn-sm btn-danger pull-right"  onclick="bulk_delete();"><i class="fa fa-trash"></i>Bulk Delete</button>
          <button class="btn btn-sm btn-primary pull-right" style="margin-right: 2px;" onclick="add_employee();"><i class="fa fa-plus"></i> Add Employee</button><div class="clearfix"></div></h4>

             <div class="clearfix"></div>
             <div class="row">
                <div class="col-sm-12">
    				
                   <table id="" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
    				   
                      <thead>
                         <tr role="row">
                            
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 226px;">Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 226px;">Select</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 226px;">Contact no</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 226px;">Hobby</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 226px;">Category</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 226px;">Profile Pic</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 199px;">Action</th>
                           
                         </tr>
                      </thead>
                      <tbody id="data_refresh">
    					  <?php 
                
    						foreach($get_employee as $data ) { ?>
                         <tr role="row" class="odd" id="row_edit_<?php echo $data['id'];?>">
                         <td><?php echo $data['employee_name'] ;?></td> 
            						 <td><form method="post" name="select" id="select" class="select" ><input type="checkbox" name="bulk_select[]" value="<?php echo $data['id'] ;?>"></form></td> 
                         <td><?php echo substr_replace($data['contact_no'], str_repeat("X", 6), 4, 8) ;?></td> 
                         <td><?php echo $data['hobby'] ;?></td> 
                         <td><?php echo $data['category_title'] ;?></td> 
    				<?php   if($data['photo']!='')
    						{ ?>
    							       <td><img src="<?php echo base_url().'employee/'.$data['photo'] ;?>" width="100" height="100"/></td>   
    				  <?php }
    						else
    						{ ?>
    							       <td><img src="<?php echo base_url().'assets/images/img/PDF-Small.jpg' ;?>" width="100" height="100"/> </td>
    				  <?php }?>         
                                                    
                            <td>
    							<a href="#"><i class="fa fa-edit" onclick="edit_icon(<?php echo $data['id']?>)" title="Edit" style="cursor:pointer; margin:0px 10px;" ></i></a>
    							<a href="#"><i title="Remove" onclick="employee_delete(<?php echo $data['id'] ?>);" style="cursor:pointer; margin:0px 10px;" class="fa fa-trash-o"></i></a>
                            </td>
                            
                         </tr>
                        <?php }?>
                      </tbody>
                      <tfoot>
                         <tr>
                            
                         </tr>
                      </tfoot>
                   </table>
                </div>
             </div>
             </div>
       </div>
   <!-- /.box-body -->
      
</div>
  </section>
</div>
<!-- /.content -->
<section>
<table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info" style="display:none; margin-left:30%;" id="employee_form"  >
                <form role="form" method="post" method="post" enctype="multipart/form-data" name="emp_form"  id="emp_form">
                  <tr>
                    <td><label for="exampleInputEmail1">Name *</label></td>
                    <td><input type="text" class="form-control" id="employee_name" name="employee_name" placeholder="Employee Name" required> </td>
                  </tr>
                  <tr>
                    <td><label for="exampleInputEmail1">Contact No</label></td>
                    <td><input type="text" class="form-control" onkeypress="return isNumberKey(event)" maxlength="10" id="contact_no" name="contact_no" placeholder="Contact No" > </td>
                  </tr>
                  <tr>
                    <td><label for="exampleInputEmail1">Hobby</label></td>
                    <td><input type="checkbox" name="hobby[]" value="Programing" >Programing &nbsp; <input type="checkbox"  value="Games" name="hobby[]" >Games &nbsp; 
                    <input type="checkbox"  value="Reading" name="hobby[]" >Reading &nbsp; <input type="checkbox"  name="hobby[]" value="Photography"  >Photography </td>
                  </tr>
                  <tr>
                    <td><label for="exampleInputEmail1">Category*</label></td>

                    <td>
                        <select class="form-control custom-control" name="category" required><option value="">Category</option>
                        <?php
                        foreach($get_category as $key => $val)
                        {
                        ?>
                          <option value="<?php echo $val['id']?>"><?php echo $val['category_title']?></option>
                        <?php }?>
                        </select> 
                    </td>
                  </tr>
                  <tr>
                    <td><label for="exampleInputEmail1">Profile Pic</label></td>
                    <td><input type="file" class="form-control" id="photo"  name="photo"  > </td>
                  </tr>
                  <tr>
                    <td><button type="submit" class="btn btn-default">Save</button></td>
                    <td><button type="button" class="btn btn-default" onclick="Cancel();">Cancel</button></td>
                  </tr>
                </form>
      </table>
  </section>
  <section id="edit_form" style="display:none">

          <table id="" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info" >
               
                     
                      <tbody id="data_refresh">
                        <form>
                
                         <tr role="row" class="odd">
                          <td> 
                            <input type="text" class="form-control" id="employee_name" name="employee_name" placeholder="Employee Name" required>
                          </td> 
                         <td><input type="checkbox" name="bulk_select[]" value="<?php echo $data['id'] ;?>"></td> 
                         <td><input type="text" class="form-control" onkeypress="return isNumberKey(event)" maxlength="10" id="contact_no" name="contact_no" placeholder="Contact No" > </td> 
                         <td><input type="checkbox" name="hobby[]" value="Programing" >Programing &nbsp; <input type="checkbox"  value="Games" name="hobby[]" >Games &nbsp; 
                    <input type="checkbox"  value="Reading" name="hobby[]" >Reading &nbsp; <input type="checkbox"  name="hobby[]" value="Photography"  >Photography</td> 
                          <td>
                              <select class="form-control custom-control" name="category" required><option value="">Category</option>
                            <?php
                            foreach($get_category as $key => $val)
                            {
                            ?>
                              <option value="<?php echo $val['id']?>"><?php echo $val['category_title']?></option>
                            <?php }?>
                            </select>
                          </td> 
           
                         <td><img src="<?php echo base_url().'employee/'.$data['photo'] ;?>" width="100" height="100"/><input type="file" class="form-control" id="photo"  name="photo"  ></td>   
              
                         
                 
                                                    
                          <td>
                  <a href="<?php echo base_url();?>iOFRDYNBzGpVgPFgkwXWeKo/edit_employee/<?php echo $data['id'] ?>"><i class="glyphicon glyphicon-saved" title="Edit" style="cursor:pointer; margin:0px 10px;" ></i></a>
                  <a href="#"><i title="Remove" onclick="employee_delete(<?php echo $data['id'] ?>);" style="cursor:pointer; margin:0px 10px;" class="glyphicon glyphicon-remove"></i></a>
                            </td>
                            
                         </tr>
                        </form>
                      </tbody>
                      <tfoot>
                         <tr>
                            
                         </tr>
                      </tfoot>
                   </table>
  </section>
      
<script type="text/javascript">


	function employee_delete(ids)
    {
		var url = '<?php echo base_url();?>iOFRDYNBzGpVgPFgkwXWeKo/employee_delete/'+ids;
		  swal({
			  title: "Are you sure want to delete this employee ?",
			  
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: '#DD6B55',
			  confirmButtonText: 'Yes',
			  cancelButtonText: "No",
			  confirmButtonClass: "btn-danger",
			  closeOnConfirm: false,
			  //closeOnCancel: false
			},
			function(isConfirm) {
			  if (isConfirm) {
				
         $.ajax({
                  type:'POST',
                  url:url,
                  data: '',
                  success: function(data){
                    $('#msg').html('');
                      setTimeout(function() {
                       $('#message1').fadeOut();
                       
                      }, 3000 );
                      $('#msg').html(data);
                      swal( "Successfully delete employee!", "success");

                  }
          });
				
			  } else {
			   
			  }
			});
	}
  function add_employee(){
    var x = document.getElementById("employee_form");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }

  }
  function Cancel(){
    var x = document.getElementById("employee_form");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
    document.getElementById("emp_form").reset();
  }

  function bulk_delete(){
      var checkedNum = $('input[name="bulk_select[]"]:checked').length;
      if (!checkedNum) {
          swal("Please select the recorde..!");
          return false;
      }
      swal({
          title: "Are you sure want to delete this employee ?",
          //text: "No podrá recuperar el cliente una vez sea eliminado!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes',
          cancelButtonText: "No",
          confirmButtonClass: "btn-danger",
          closeOnConfirm: false,
          //closeOnCancel: false
        },
       function(isConfirm) {
            if (isConfirm) {
              var form = document.select;
              var dataString = $(form).serialize();
              $.ajax({
                  type:'POST',
                  url:'<?php echo base_url();?>iOFRDYNBzGpVgPFgkwXWeKo/bulk_employee_delete',
                  data: dataString,
                  success: function(data){
                      $('#msg').html();
                      setTimeout(function() {
                       $('#message1').fadeOut();
                       
                      }, 3000 );
                      $('#msg').html(data);
                      swal( "Successfully delete employee!", "success");

                  }
              });
              return false;
            
            
            } else {
             
            }
          });
  }
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function edit_icon(id){
    $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>iOFRDYNBzGpVgPFgkwXWeKo/get_single_emp_detaile/'+id,
            data: '1',
            success: function(data){
                $('#row_edit_'+id).html(data);
            }
    });

}


</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
function save(id){
  var formData = new FormData();
  var myCheckboxes = [];
  $('input[name="hobby_'+id+'[]"]:checked').each(function() {
    myCheckboxes.push($(this).val());
  });
  
  
  var employee_name = $("#employee_name"+id).val();
  var contact_no = $("#contact_no"+id).val();
  var photo = $('#photo'+id)[0].files[0];
  var category = $("#category"+id).val();
  var cover_image_hidden = $("#cover_image_hidden"+id).val();
  //var hobby = myCheckboxes.toString();
  formData.append("contact_no", contact_no);
  formData.append("category", category);
  formData.append("cover_image_hidden", cover_image_hidden);
  formData.append("employee_name", employee_name);
  formData.append("hobby", myCheckboxes);
  formData.append("photo", photo);

//formData.append("file", photo);

    $.ajax({
           url : '<?php echo base_url();?>iOFRDYNBzGpVgPFgkwXWeKo/edit_employee/'+id,
           type : 'POST',
           data : formData,
           dataType: "json",
           contentType: false,       // The content type used when sending data to the server.
           cache: false,             // To unable request pages to be cached
           processData:false,
           success : function(data1) {
            //alert(data1.status);
               if(data1.status=='failed'){
                swal( data1.message, "failed");
               }
               else{

                 $("#row_edit_"+id).html(data1.record);
                 swal( data1.message, "success");
               }
              
           }
    });
}
$(document).ready(function (e) {

    $("#emp_form").on('submit',(function(e) {
    e.preventDefault();

    $.ajax({
    url: "<?php echo base_url();?>iOFRDYNBzGpVgPFgkwXWeKo/add_employee", // Url to which the request is send
    type: "POST",             // Type of request to be send, called as method
    data: new FormData(this),
    dataType: "json",     // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    contentType: false,       // The content type used when sending data to the server.
    cache: false,             // To unable request pages to be cached
    processData:false,        // To send DOMDocument or non processed data file it is set to false
    success: function(data)   // A function to be called if request succeeds
    {
      if(data.status!='failed')
      {
          $('#msg').html();
          setTimeout(function() {
           $('#message1').fadeOut();
           
          }, 3000 );
          $('#msg').html(data.record);
          var x = document.getElementById("employee_form");
          if (x.style.display === "none") {
              x.style.display = "block";
          } else {
              x.style.display = "none";
          }
          document.getElementById("emp_form").reset();
      }else{
        $('#msg').html();
          setTimeout(function() {
           $('#message1').fadeOut();
           
          }, 3000 );
          $('#msg').html(data.record);
      }
      
      }
    });



}));

// Function to preview image after validation

});


</script>