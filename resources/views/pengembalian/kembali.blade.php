@extends('template.main')
@section('title', 'Halaman Barang')
@section('dashboard', 'active')

@section('content')
    <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Halaman Pengembalian Barang</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>


                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                   
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
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
                                <select name="kondisi[]" id="kondisi">
                                    <option value="">Pilih Kondisi</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Hilang">Hilang</option>
                                    <option value="Diganti">Diganti</option>
                                </select>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kondisi"></div>
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
                            </div>
                        </div>

                    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('select').selectpicker();
        $('#dataTable_info').remove();
    });
    $('#store').click(function(e) {
        $('#div-validasi').removeClass('d-block');
        $('#div-validasi').addClass('d-none');
        $('#validasi').html('');
        e.preventDefault();
        let tid = $('#tid').val();
        let id_barang = [];
        let qty = [];
        let kondisi = [];

        $("input[name^='idBarang']").each(function () {
            id_barang.push($(this).val());
            });

        $("input[name^='qty_barang']").each(function () {
            qty.push($(this).val());
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
                $(location).attr("href", "pengembalian");
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