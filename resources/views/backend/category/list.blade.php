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
         <span id="form_result"></span>
         <form id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label class="control-label col-md-8" >Title</label>
            <div class="col-md-12">
             <input type="text" name="title" id="title" class="form-control" />
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-8">Description</label>
            <div class="col-md-12">
                <textarea rows="25" cols="25" name="description" id="descriptions" class="form-control"></textarea>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-8" >Module</label>
            <div class="col-md-12">
             <input type="text" name="module" id="module" class="form-control" />
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-8" >Priority</label>
            <div class="col-md-12">
            <select class="form-select" name="priority" id="priority">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            </select>
            </div>
           </div>
    
           <!--  <div class="form-group">
            <label class="control-label col-md-8" >Image</label>
            <div class="col-md-12">
         <input type="file" class="form-control-file" name="image" id="image"> 
            </div>
           </div>
 -->
           
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
                 <input type="hidden" name="hidden_id" id="hidden_id" />
                 <button id="btnSave" type="submit" class="btn btn-success" data-dismiss="modal"><i class="glyphicon glyphicon-trash"></i>Add</button>
            <!--      <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" data-dismiss="modal"/> -->
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
    <h3>Category Management</h3>
    <table class="table table-bordered data-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>Module</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

@endsection

