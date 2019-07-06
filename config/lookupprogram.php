<div class="modal fade" id="modalprogram" tabindex="-1" role="dialog" aria-labelledby="modalprogram" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 90%; width: 600px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kode Program</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body table-responsive">
                <table id="lookupprogram" class="dt table table-bordered table-sm table-hover table-striped nowrap">
                     <thead>
                         <tr>
                            <th>Kode Program</th>
                            <th>Nama Program</th>
                         </tr>
                     </thead>
                     <tbody>
                        
                        <?php
                         //Data mentah yang ditampilkan ke tabel    
                        $qwith= "SELECT * FROM kodeprogram";
                        $sql = mysqli_query($link,$qwith);
                        while ($r = mysqli_fetch_array($sql)) {
                            ?>
                            <tr class="pilihprogram" data-namaprogram="<?php echo $r['nama_program']; ?>" data-kodeprogram="<?php echo $r['kode_program'];?>" data-idprogram="<?php echo $r['id']; ?>">
                                <td><?php echo $r['kode_program']; ?></td>
                                <td><?php echo $r['nama_program']; ?></td>   
                                 
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
        $('#lookupprogram thead tr').clone(true).appendTo( '#lookupprogram thead' );
        $('#lookupprogram thead tr:eq(1) th').each( function (i) {
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
        var table = $('#lookupprogram').DataTable( {
            orderCellsTop: true,
            dom: 'lrtip',
        } );
    });
</script>