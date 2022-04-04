<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('theme/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('theme/img/favicon.png')}}">
  <title>
    Dashboard
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{asset('theme/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{asset('theme/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{asset('theme/css/material-dashboard.css?v=3.0.0')}}" rel="stylesheet" />

  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
 
</head>

<body class="g-sidenav-show  bg-gray-200">
  <!-- Sidebar -->
  @include('layouts.sidebar')
  <!-- End Sidebar -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    @include('layouts.header')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
     @yield('content')
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0"> UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
  <script src="{{asset('theme/js/core/popper.min.js')}}"></script>
  <script src="{{asset('theme/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('theme/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('theme/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{asset('theme/js/plugins/chartjs.min.js')}}"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript">
    $(document).ready( function () {
   var table =   $('.data-table').DataTable({
           processing: true,
           serverSide: true,
           type: 'POST',
           ajax: "{{ route('categories.list') }}",
           columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'module', name: 'module'},
            {data: 'priority', name: 'priority'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
           ]
        });
     });
</script>
<script>
     
 $('#create_record').click(function(){
  $('.modal-title').text('Add New Record');
  //var span = document.getElementsByClassName("close")[0];
  $('#action_button').val('Add');
  $('#action').val('Add');
  $('#form_result').html('');

  $('#formModal').modal('show');
 });
    </script>
     
    <script>
      $('#sample_form').on('submit', function(event){
        event.preventDefault();
        var action_url = '';

        if($('#action').val() == 'Add')
        {
        action_url = "{{ route('categories.add') }}";
        }

        if($('#action').val() == 'Edit')
        {
        action_url = "{{ route('categories.update') }}";
        }

        var formdata = $(this).serialize();
        
       // formdata.append('image',);
        $.ajax({
        url: action_url,
        method:"POST",
        data:formdata,
        dataType:"json",
        success:function(data)
        {
          
          var html = '';
          if(data.errors)
          {
          html = '<div class="alert alert-danger">';
          for(var count = 0; count < data.errors.length; count++)
          {
            html += '<p>' + data.errors[count] + '</p>';
          }
          html += '</div>';
          }
          if(data.success)
          {
           
          html = '<div class="alert alert-success">' + data.success + '</div>';
          $('#sample_form')[0].reset();
          $('.data-table').DataTable().ajax.reload();
          $('#formModal').modal('hide');
          }
         
         
          $('#form_result').html(html);
        }
        });
      });
    </script>
  
    <script>
      $(document).on('click', '.edit', function(){
      var id = $(this).attr('id');
      $('#form_result').html('');
      $.ajax({
      url :"/categories/"+id+"/edit",
      dataType:"json",
      success:function(data)
      {
        $('#title').val(data.result.title);
        $('#descriptions').html(data.result.description);
        $('#module').val(data.result.module);
        $('#priority').val(data.result.priority);
        $('#status').val(data.result.status);
        $('#drop_product').val(id);
        $('#hidden_id').val(id);
        $('.modal-title').text('Edit Record');
        $('#action_button').val('Edit');
        $('#action').val('Edit');
        $('#formModal').modal('show');
      }
      })
    });
    </script>
    <script>
      var user_id;
      $(document).on('click', '.delete', function(){
      user_id = $(this).attr('id');
      $('#confirmModal').modal('show');
      });

      $('#okbutton').click(function(){
        $('#confirmModal').modal('hide');
      });

      $('#ok_button').click(function(){
      $.ajax({
        url:"/categories/destroy/"+user_id,
        beforeSend:function(){
        $('#ok_button').text('Deleting');
        },
        success:function(data)
        {
        setTimeout(function(){
          $('#confirmModal').modal('hide');
          $('.data-table').DataTable().ajax.reload();
        //  alert('Data Deleted');
        }, 2000);
        }
      })
      });
    </script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    
    <script type="text/javascript">
    $(document).ready( function () {
   var table =   $('.user-table').DataTable({
           processing: true,
           serverSide: true,
           type: 'POST',
           ajax: "{{ route('product.list') }}",
           columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'price', name: 'price'},
            {data: 'category_id', name: 'category_id'},
            {data: 'sku', name: 'sku'},
            {data: 'image', name: 'image',"render": function (data, type, full, meta) {
            return "<img src=\"/img/products/" + data + "\" height=\"80px\"/>"}
            },
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
           ]
        });
     });
</script>
<script>

    function imgs(){
        var action_url = '';

        if($('#action').val() == 'Add')
        {
        action_url = "{{ route('product.add') }}";
        }

        if($('#action').val() == 'Edit')
        {
        action_url = "{{ route('product.update') }}";
        }
               var formdata = $(this).serialize();
               var data1 = new FormData();
             
               data1.append('id',$('#hidden_id1').val());
               data1.append('image', $('#image')[0].files[0]);
               data1.append('title',$('#title').val());
               data1.append('description', $('#description').val());
           
               data1.append('price',$('#price').val());
               data1.append('sku',$('#sku').val());
               data1.append('image',$('#image').val());
               data1.append('status',$('#status').val());
               var checkboxes = $('input[name="category_id[]"]');
          
                  var $checked = checkboxes.filter(":checked"),
                      checkedValues = $checked.map(function () {
                          return this.value;
                      }).get();
                  data1.append('category_id',checkedValues);
               
                var images = $('#image')[0].files[0];
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
        $.ajax({
        url: action_url,
        method:"POST",
        data:data1,
        processData: false,
		    contentType: false,
        success:function(data)
        {
          var html = '';
          if(data.errors)
          {
          html = '<div class="alert alert-danger">';
          for(var count = 0; count < data.errors.length; count++)
          {
            html += '<p>' + data.errors[count] + '</p>';
          }
          html += '</div>';
          }
          if(data.success)
          {
          html = '<div class="alert alert-success">' + data.success + '</div>';
          $('#sample_form1')[0].reset();
          $('.user-table').DataTable().ajax.reload();
          $('#formModal').modal('hide');
          }
          $('#form_result1').html(html);
        }
        });
      };
    </script>
    
<script>
      $(document).on('click', '.edit', function(){
      var id = $(this).attr('id');
      $('#form_result1').html('');
      $.ajax({
      url :"/product/"+id+"/edit",
      dataType:"json",
      success:function(data)
      {
        var values= data.result.category_id;
        $.each(values.split(","), function(i,e){
       $("#category_id" + e + "").prop('checked', true);
});

var source = "{!! asset('img/products/') !!}/"+data.result.image;

           
        $('#title').val(data.result.title);
        $('#description').html(data.result.description);
        $('#status').val(data.result.status);
        $('#price').val(data.result.price);
        $('#category_id').val(data.result.category_id);
        $('#sku').val(data.result.sku);
        $('.img-status').attr('src', source); 
        $('#hidden_id1').val(id);
        $('.modal-title').text('Edit Record');
        $('#action_button').val('Edit');
        $('#action').val('Edit');
        $('#formModal').modal('show');
      }
      });
      
    });
    </script>

<script>
      var data_id;
      $(document).on('click', '.delete', function(){
      data_id = $(this).attr('id');
      $('#confirmModal').modal('show');
      });

      $('#okbutton').click(function(){
        $('#confirmModal').modal('hide');
      });

      $('#ok_button').click(function(){
      $.ajax({
        url:"/product/destroy/"+data_id,
        beforeSend:function(){
        $('#ok_button').text('Deleting');
        },
        success:function(data)
        {
        setTimeout(function(){
          $('#confirmModal').modal('hide');
          $('.user-table').DataTable().ajax.reload();
          alert('Data Deleted');
        }, 2000);
        }
      })
      });
    </script>


    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  
    <script type="text/javascript">
      $(document).ready( function () {
      var table1 =   $('.doctor-table').DataTable({
            processing: true,
            serverSide: true,
            type: 'POST',
            ajax: "{{ route('doctor.list') }}",
            columns: [
              {data: 'id', name: 'id'},
              {data: 'profile_image', name: 'profile_image',"render": function (data, type, full, meta) {
              return "<img src=\"/img/doctors/" + data + "\" height=\"80px\"/>"}
              },
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'phone_number', name: 'phone_number'},
              {data: 'dob', name: 'dob'},
              {data: 'gender', name: 'gender'},
              {data: 'qualification', name: 'qualification'},
              {data: 'speciality', name: 'speciality'},
              {data: 'address', name: 'address'}, 
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
          });
      });
</script>

<script>
    function imges(){
      
        var action_url = '';

        if($('#action').val() == 'Add')
        {
        action_url = "{{ route('doctor.add') }}";
        }

        if($('#action').val() == 'Edit')
        {
        action_url = "{{ route('doctor.update') }}";
        }
               
               var formdatas = $(this).serialize();
               var data2 = new FormData();
                
               data2.append('id',$('#hidden_id2').val());
               data2.append('profile_image', $('#profile_image')[0].files[0]);
               data2.append('name',$('#name').val());
               data2.append('email', $('#email').val());
               data2.append('phone_number',$('#phone_number').val());
               data2.append('dob',$('#dob').val());
               data2.append('gender',$('#gender').val());
               data2.append('qualification',$('#qualification').val());
               data2.append('speciality',$('#speciality').val());
               data2.append('address',$('#address').val());
               data2.append('status',$('#status').val());
               
                var imags = $('#profile_image')[0].files[0];
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax({
                url: action_url,
                method:"POST",
                data:data2,
                processData: false,
                contentType: false,
                success:function(data)
                {
                  
                  var html = '';
                  if(data.errors)
                  {
                  html = '<div class="alert alert-danger">';
                  for(var count = 0; count < data.errors.length; count++)
                  {
                    html += '<p>' + data.errors[count] + '</p>';
                  }
                  html += '</div>';
                  }
                  if(data.success)
                  {
                  html = '<div class="alert alert-success">' + data.success + '</div>';
                  $('#sample_form2')[0].reset();
                  $('.doctor-table').DataTable().ajax.reload();
                  $('#formModal').modal('hide');
                  }
                  $('#form_result2').html(html);
                }
                });
              };
            </script>

<script>
      $(document).on('click', '.edit', function(){
      var id = $(this).attr('id');
      $('#form_result2').html('');
      $.ajax({
      url :"/doctor/"+id+"/edit",
      dataType:"json",
      success:function(data)
      {
       
       var source = "{!! asset('img/doctors/') !!}/"+data.result.profile_image;

        $('#name').val(data.result.name);
        $('#email').val(data.result.email);
        $('#phone_number').val(data.result.phone_number);
        $('#gender').val(data.result.gender);
        $('#dob').val(data.result.dob);
        $('#qualification').val(data.result.qualification);
        $('#speciality').val(data.result.speciality);
        $('#address').val(data.result.address);
        $('.imgstatus').attr('src', source); 
        $('#status').val(data.result.status);
        $('#hidden_id2').val(id);
        $('.modal-title').text('Edit Record');
        $('#action_button').val('Edit');
        $('#action').val('Edit');
        $('#formModal').modal('show');
      }
      });     
    });
    </script>

<script>
      var doctor_id;
      $(document).on('click', '.delete', function(){
      ddoctor_idata_id = $(this).attr('id');
      $('#confirmModal').modal('show');
      });

      $('#okbutton').click(function(){
        $('#confirmModal').modal('hide');
      });

      $('#ok_button').click(function(){
      $.ajax({
        url:"/doctor/destroy/"+data_id,
        beforeSend:function(){
        $('#ok_button').text('Deleting');
        },
        success:function(data)
        {
        setTimeout(function(){
          $('#confirmModal').modal('hide');
          $('.doctor-table').DataTable().ajax.reload();
          alert('Data Deleted');
        }, 2000);
        }
      })
      });
    </script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    
    <script type="text/javascript">
    $(document).ready( function () {
   var table =   $('.appointment-table').DataTable({
           processing: true,
           serverSide: true,
           type: 'POST',
           ajax: "{{ route('appointment.list') }}",
           columns: [
            {data: 'id', name: 'id'},
            {data: 'customer_order_id', name: 'customer_order_id'},
            {data: 'name', name: 'name'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'appointment_date', name: 'appointment_date'},
            {data: 'appointmnet_time', name: 'appointmnet_time'},
            {data: 'discount', name: 'discount'},
            {data: 'grand_total', name: 'grand_total'},
            {data: 'payement_method_id', name: 'payement_method_id'},
            {data: 'payement_mode', name: 'payement_mode'},
            {data: 'order_date', name: 'order_date'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
           ]
        });
     });
</script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('theme/js/material-dashboard.min.js?v=3.0.0')}}"></script>
</body>

</html>
</body>
</html>