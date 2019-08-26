<div class="modal fade" id="modalrekening" tabindex="-1" role="dialog" aria-labelledby="modalrekening" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kode Rekening</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body table-responsive">
                <table id="lookuprekening" style="width: 100%;font-family: 'Roboto Mono', monospace;" class="dt table table-bordered table-sm table-hover nowrap">
                     <thead>
                         <tr>
                            <th>Kode Rekening</th>
                            <th>Nama Rekening</th>
                         </tr>
                     </thead>
                     <tbody>
                        <tr class="pilihrekening" data-koderekening="" data-namarekening="INDUK" data-idrekening="NULL">
                            <td>0</td>
                            <td>INDUK</td>
                        </tr>
                        <?php
                         //Data mentah yang ditampilkan ke tabel    
                        /*$qwith= "WITH RECURSIVE category_path (id, nama_rekening, path) AS
                            (
                              SELECT id, nama_rekening, kode_rekening as path
                                FROM koderekening
                                WHERE parent_id IS NULL
                              UNION ALL
                              SELECT c.id, c.nama_rekening, CONCAT(cp.path, '.', c.kode_rekening)
                                FROM category_path AS cp JOIN koderekening AS c
                                  ON cp.id = c.parent_id
                            )
                            SELECT * FROM category_path
                            ORDER BY path";
                        $sql = mysqli_query($link,$qwith);
                        while ($r = mysqli_fetch_array($sql)) {*/
                        use Illuminate\Database\Capsule\Manager as DB;
                        $rekening= collect(DB::select('call koderekening_lengkap()'))->where('deleted_at','=',null);
                        foreach ($rekening as $key => $r) {
                            ?>
                            <tr class="pilihrekening" data-namarekening="<?php echo $r->nama_rekening; ?>" data-koderekening="<?php echo $r->path;?>" data-idrekening="<?php echo $r->id; ?>">
                                <td><?php echo $r->path; ?></td>
                                <td><?php echo $r->nama_rekening; ?></td>   
                                 
                            </tr>
                            <?php
                        }
                        ?>
                     </tbody>
                 </table> 
            </div>
        </div>
    </div>
</div>

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#lookuprekening thead tr').clone(true).appendTo( '#lookuprekening thead' );
        $('#lookuprekening thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input class="form-control form-control-sm" type="text" placeholder="'+title+'" />' );
     
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
        var table = $('#lookuprekening').DataTable( {
            orderCellsTop: true,
            dom: 'lrtip',
        } );
    });
</script>