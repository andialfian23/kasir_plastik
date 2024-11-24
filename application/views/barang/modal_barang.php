<div class="modal fade" id="modalBarang">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary py-1">
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Barang</h5>
                <button type="button" class="btn btn-close text-dark" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group input_tgl">
                    <label for="tgl_masuk">Tanggal</label>
                    <input type="date" class="form-control form-control-sm" id="tgl_masuk"
                        value='<?= date('Y-m-d') ?>' />
                    <small id="notif_tgl_masuk" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" class="form-control form-control-sm" id="nama_barang"
                        placeholder="Masukkan Nama Barang">
                    <small id="notif_nama_barang" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="harga_beli">Harga beli</label>
                    <input type="number" class="form-control form-control-sm" id="harga_beli"
                        placeholder="Masukkan Harga Barang">
                    <small id="notif_harga_beli" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" class="form-control form-control-sm" id="harga_jual"
                        placeholder="Masukkan Harga Barang">
                    <small id="notif_harga_jual" class="text-danger"></small>
                </div>
                <div class="form-group input_stock">
                    <label for="jml_stok">Jumlah Barang</label>
                    <input type="number" class="form-control form-control-sm" id="jml_stok" placeholder="Masukkan Qty">
                    <small id="notif_jml_stok" class="text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-danger" data-dismiss="modal">Keluar</button>
                <button type="submit" class="btn bg-gradient-primary" id="btn-save">Simpan</button>
                <button type="submit" class="btn bg-gradient-primary" id="btn-save-stock">Simpan Stok</button>
                <button type="submit" class="btn bg-gradient-primary" id="btn-save-edit">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade " id="preview">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-md" role="document">
        <div class="modal-content ">
            <div class="modal-header bg-gradient-dark py-1">
                <h4 id="h_nama_barang"></h4>
                <button type="button" class="btn btn-close text-light close_preview" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body overflow-auto" id="stok"></div>
            <div class="modal-footer bg-gradient-dark p-1">
                <button type="button" class="btn btn-danger bg-gradient-danger ml-auto close_preview"
                    data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>