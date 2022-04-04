@extends('layouts.master')
@section('content')

<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" onclick="closeDialog(this)">&times;</span>
        </button>
          <h4 class="modal-title">Add New Record</h4>
        </div>
        <div class="modal-body">
         <span id="form_result1"></span>
         <form id="sample_form1" class="form-horizontal" action="javascript:void(0);" onsubmit="imgs();" enctype="multipart/form-data">
         
          <div class="form-group">
            <label class="control-label col-md-8" >Title</label>
            <div class="col-md-12">
             <input type="text" name="title" id="title" class="form-control" />
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-8">Description</label>
            <div class="col-md-12">
                <textarea rows="25" cols="25" name="description" id="description" class="form-control"></textarea>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-8" >Price</label>
            <div class="col-md-12">
             <input type="number" name="price" id="price" class="form-control" />
            </div>
           </div>

          
           <div class="form-group">
            <label class="control-label col-md-8" >Category_id</label>
            <div class="col-md-12">
            @foreach($product as $products)
            <input type="checkbox" class="category_id" id="category_id{{$products->id}}" name="category_id[]" value="{{$products->id}}">
            <label for="{{$products->title}}">{{$products->title}}</label><br>
           @endforeach
            </div>
           </div>
              
           
           <div class="form-group">
            <label class="control-label col-md-8" >sku</label>
            <div class="col-md-12">
             <input type="number" name="sku" id="sku" class="form-control" value="<?php echo $number = mt_rand(1000000000000, 9999999999999); ?>" readonly/>
            </div>
           </div>

           <div class="form-group">
           <label class="control-label col-md-8">Choose Images</label>
           <div class="col-md-12">
           <input type="file"  name="image" id="image" oninput="previewimages.src=window.URL.createObjectURL(this.files[0])">
           <img class="img-status" id="previewimages" src="{{URL::to('/')}}/img/products/" height="100px" width="100px">
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
                 <input type="hidden" name="hidden_id1" id="hidden_id1" value="" />
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
    <h3>Product Management</h3>
    <table class="table table-bordered user-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Category_id</th>
            <th>Sku</th>
            <th>Image</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


@endsection
