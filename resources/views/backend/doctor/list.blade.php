@extends('layouts.master')
@section('content')


<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
        </button>
          <h4 class="modal-title">Add New Record</h4>
        </div>
        <div class="modal-body">
         <span id="form_result2"></span>
         <form id="sample_form2" class="form-horizontal" action="javascript:void(0);" onsubmit="imges();" enctype="multipart/form-data">
         
          <div class="form-group">
            <label class="control-label col-md-8" >Name</label>
            <div class="col-md-12">
             <input type="text" name="name" id="name" class="form-control" />
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-8">Email</label>
            <div class="col-md-12">
            <input type="text" name="email" id="email" class="form-control" />
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-8" >Mobile</label>
            <div class="col-md-12">
             <input type="number" name="phone_number" id="phone_number" class="form-control" />
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-8" >Qualification</label>
            <div class="col-md-12">
             <input type="text" name="qualification" id="qualification" class="form-control" />
            </div>
           </div>
          
           <div class="form-group">
            <label class="control-label col-md-8" >DOB</label>
            <div class="col-md-12">
             <input type="date" name="dob" id="dob" class="form-control" />
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-8" >Speciality</label>
            <div class="col-md-12">
            <select class="form-select" name="speciality" id="speciality">
            <option>Ophthalmologists</option>
            <option>Pediatrics</option>
            <option>Cardiologists</option>
            <option>Orthopedics</option>
            <option>Critical Care Medicine Specialists</option>
            <option>Dermatologists</option>
            <option>Endocrinologists</option>
            <option>Emergency Medicine Specialists</option>
            <option>Family Physicians</option>
            <option>Gastroenterologists</option>
            <option>Neurologists</option>
            <option>Hematologists</option>
            <option>Infectious Disease Specialists</option>
            <option>Nephrologists</option>
            <option>Obstetricians and Gynecologists</option>
            <option>Oncologists</option>
            </select>
            </div>
           </div>
              
           <div class="form-group">
            <label class="control-label col-md-8" >Gender</label>
            <div class="col-md-12">
            <select class="form-select" name="gender" id="gender">
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
            </select>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-8">Address</label>
            <div class="col-md-12">
                <textarea rows="5" cols="5" name="address" id="address" class="form-control"></textarea>
            </div>
           </div>

           <div class="form-group">
           <label class="control-label col-md-8">Choose Images</label>
           <div class="col-md-12">
           <input type="file"  name="profile_image" id="profile_image" oninput="previewimage.src=window.URL.createObjectURL(this.files[0])">
           <img class="imgstatus" id="previewimage" src="{{URL::to('/')}}/img/doctors/" height="100px" width="100px">
           </div>
           </div>
          

           <div class="form-group">
            <label class="control-label col-md-8" >Status</label>
            <div class="col-md-12">
            <select class="form-select" name="status" id="status">
            <option>Active</option>
            <option>Inactive</option>
            </select>
            </div>
           </div>
                <br />
                <div class="form-group" align="center">
                 <input type="hidden" name="action" id="action" value="Add" />
                 <input type="hidden" name="hidden_id2" id="hidden_id2" value="" />
                 <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                </div>
         </form>
        </div>
     </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Do You Want to remove this data?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" id="okbutton" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
<div class="row">
<div align="right">
      <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Record</button>
     </div>
    <h3>Doctor Management</h3>
    <table class="table table-bordered doctor-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Profile Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Dob</th>
            <th>Gender</th>
            <th>Qualification</th>
            <th>Speciality</th>
            <th>Address</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

@endsection
