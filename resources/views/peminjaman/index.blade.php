
@extends('template.main')
@section('title', 'Halaman Peminjaman')
@section('barang', 'active')


@section('content')
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Halaman Peminjaman Barang</h1>

                    <div class="col-lg-8">
                        <a href="javascript:void(0)" class="btn btn-success mb-2" id="btn-create-post">Tambah +</a>
                        <div id="read" class="mt-3">

                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Peminjaman</th>
                                            <th>Tanggal Peminjaman</th>
                                            <th>Tanggal Pengembalian</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Peminjaman</th>
                                            <th>Tanggal Peminjaman</th>
                                            <th>Tanggal Pengembalian</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="table-barang">
                                       {{-- @foreach ($barang as $brg)
                                       <tr id="index_{{ $brg->id }}">
                                        <td id="iterasi">{{$loop->iteration}}</td>
                                        <td>{{$brg->nama_barang}}</td>
                                        <td>{{$brg->jenis}}</td>
                                        <td>{{$brg->merk}}</td>
                                        <td>{{$brg->qty}}</td>
                                        <td class="text-center">
                                        <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $brg->id }}" class="btn btn-primary btn-sm">EDIT&nbsp;<i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" id="btn-delete-post" data-id="{{ $brg->id }}" class="btn btn-danger btn-sm">DELETE&nbsp;<i class="fas fa-trash"></i></i></a>
                                        </td>
                                       </tr>   
                                       @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Data -->
    
    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('peminjaman/store')}}" method="POST">
                @csrf
                
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                    <tbody id="addBody">
                        <tr>
                            <td><select name="barang[]" id="barangSelect" class="selectpicker" data-live-search="true">
                                <option value="">Pilih Barang</option>
                                @foreach ($barang as $brg)
                                    <option value="{{$brg->id}}">{{$brg->nama_barang}}</option>
                                @endforeach
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_barang"></div>
                            </td>
                            <td><input type="number" name="qty_barang[]" id="qtySelect" class="form-control">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-qty"></div>
                            </td>
                            <td><button type="button" class="btn btn-primary" id="add_btn"><i class="fas fa-plus-square"></i></button></td>
                        </tr>
                    </tbody>
                    </thead>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="submit" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Edit Data -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="barang_id">

                <div class="form-group">
                    <label for="barang_edit" class="control-label">Nama Barang</label>
                    <input type="text" class="form-control" id="barang_edit" name="barang_edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-barang-edit"></div>
                </div>

                <div class="form-group">
                    <label for="jenis_edit" class="control-label">Jenis</label>
                    <input type="text" class="form-control" id="jenis_edit" name="jenis_edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jenis-edit"></div>
                </div>

                <div class="form-group">
                    <label for="merk_edit" class="control-label">Merk</label>
                    <input type="text" class="form-control" id="merk_edit" name="merk_edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-merk-edit"></div>
                </div>

                <div class="form-group">
                    <label for="qty_edit" class="control-label">Jumlah</label>
                    <input type="number" class="form-control" id="qty_edit" name="qty_edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-qty-edit"></div>
                </div>
                

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="update">UPDATE</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    $(document).ready(function () {
        $('select').selectpicker();
    });


$('#add_btn').on('click', function () {
     
    var html = '';
    html += '<tr>';
    html += '<td><select name="barang[]" id="barangSelect" class="selectpicker" data-live-search="true">\
        <option value="">Pilih Barang</option>\
        @foreach($barang as $brg)\
        <option value="{{$brg->id}}">{{$brg->nama_barang}}</option>\
        @endforeach\
    </select></td>';
    html += '<td><input type="number" name="qty_barang[]" id="qtySelect" class="form-control"></td>';
    html += '<td><button type="button" class="btn btn-danger" id="remove_btn"><i class="fas fa-minus-square"></i></button></td>';
    html += '</tr>';

    $('#addBody').append(html);
    $('select').selectpicker('refresh');
        });

    $(document).on('click', '#remove_btn', function () {
        $(this).closest('tr').remove();
    });


    


var invalidChars = [
  "-",
  "+",
  "e",
];

$('input[type=number]').on('keydown', function (e) {
     if (invalidChars.includes(e.key)) {
    e.preventDefault();
  }
});
    //button create post event
    $('body').on('click', '#btn-create-post', function () {

        //open modal
        $('#modal-create').modal('show');
    });

    function tampilData(){
        $('tbody').html('');
        $.ajax({
            type: "GET",
            url: "/barang/get",
            dataType: "json",
            success: function (data) {
                $.each(data, function (key, value) { 
                     id = data[key].id;
                     nama_barang = data[key].nama_barang;
                     jenis = data[key].jenis;
                     merk = data[key].merk;
                     qty = data[key].qty;
                     $('tbody').append('<tr>\
                     <td>'+parseInt(key+1)+'</td>\
                     <td>'+nama_barang+'</td>\
                     <td>'+jenis+'</td>\
                     <td>'+merk+'</td>\
                     <td>'+qty+'</td>\
                     <td class="text-center">\
                        <a href="javascript:void(0)" id="btn-edit-post" data-id='+id+'" class="btn btn-primary btn-sm">EDIT&nbsp;<i class="fas fa-edit"></i></a>\
                        <a href="javascript:void(0)" id="btn-delete-post" data-id='+id+'" class="btn btn-danger btn-sm">DELETE&nbsp;<i class="fas fa-trash"></i></i></a>\
                    </td>\
                    </tr>');
                });
            }
        });
    }

    //action create post
    $('#store').click(function(e) {
        e.preventDefault();
        let barang = [];
        let qty = [];

        $("select[name^='barang']").each(function () {
            barang.push($(this).val());
            });

        $("input[name^='qty_barang']").each(function () {
            qty.push($(this).val());
            });

            
                console.log(barang, qty);

        //define variable
//         let nama_barang   = $('#nama_barang').val();
//         let jenis   = $('#jenis').val();
//         let merk   = $('#merk').val();
//         let qty   = $('#qty').val();
//         let token   = $("meta[name='csrf-token']").attr("content");

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        //ajax
        $.ajax({

            url: `/peminjaman/store`,
            type: "POST",
            cache: false,
            data: {
                "nama_barang": barang,
                "qty": qty
            },
            success:function(response){
                //show success message
                console.log(response);
                // Swal.fire({
                //     type: 'success',
                //     icon: 'success',
                //     title: `${response.message}`,
                //     showConfirmButton: false,
                //     timer: 2000
                // });
                

                //data post
                // let iterasi = $("table[id='dataTable'] > tbody >tr").length
                // let post = `
                //     <tr id="index_${response.data.id}">
                //         <td>${iterasi + 1}</td>
                //         <td>${response.data.nama_barang}</td>
                //         <td>${response.data.jenis}</td>
                //         <td>${response.data.merk}</td>
                //         <td>${response.data.qty}</td>
                //         <td class="text-center">
                //             <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                //             <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                //         </td>
                //     </tr>
                // `;
                
                //append to table
                // $('#table-barang').append(post);
                
                //clear form
                $('#barangSelect').val('');
                $('#qtySelect').val('');

                //close modal
                $('#modal-create').modal('hide');
                

            },
            error:function(error){
                console.log(error.responseJSON.nama_barang[0]);
                if(error.responseJSON.nama_barang[0]) {

                    //show alert
                    $('#alert-nama_barang').removeClass('d-none');
                    $('#alert-nama_barang').addClass('d-block');

                    //add message to alert
                    $('#alert-nama_barang').html(error.responseJSON.nama_barang[0]);
                } 
                if(error.responseJSON.qty[0]) {

                    //show alert
                    $('#alert-qty').removeClass('d-none');
                    $('#alert-qty').addClass('d-block');

                    //add message to alert
                    $('#alert-qty').html(error.responseJSON.qty[0]);
                }

            }

        });
// tampilData();
    });


    //edit data

    $('body').on('click', '#btn-edit-post', function () {

        let post_id = $(this).data('id');

        //fetch detail post with ajax
        $.ajax({
            url: `/barang/${post_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#barang_id').val(response.data.id);
                $('#barang_edit').val(response.data.nama_barang);
                $('#jenis_edit').val(response.data.jenis);
                $('#merk_edit').val(response.data.merk);
                $('#qty_edit').val(response.data.qty);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update barang
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let post_id = $('#barang_id').val();
        let barang   = $('#barang_edit').val();
        let jenis = $('#jenis_edit').val();
        let merk = $('#merk_edit').val();
        let qty = $('#qty_edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        //ajax
        $.ajax({

            url: `/barang/${post_id}/edit`,
            type: "PUT",
            cache: false,
            data: {
                "nama_barang": barang,
                "jenis": jenis,
                "merk": merk,
                "qty": qty,
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

                //data post
                // let post = `
                //     <tr id="index_${response.data.id}">
                //         <td>${response.data.title}</td>
                //         <td>${response.data.content}</td>
                //         <td class="text-center">
                //             <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                //             <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                //         </td>
                //     </tr>
                // // `;
                
                // //append to post data
                // $(`#index_${response.data.id}`).replaceWith(post);

                //close modal
                $('#modal-edit').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.nama_barang[0]) {

                    //show alert
                    $('#alert-barang-edit').removeClass('d-none');
                    $('#alert-barang-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-barang-edit').html(error.responseJSON.nama_barang[0]);
                } 

                if(error.responseJSON.jenis[0]) {

                    //show alert
                    $('#alert-jenis-edit').removeClass('d-none');
                    $('#alert-jenis-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-jenis-edit').html(error.responseJSON.jenis[0]);
                }
                
                if(error.responseJSON.merk[0]) {

                    //show alert
                    $('#alert-merk-edit').removeClass('d-none');
                    $('#alert-merk-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-merk-edit').html(error.responseJSON.merk[0]);
                }
                
                if(error.responseJSON.qty[0]) {

                    //show alert
                    $('#alert-qty-edit').removeClass('d-none');
                    $('#alert-qty-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-qty-edit').html(error.responseJSON.qty[0]);
                }

            }

        });
        tampilData();
    });


    //hapus data

    $('body').on('click', '#btn-delete-post', function () {

        let post_id = $(this).data('id');
        let token   = $("meta[name='csrf-token']").attr("content");

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {

                //fetch to delete data
                $.ajax({

                    url: `/barang/${post_id}/delete`,
                    type: "DELETE",
                    cache: false,
                    data: {
                        "_token": token
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

                        
                    }
                    
                });
                tampilData();

                
            }
        })
        
    });

</script>
@endsection


    