
@extends('template.main')
@section('title', 'Halaman Peminjaman')
@section('peminjaman', 'active')


@section('content')
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Halaman Pengembalian Barang</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Pengembalian Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peminjam</th>
                                            <th>Acara</th>
                                            <th>Lokasi</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal Peminjaman</th>
                                            <th>Tanggal Pengembalian</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peminjam</th>
                                            <th>Acara</th>
                                            <th>Lokasi</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal Peminjaman</th>
                                            <th>Tanggal Pengembalian</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="table-peminjaman">
                                       @foreach ($pengembalian as $pgmb)
                                       <tr id="index_{{ $pgmb->id }}">
                                        <td id="iterasi">{{$loop->iteration}}</td>
                                        <td>{{$pgmb->name}}</td>
                                        <td>{{$pgmb->acara}}</td>
                                        <td>{{$pgmb->lokasi}}</td>
                                        <td>{{$pgmb->jumlah_barang}}</td>
                                        <td>{{$pgmb->tanggal_peminjaman}}</td>
                                        <td>{{$pgmb->tanggal_pengembalian}}</td>
                                        <td>{{$pgmb->status_peminjaman}}</td>
                                        <td class="text-center">
                                            <a href="{{url('pengembalian/'.$pgmb->id.'')}}" id="btn-kembali-post" data-id="{{ $pgmb->id }}" class="btn btn-success btn-sm">Kembalikan! &emsp;<i class="fas fa-tasks"></i></a>
                                        </td>
                                       </tr>   
                                       @endforeach
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

    <!-- Modal Edit Data -->
<div class="modal fade" id="modal-kembali" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pengembalian Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="barang_id">

                <table class="table table-bordered mt-4">
                    <thead>
                    <tr><th>No</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                    </tr>
                    <tbody id="tabelDetailPengembalian">
                        
                    </tbody>
                    </thead>
                </table>
                

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
        // tampilData();
    });
var btn_add = false;
$('#add_btn').on('click', function () {
     
    var html = '';
    html += '<tr>';
    html += '<td><select name="barang[]" id="barangSelect" class="selectpicker" data-live-search="true">\
        <option value="">Pilih Barang</option>\
        @foreach($barang as $brg)\
        <option value="{{$brg->id}}">{{$brg->nama_barang}}</option>\
        @endforeach\
    </select>\
    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_barang"></div></td>';
    html += '<td><input type="number" name="qty_barang[]" id="qtySelect" class="form-control" value="1">\
        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-qty"></div></td>';
    html += '<td><button type="button" class="btn btn-danger" id="remove_btn"><i class="fas fa-minus-square"></i></button></td>';
    html += '</tr>';

    $('#addBody').append(html);
    $('select').selectpicker('refresh');
    cekNumber();
    btn_add = true;
        });

    $(document).on('click', '#remove_btn', function () {
        $(this).closest('tr').remove();
    });

function cekNumber(){
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

        $("input[type=number]").on("input", function() {
        if (/^0/.test(this.value)) {
            this.value = this.value.replace(/^0/, "" )
        }
        });
}

    //button create post event
    $('body').on('click', '#btn-create-post', function () {
        cekNumber();

        //open modal
        $('#modal-create').modal('show');
    });

    function tampilData(){
        $('#table-peminjaman').html('');
        $.ajax({
            type: "GET",
            url: "/peminjaman/get",
            dataType: "json",
            success: function (data) {
                $.each(data, function (key, value) { 
                     id = data[key].id;
                     name = data[key].name;
                     acara = data[key].acara;
                     lokasi = data[key].lokasi;
                     jumlah_barang = data[key].jumlah_barang;
                     tanggal_peminjaman = data[key].tanggal_peminjaman;
                     tanggal_pengembalian = data[key].tanggal_pengembalian;
                     status_peminjaman = data[key].status_peminjaman;
                     $('#table-peminjaman').append('<tr>\
                     <td>'+parseInt(key+1)+'</td>\
                     <td>'+name+'</td>\
                     <td>'+acara+'</td>\
                     <td>'+lokasi+'</td>\
                     <td>'+jumlah_barang+'</td>\
                     <td>'+tanggal_peminjaman+'</td>\
                     <td>'+tanggal_pengembalian+'</td>\
                     <td>'+status_peminjaman+'</td>\
                     <td class="text-center">\
                        {{-- <a href="javascript:void(0)" id="btn-edit-post" data-id='+id+'" class="btn btn-primary btn-sm">EDIT&nbsp;<i class="fas fa-edit"></i></a> --}}\
                        <a href="javascript:void(0)" id="btn-delete-post" data-id='+id+'" class="btn btn-danger btn-sm">DELETE&nbsp;<i class="fas fa-trash"></i></a>\
                        <a href="/peminjaman/detail/'+id+'" id="btn-print-post"  class="btn btn-success btn-sm">PRINT&nbsp;<i class="fas fa-print"></i></a>\
                    </td>\
                    </tr>');
                });
            }
        });
    }
function clearForm(){
    $('#acara').val('');
    $('#tanggal').val('');
    $('#lokasi').val('');
    $('select.selectpicker').val('').trigger('change');
    $('input.form-control').val('');
    if(btn_add){
        $('#addBody tr').slice(1).remove();
    }
}
    //action clear data
    $('#clear').click(function (e) { 
        e.preventDefault();
        clearForm();
    });
    //action create post
    $('#store').click(function(e) {
        $('#div-validasi').removeClass('d-block');
        $('#div-validasi').addClass('d-none');
        $('#validasi').html('');
        e.preventDefault();
        let barang = [];
        let qty = [];
        let acara = $('#acara').val();
        let lokasi = $('#lokasi').val();

        $("select[name^='barang']").each(function () {
            barang.push($(this).val());
            });

        $("input[name^='qty_barang']").each(function () {
            qty.push($(this).val());
            });
        let tanggal   = $('#tanggal').val();

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
                "tanggal": tanggal,
                "acara": acara,
                "lokasi": lokasi,
                "nama_barang": barang,
                "qty": qty,
                "jumlah": barang.length
            },
            success:function(response){
                //show success message
                console.log(response);
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 2000
                });
                
                //clear form
                clearForm();
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
 tampilData();
    });

    //kembalikan
    // $('body').on('click', '#btn-kembali-post', function () {

    //     let post_id = $(this).data('id');
    //     console.log(post_id);
    //     //fetch detail post with ajax
    //     $.ajax({
    //         url: `/pengembalian/${post_id}`,
    //         type: "GET",
    //         cache: false,
    //         success:function(data){
    //             $.each(data, function (key, value) { 
    //                  id = data[key].id;
    //                  nama_barang = data[key].nama_barang;
    //                  qty = data[key].qty;
    //                  kondisi = data[key].kondisi;
    //                  $('#tabelDetailPengembalian').append('<tr>\
    //                  <td>'+parseInt(key+1)+'</td>\
    //                  <td>'+nama_barang+'</td>\
    //                  <td>'+qty+'</td>\
    //                  <td><select name="kondisi[]" id="kondisi" class="selectpicker" data-live-search="true">\
    //                          <option value="">Pilih Kondisi</option>\
    //                          <option value="Baik">Baik</option>\
    //                          <option value="Rusak">Rusak</option>\
    //                          <option value="Hilang">Hilang</option>\
    //                 </select>\
    //                     </td>\
    //                 </tr>');
    //             });
    //             $('#modal-kembali').modal('show');
    //         }
    //     });
    // });


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

                    url: `/peminjaman/${post_id}/delete`,
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


    