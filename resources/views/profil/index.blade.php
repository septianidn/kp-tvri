@extends('template.main')
@section('title', 'Halaman Barang')

@section('content')
    <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
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
</script>
@endsection