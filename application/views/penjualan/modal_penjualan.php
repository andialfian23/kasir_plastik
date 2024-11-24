<div class="modal fade " id="preview">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header p-2 bg-success">

                <b class='h_id_nota'></b>

                <button type="button" class="btn btn-close btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body overflow-auto" id='nota'>

                <table width="100%" cellspacing='0' class="table table-sm table-bordered table-striped w100">
                    <thead>
                        <tr>
                            <th class="text-center">ID Barang</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody id="data_penjualan"></tbody>
                </table>

            </div>
            <div class="modal-footer">
                <a href="#" target="_blank" id="btn_print_nota" class="btn btn-primary">Print Nota
                    (kecil)</a>
                <a href="#" target="_blank" id="btn_print_faktur" class="btn btn-primary">Print Nota
                    (besar)</a>
                <button type="button" class="btn btn-danger bg-gradient-danger ml-auto "
                    data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade " id="modal-edit-nota">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header py-2 bg-dark">

                <b class='h_id_nota'></b>

                <button type="button" class="btn btn-close btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body overflow-auto">
                <div class="row">

                    <div class="col-lg-6 col-md-12">
                        <div class="card card-info card-outline shadow">
                            <div class="card-header py-1">Data Stok Barang</div>
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
                            <div class="card-header py-1">Edit Nota Belanja</div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover table-sm" width="100%"
                                    id="tbl_keranjang">
                                    <thead class="bg-gradient-danger">
                                        <tr>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Jml</th>
                                            <th class="text-center">Total Harga</th>
                                            <th class="text-center">--</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center" colspan="3">Total</th>
                                            <th class="text-right"></th>
                                            <th class="text-center">--</th>
                                        </tr>
                                        <tr class="tr-input-bayar-user">
                                            <th colspan="5">
                                                <div class="row">
                                                    <label for="bayar" class="col-sm-6 col-form-label text-right">
                                                        Bayar</label>
                                                    <div class="col-sm-6">
                                                        <input type="number" name="bayar"
                                                            class="form-control form-control-sm" id="bayar" />
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label for="kembali" class="col-sm-6 col-form-label text-right">
                                                        Kembalian</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="kembali" disabled />
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label for="nama_pembeli"
                                                        class="col-sm-6 col-form-label text-right">
                                                        Nama Pembeli</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="nama_pembeli"
                                                            class="form-control form-control-sm" id="nama_pembeli" />
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="tr-btn-save-nota">
                                            <th colspan="5">
                                                <button type="submit" class="btn btn-primary btn-block"
                                                    id="btn-save-nota">
                                                    Simpan Perubahan
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
    </div>
</div>

<div class="modal fade " id="cekNota">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-md">
        <div class="modal-content ">
            <div class="modal-header bg-gradient-dark">
                <div class="modal-title">Cetak Nota</div>
                <button type="button" class="btn btn-sm text-light close_preview" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <a href="#" target="_blank" class="btn btn-primary" id="btn_print_nota">PRINT NOTA (Kecil)</a>
                        <a href="#" target="_blank" class="btn btn-primary" id="btn_print_faktur">PRINT NOTA (Besar)</a>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-lg-12 text-center">
                        <a href="#" class="btn btn-danger ml-auto close_preview" data-dismiss="modal">
                            KEMBALI KE HOME</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>