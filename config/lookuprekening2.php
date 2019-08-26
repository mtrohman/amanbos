<div class="modal fade" id="modalrekening" tabindex="-1" role="dialog" aria-labelledby="modalrekening" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 90%; width: 700px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kode Rekening</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body table-responsive">
                <table id="lookuprekening" style="width: 100%;font-family: 'Roboto Mono', monospace;" class="dt table table-sm table-hover table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Kode Rekening</th>
                            <th>Nama Rekening</th>
                            <th>Parent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            /*$sqlrekening="WITH RECURSIVE category_path (id, nama_rekening, nomor_rekening,parent_id) AS
                            (
                              SELECT id, nama_rekening, kode_rekening as nomor_rekening, parent_id
                                FROM koderekening
                                WHERE parent_id IS NULL
                              UNION ALL
                              SELECT c.id, c.nama_rekening, CONCAT(cp.nomor_rekening, '.', c.kode_rekening), c.parent_id
                                FROM category_path AS cp JOIN koderekening AS c
                                  ON cp.id = c.parent_id
                            )
                            SELECT
                            core.id, core.nama_rekening, nomor_rekening,
                            kr2.nama_rekening as parent
                            FROM category_path core
                            INNER JOIN koderekening kr2 ON kr2.id=core.parent_id
                            ORDER BY nomor_rekening";*/
                            // $sql = mysqli_query($link,$sqlrekening);
                            // while ($r = mysqli_fetch_array($sql)) {
                            use Illuminate\Database\Capsule\Manager as DB;
                            $rekening= collect(DB::select('call koderekening_node()'))->where('deleted_at','=',null);
                            foreach ($rekening as $key => $r) {
                            ?>
                            <tr class="pilihrekening" data-namarekening="<?php echo $r->nama_rekening; ?>" data-idrekening="<?php echo $r->id; ?>">
                                <td><?php echo $r->nomor_rekening; ?></td>
                                <td><?php echo $r->nama_rekening; ?></td>
                                <td><?php echo $r->parent; ?></td>
                                
                            </tr>
                            <?php } ?>
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
        var groupColumn = 2;

            var table = $('#lookuprekening').DataTable( {
                columnDefs: [
                    { "visible": false, "targets": groupColumn }
                ],
                orderCellsTop: true,
                dom: 'lrtip',
                displayLength: 10,
                drawCallback: function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;
         
                    api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                            );
         
                            last = group;
                        }
                    });
                }
            } );
    });
</script>