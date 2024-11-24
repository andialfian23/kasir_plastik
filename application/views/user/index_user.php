<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <h4>Data Users</h4>
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="users" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>--</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            foreach($users as $key){
                        ?>

                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $key->title ?></td>
                            <td><?= $key->username ?></td>
                            <td><?= $key->password ?></td>
                            <td>--</td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>


                <!-- Page specific script -->
                <script>
                $(function() {
                    $('#users').DataTable({
                        "autoWidth": true,
                        "responsive": true,
                    });
                });
                </script>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>