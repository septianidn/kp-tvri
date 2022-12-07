
@extends('template.main')
@section('title', 'Halaman Peminjaman')
@section('barang', 'active')


@section('content')
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Halaman History Peminjaman Barang</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel History Peminjaman</h6>
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
                                            @if (auth()->user()->role == "Admin")
                                            <th>Aksi</th>
                                            @endif
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
                                        </tr>
                                    </tfoot>
                                    <tbody id="table-peminjaman">
                                       @foreach ($peminjaman as $pjm)
                                       <tr id="index_{{ $pjm->id }}">
                                        <td id="iterasi">{{$loop->iteration}}</td>
                                        <td>{{$pjm->name}}</td>
                                        <td>{{$pjm->acara}}</td>
                                        <td>{{$pjm->lokasi}}</td>
                                        <td>{{$pjm->jumlah_barang}}</td>
                                        <td>{{$pjm->tanggal_peminjaman}}</td>
                                        <td>{{$pjm->tanggal_pengembalian}}</td>
                                        <td>{{$pjm->status_peminjaman}}</td>
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



@endsection

@section('script')

<script>
    $(document).ready(function () {
        $('select').selectpicker();
    });

</script>
@endsection


    