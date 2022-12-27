@extends('template.main')
@section('title', 'Halaman Barang')

@section('content')
    <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-0 text-gray-800">Halaman Profil</h1>
                    <div class="d-sm-flex align-items-center justify-content-end mb-4">
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm" id="ubahPassword"><i class="fas fa-edit"></i> Ubah Password</a>|
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="ubahProfil"><i class="fas fa-edit"></i> Ubah Data</a>
                    </div>

                    <!-- Content Row -->

                    <!-- Content Row -->

                    <form>
                        <input type="hidden" name="id" id="id" value="{{$user->id}}">
                    <div class="form-group">
                        <label for="profileName">Nama</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name" value="{{$user->name}}" disabled>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name"></div>
                    </div>
                    <div class="form-group">
                        <label for="profileName">NO HP</label>
                        <input type="number" class="form-control" id="phone" placeholder="Enter your name" value="{{$user->phone}}" disabled>                        
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-phone"></div>
                    </div>
                    <div class="form-group">
                        <label for="profileName">Alamat</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter your name" value="{{$user->address}}" disabled>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-address"></div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="save">Save Changes</button>
                    <button type="submit" class="btn btn-warning" id="cancel">Cancel</button>
                    </form>

<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{Form::open(array('url' => '/profil/change-password'))}}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="alert alert-danger d-none" id="div-validasi">
                        <ul class="list-unstyled" id="validasi">
    
  

                        </ul>
                </div>
<div class="form-group">

    <div class="row">
        <div class="col">
            <label for="password" class="control-label">Current Password</label>
        </div>
        <div class="col">
            {{Form::password('password', array('id' => 'password', 'class' => 'form-control', 'placeholder' => 'Password'))}}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col">
            <label for="new-password" class="control-label">New Password</label>
        </div>
        <div class="col">
            {{Form::password('new-password', array('id' => 'new-password', 'class' => 'form-control', 'placeholder' => 'New Password'))}}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col">
            <label for="new-password-confirmation" class="control-label">Re-enter
                Password</label>
        </div>
        <div class="col">
            {{Form::password('new-password-confirmation', array('id' => 'new-password-confirmation', 'class' => 'form-control', 'placeholder' => 'Confirm Password'))}}
        </div>
    </div>
</div>

<div class="form-group">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
    <button type="submit" class="btn btn-danger" id="btnEditPassword">Ubah Password</button>
</div>
{{Form::close()}}


            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    let id   = $('#id').val();
    $(document).ready(function () {
        $('#save').hide();
        $('#cancel').hide();
        console.log(id);
        
    }); 
    $('#ubahProfil').click(function (e) { 
        e.preventDefault();
        $('#save').show();
        $('#cancel').show();
        $("input").prop('disabled', false);
        
    });

    $('#cancel').click(function (e) { 
        e.preventDefault();
        $('#save').hide();
        $('#cancel').hide();
        $("input").prop('disabled', true);
    });

    function tampilData(){
        let id   = $('#id').val();
        $.ajax({
            type: "GET",
            url: `/profil/${id}/get`,
            dataType: "json",
            success: function (data) {
                     id = data.id;
                     name = data.name;
                     phone = data.phone;
                     address = data.address;
                     
                     $('#id').val(id);
                     $('#name').val(name);
                     $('#phone').val(phone);
                     $('#address').val(address);
                     $('#cancel').click();
               
            }
        });
    }

    $('#save').click(function(e) {
        e.preventDefault();

        //define variable
        let id   = $('#id').val();
        let name   = $('#name').val();
        let phone   = $('#phone').val();
        let address   = $('#address').val();
        let token   = $("meta[name='csrf-token']").attr("content");

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        //ajax
        $.ajax({

            url: `/profil/${id}/edit`,
            type: "PUT",
            cache: false,
            data: {
                "name": name,
                "phone": phone,
                "address": address,
                "token": token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 2000
                });
                tampilData();

            },
            error:function(error){
                console.log(error.responseJSON);
                if(error.responseJSON.name[0]) {

                    //show alert
                    $('#alert-name').removeClass('d-none');
                    $('#alert-name').addClass('d-block');

                    //add message to alert
                    $('#alert-name').html(error.responseJSON.naame[0]);
                } 

                if(error.responseJSON.phone[0]) {

                    //show alert
                    $('#alert-phone').removeClass('d-none');
                    $('#alert-phone').addClass('d-block');

                    //add message to alert
                    $('#alert-phone').html(error.responseJSON.phone[0]);
                }
                
                if(error.responseJSON.address[0]) {

                    //show alert
                    $('#alert-address').removeClass('d-none');
                    $('#alert-address').addClass('d-block');

                    //add message to alert
                    $('#alert-address').html(error.responseJSON.address[0]);
                }
            }

        });
tampilData();
    });

    $('body').on('click', '#ubahPassword', function () {
        $('#div-validasi').removeClass('d-block');
        $('#div-validasi').addClass('d-none');
        $('#validasi').html('');
        //open modal
        $('#modal-create').modal('show');
    });

    $('#btnEditPassword').click(function(e) {
        $('#div-validasi').removeClass('d-block');
        $('#div-validasi').addClass('d-none');
        $('#validasi').html('');
        e.preventDefault();

        //define variable
        let password_lama   = $('#password').val();
        let password_baru   = $('#new-password').val();
        let password_baru_konfirmasi   = $('#new-password-confirmation').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        console.log(password_baru);
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        //ajax
        $.ajax({

            url: `/profil/change-password`,
            type: "POST",
            cache: false,
            data: {
                "password": password_lama,
                "new_password": password_baru,
                "new_password_confirmation": password_baru_konfirmasi,
                
                "token": token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 2000
                });
                
                //clear form
                $('#password').val('');
                $('#new-password').val('');
                $('#new-password-confirmation').val('');

                //close modal
                $('#modal-create').modal('hide');
                

            },
            error:function(error){
                $('#div-validasi').removeClass('d-none');
                $('#div-validasi').addClass('d-block');
                $.each(error.responseJSON, function (key, valuue) { 
                     
                $('#validasi').append('<li>'+error.responseJSON[key]+'</li>')
                });

            }

        });
    });
</script>
@endsection