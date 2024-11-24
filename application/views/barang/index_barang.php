<div class="card card-info card-outline">
    <div class="card-header">
        <h3 class="card-title">
            Data Stok Barang
        </h3>
    </div>
    <div class="card-body">
        <button type="button" class='btn btn-sm btn-primary btn-add' data-toggle="modal"
            data-target="#modalBarang">Tambah Barang</button>

        <div class="table-responsive mt-2">
            <table id="barang" class="table table-bordered table-hover table-sm responsive" width="100%">
                <thead class="bg-gradient-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Harga Barang</th>
                        <th>Harga Jual</th>
                        <th>Jml Pemasukan</th>
                        <th>Jml Terjual</th>
                        <th>Jml Stok</th>
                        <th>Aksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<?php include "modal_barang.php"; ?>