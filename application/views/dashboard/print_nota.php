<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PRINT NOTA</title>
    <!-- jQuery -->
    <script src="AdminLTE_3/plugins/jquery/jquery.min.js"></script>
    <style>
    * {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 14px;
        /* font-weight: bold; */
    }

    .luar {
        position: relative;
    }

    .panjang {
        position: absolute;
        width: 250px;
        padding-top: 2px;
        padding-left: 2px;
        padding-right: 2px;
    }

    table {
        width: 100%;
    }

    .panjang table td {
        padding: 2px;
    }

    th {
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="luar">
        <div class="panjang">
            <div>

                <p align='center'><b>PD. Mandiri Plastik</b><br>Blok Kliwon Desa Jayi - Sukahaji
                    <br /> Majalengka - Jawa Barat
                    <br />
                    HP. 081 322 769 366 <br /> HP. 085 220 274 881
                </p>
                <hr>
                <p>

                    <b id="txt_id_nota"><?= $nota->id_nota ?></b> <br />
                    <b id="txt_pembeli"><?= $nota->nama_pembeli ?></b> <br />
                    <b id="txt_tanggal"><?= date('d M Y',strtotime($nota->tgl_keluar)) ?></b> <br />
                </p>
                <hr>
                <table class="table" cellspacing="0" id='barang'>
                    <?= $item_nota ?>
                </table>
                <hr>
                <table>
                    <tr>
                        <td>Total : </td>
                        <td align="right" id="txt_total"><?= number_format($nota->total) ?></td>
                    </tr>
                    <tr>
                        <td>Bayar :</td>
                        <td align="right" id="txt_bayar"><?= number_format($nota->bayar) ?></td>
                    </tr>
                    <tr>
                        <td>Kembali : </td>
                        <td align="right" id="txt_kembali"><?= number_format($nota->kembalian) ?></td>
                    </tr>
                </table>
                <p align='center'>TERIMA KASIH SUDAH BERBELANJA</p>
                <HR>
            </div>
        </div>
    </div>

    <script>
    window.print();
    </script>
</body>

</html>