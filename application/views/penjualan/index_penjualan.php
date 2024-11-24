<div class="row">
    <div class="col-12">
        <div class="card card-danger card-outline">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex">
                    <h3 class="card-title ">
                        Data Penjualan
                    </h3>
                </div>
                <div class="ml-auto d-flex">
                    <h6 class="btn bg-gradient-info dropdown-toggle" id="reportrange">
                        <b id="periode"></b>
                    </h6>
                    <input type="hidden" id="xBegin" />
                    <input type="hidden" id="xEnd" />
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="row">

                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box shadow">
                                    <div class="info-box-content text-center">
                                        <span class="info-box-text">Total Penjualan <br />Hari Ini</span>
                                        <span class="info-box-number">
                                            <?= ($total1 != 0) ? 'Rp '.number_format($total1) : 0; ?>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box shadow">
                                    <div class="info-box-content text-center">
                                        <span class="info-box-text">Total Penjualan <br />Bulan Ini</span>
                                        <span class="info-box-number">
                                            <?= ($total2 != 0) ? 'Rp '.number_format($total2) : 0; ?>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box shadow">
                                    <div class="info-box-content text-center">
                                        <span class="info-box-text">Total Penjualan <br />Tahun Ini</span>
                                        <span class="info-box-number">
                                            <?= ($total3 != 0) ? 'Rp '.number_format($total3) : 0; ?>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box shadow">
                                    <div class="info-box-content text-center">
                                        <span class="info-box-text">Total Penjualan <br />Selama Ini</span>
                                        <span class="info-box-number">
                                            <?= ($total4 != 0) ? 'Rp '.number_format($total4) : 0;?>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table id="penjualan" class="table table-bordered table-hover table-sm responsive"
                                width="100%">
                                <thead>
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>Tanggal</th>
                                        <th>No. Nota</th>
                                        <th>Pembeli</th>
                                        <th>Total</th>
                                        <th>--</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

<?php include "modal_penjualan.php"; ?>