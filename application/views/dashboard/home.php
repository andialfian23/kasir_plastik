<div class="card card-primary card-outline shadow">
    <div class="card-header">
        <h3 class="card-title">
            SELAMAT DATANG DI APLIKASI KASIR PD. Mandiri Plastik
        </h3>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card card-info card-outline shadow">
                    <div class="card-header">Data Barang</div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-sm" width="100%" id="barang">
                            <thead class="bg-gradient-info">
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>--</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card card-danger card-outline shadow">
                    <div class="card-header">Keranjang Belanja</div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-sm" width="100%" id="tbl_keranjang">
                            <thead class="bg-gradient-danger">
                                <tr>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-center">Jml</th>
                                    <th class="text-center">Total Harga</th>
                                    <th class="text-center">--</th>
                                </tr>
                            </thead>
                            <tbody id="keranjang"></tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center" colspan="3">Total</th>
                                    <th class="text-center"></th>
                                    <th class="text-right"></th>
                                    <th class="text-center">--</th>
                                </tr>
                                <tr class="tr-input-bayar-user">
                                    <th colspan="6">
                                        <div class="row">
                                            <label for="bayar" class="col-sm-6 col-form-label text-right">
                                                Bayar</label>
                                            <div class="col-sm-6">
                                                <input type="number" name="bayar" class="form-control form-control-sm"
                                                    id="bayar" />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="kembali" class="col-sm-6 col-form-label text-right">
                                                Kembalian</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm" id="kembali"
                                                    disabled />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="nama_pembeli" class="col-sm-6 col-form-label text-right">
                                                Nama Pembeli</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="nama_pembeli"
                                                    class="form-control form-control-sm" id="nama_pembeli" />
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="tr-btn-save-nota">
                                    <th colspan="6">
                                        <button type="submit" class="btn btn-primary btn-block" id="btn-save-nota">
                                            Simpan & Cetak Nota
                                        </button>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "modal_cek.php"; ?>