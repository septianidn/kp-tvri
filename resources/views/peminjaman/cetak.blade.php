@php
    setlocale(LC_ALL, 'id-ID', 'id_ID');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table.static{
            position: relative;
            border: 1px solid #543535;
            text-align: center;
        }
        .sisa{
            height: 20px;
        }
        .ttd { 
            display: grid;
            grid-template-columns: auto auto;
         }
    </style>
</head>
<body>
    <div class="form-group">
        <p align="center" style="font-size: 30px;"><b>Tanda Terima Penggunaan Peralatan</b></p>
        <p align="center" style="font-size: 30px;"><b>Produksi Luar Studio</b></p>
    </div>
    <div class="kop">
        <table style="margin-left: 60px; margin-bottom: 40px;">
            <tr>
                <td>Acara &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;: {{$peminjaman[0]['acara']}}</td>
            </tr>
            <tr>
                <td>Hari/Tanggal Produksi &nbsp;: {{strftime("%A, %d %B %Y", strtotime($peminjaman[0]['tanggal_peminjaman'])) . "\n"}}</td>
            </tr>
            <tr>
                <td>Lokasi &ensp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;: {{$peminjaman[0]['lokasi']}} </td>
            </tr>
        </table>
    </div>
    <div class="konten">
        <table align="center" border="1px" width="83%" class="static" rules="all">
            <tr>
                <th>NO</th>
                <th>Peralatan</th>
                <th>Merk/Tipe/SN</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
            @foreach ($peminjaman as $pjm)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$pjm->nama_barang}}</td>
                    <td>{{$pjm->merk}}</td>
                    <td>{{$pjm->jumlah}}</td>
                    <td>{{$pjm->keterangan}}</td>
                </tr>
            @endforeach
            @for($i=count($peminjaman); $i<20; $i++)
                <tr class="sisa">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </table>
    </div>
    <div class="lower">
        <table style="margin-left: 60px; margin-top: 40px;">
            <tr>
                <td>Diterima Kembali &emsp;: {{strftime("%A, %d %B %Y", strtotime($peminjaman[0]['tanggal_pengembalian'])) . "\n"}}</td>
            </tr>
            <tr>
                <td>Keterangan &ensp;&emsp;&emsp;&emsp;: {{$peminjaman[0]['keterangan']}}</td>
            </tr>
        </table>
    </div>
    <div class="ttd" style="margin-left: 20px; margin-top: 70px;">
        <div>
            <p align="center">TD/Penerima/Penanggung Jawab <br>Peralatan Lapangan</p>
        </div>
        <div>
            <p align="center">Penanggung Jawab <br>Peralatan Teknik Produksi dan Penyiaran</p>
        </div>
    </div>
    <div class="ttd" style="margin-left: 10px; margin-top: 50px;">
        <div>
            <p align="center">( {{$peminjaman[0]["name"]}} )</p>
        </div>
        <div>
            <p align="center">Devi Hendri<br>PNIP. 196504201989031004</p>
        </div>
    </div>
</body>
</html>
<script>
    window.onload = function(){
    window.print();  
};
</script>