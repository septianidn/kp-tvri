@extends('template.main')
@section('title', 'Halaman Barang')
@section('dashboard', 'active')

@section('headeScript')
    <script>
        if(performance.navigation.type == 2){

            location.reload(true);
        }
    </script>
@endsection

@section('content')
    <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Halaman Pengembalian Barang</h1>
                    </div>


                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Tabel Pengembalian</h6>
                                    
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    @if (!$pengembalian->isEmpty())
                                    <div class="table-responsive">
            <form action="{{route('pengembalian/store')}}" method="POST">
                @csrf
                <div class="alert alert-danger d-none" id="div-validasi">
                        <ul class="list-unstyled" id="validasi">
    
  

                        </ul>
                </div>
                
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker" inline="true">
                    
                    <input type="hidden" id="tid" class="form-control" value="{{$pengembalian[0]->tid}}">
                    
                    <label for="example">Tanggal Pengembalian</label>
                    <i class="fas fa-calendar input-prefix"></i>
                    <input type="text" id="tanggal" class="form-control" value="{{$pengembalian[0]->tanggal_pengembalian}}" readonly>
                    <input type="text" name="acara" id="acara" placeholder="Acara" class="form-control mt-4" value="{{$pengembalian[0]->lokasi}}" readonly>
                    <input type="text" name="lokasi" id="lokasi" placeholder="Lokasi" class="form-control mt-4" value="{{$pengembalian[0]->acara}}" readonly>
                </div>
                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Jumlah Rusak atau Hilang</th>
                    </tr>
                    <tbody id="addBody">
                        @foreach ($pengembalian as $p)
                        <tr>
                            <td>
                            <input type="hidden" value="{{$p->bid}}" class="form-control" disabled readonly name="idBarang[]" id="idBarang">
                            <input type="text" value="{{$p->nama_barang}}" class="form-control" disabled readonly name="nama_barang[]" id="nama_barang">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_barang"></div>
                            </td>
                            <td><input type="number" name="qty_barang[]" id="qtySelect" class="form-control" value="{{$p->jumlah}}" readonly disabled>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-qty"></div>
                            </td>
                            <td>
                                <select name="kondisi[]" id="kondisi{{$p->bid}}" data-id="{{$p->bid}}" class="form-control">
                                    <option value="Baik">Pilih Kondisi</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak / Hilang">Rusak / Hilang</option> 
                                </select>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kondisi"></div>
                            </td>
                             <td>
                            <input type="number" name="qty_rusak[]" id="qty_rusak{{$p->bid}}" class="form-control" disabled placeholder="Jumlah Rusak..." min="0" value="0">
                             <input type="number" name="qty_hilang[]" id="qty_hilang{{$p->bid}}" class="form-control" disabled placeholder="Jumlah Hilang..." min="0" value="0">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-qty"></div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="submit" id="store">Kembalikan Barang</button> 
    </form>
    @endif
                            </div>
                        </div>

                    </div>
@endsection

@section('script')
<script>
    window.onpageshow = function(event){
        if(event.persisted){
            window.location.reload(true);
        }
    }
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
    $(document).ready(function () {
        $('select').selectpicker();
        $('#dataTable_info').remove();
    });

    $('select[name^="kondisi"]').change(function (e) { 
        e.preventDefault();
        let temp_id = $(this).data('id');
        console.log(temp_id);
        if($("#kondisi"+temp_id).val() == "Rusak / Hilang"){
        $("#qty_rusak"+temp_id).prop('disabled', false);
        $("#qty_hilang"+temp_id).prop('disabled', false);
        }else{
        $("#qty_rusak"+temp_id).prop('disabled', true);
        $("#qty_rusak"+temp_id).val(0);
        $("#qty_hilang"+temp_id).prop('disabled', true);
        $("#qty_hilang"+temp_id).val(0);
        }
        
    });

    $('#store').click(function(e) {
        $('#div-validasi').removeClass('d-block');
        $('#div-validasi').addClass('d-none');
        $('#validasi').html('');
        e.preventDefault();
        let tid = $('#tid').val();
        let id_barang = [];
        let qty = [];
        let rusak = [];
        let hilang = [];
        let kondisi = [];

        $("input[name^='idBarang']").each(function () {
            id_barang.push($(this).val());
            });

        $("input[name^='qty_barang']").each(function () {
            qty.push($(this).val());
            });
        $("input[name^='qty_rusak']").each(function () {
            rusak.push($(this).val());
            });
        $("input[name^='qty_hilang']").each(function () {
            hilang.push($(this).val());
            });
        $("select[name^='kondisi']").each(function () {
            kondisi.push($(this).val());
            });

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        //ajax
        $.ajax({

            url: `/pengembalian/store`,
            type: "POST",
            cache: false,
            data: {
                "transaksi_id": tid,
                "id_barang": id_barang,
                "qty": qty,
                "rusak": rusak,
                "hilang": hilang,
                "kondisi": kondisi
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
                
                $(location).attr("href", "/peminjaman");
                //clear form
                //close modal

            },
            error:function(error){
                $('#alert-validasi').removeClass('d-none');
                $('#div-validasi').addClass('d-block');
                $.each(error.responseJSON, function (key, valuue) { 
                     
                $('#validasi').append('<li>'+error.responseJSON[key]+'</li>')
                });

            }

        });
    });
</script>
@endsection