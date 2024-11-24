<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PRINT NOTA</title>
    <style>
    * {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 14px;
        /* font-weight: bold; */
    }

    .luar {
        position: relative;
        /* background-color: aliceblue; */
        width: 750px;
    }

    .header,
    .footer {
        width: 100%;
        position: relative;
        display: flex;
    }

    .h-kiri {
        /* position: absolute; */
        width: 50%;
        /* display: block; */
        left: 0px;
        padding-left: 5%;
    }

    .h-kanan {
        width: 50%;
        /* display: block; */
        /* position: absolute; */
        right: 0px;
    }

    .f-kiri {
        /* position: absolute; */
        width: 70%;
        /* display: block; */
        left: 0px;
        padding-left: 5%;
    }

    .f-kanan {
        width: 30%;
        /* display: block; */
        /* position: absolute; */
        right: 0px;
        padding-right: 5%;
    }

    .panjang {
        padding-top: 2px;
        padding-left: 2px;
        padding-right: 2px;
    }

    table {
        width: 90%;
        margin-left: auto;
        margin-right: auto;
        border-collapse: collapse;
    }

    .panjang table td {
        padding: 2px;
    }

    th {
        text-align: center;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }
    </style>
</head>

<body>
    <div class="luar">
        <div class="header">
            <div class="h-kiri">
                <p>
                    <b>PD. Mandiri Plastik</b><br>Blok Kliwon Desa Jayi - Sukahaji
                    <br /> Majalengka - Jawa Barat
                    <br /> HP. 081 322 769 366
                    <br /> HP. 085 220 274 881
                </p>
            </div>
            <div class="h-kanan">
                <p>

                    <font id="txt_id_nota"><?= $nota->id_nota ?></font> <br />
                    <font id="txt_pembeli"><?= $nota->nama_pembeli ?></font> <br />
                    <font id="txt_tanggal"><?= date('d M Y',strtotime($nota->tgl_keluar)) ?></font> <br />
                </p>
            </div>
        </div>
        <div class="panjang">
            <div>
                <br />
                <table class="table" cellspacing="0" border="1">

                    <thead>
                        <tr>
                            <th>No</th>
                            <!-- <th>ID Barang</th> -->
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id='barang'>
                        <?= $item ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" align="right">Total : </td>
                            <td align="right" id="txt_total"><?= number_format($nota->total) ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right">Bayar :</td>
                            <td align="right" id="txt_bayar"><?= number_format($nota->bayar) ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right">Kembali : </td>
                            <td align="right" id="txt_kembali"><?= number_format($nota->kembalian) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="footer">
            <div class="f-kiri">
                <br />
                <br />
                <b>TERIMA KASIH SUDAH BERBELANJA</b>
            </div>
            <div class="f-kanan">
                <br />
                <p>
                    <b>Kasir</b>
                    <br />
                    <br />
                    <br />
                    <br />
                    <hr />
                    <?= $_SESSION['title'] ?>
                </p>
            </div>
        </div>
    </div>

    <script>
    window.print();
    </script>
</body>

</html>