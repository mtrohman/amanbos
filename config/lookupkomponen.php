<div class="modal fade" id="modalkomponen" tabindex="-1" role="dialog" aria-labelledby="modalkomponen" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 90%; width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kode Komponen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body table-responsive">
                <table id="lookupkomponen" class="dt table table-bordered table-sm table-hover table-striped">
                     <thead>
                         <tr>
                            <th>Kode Komponen</th>
                            <th>Nama Komponen</th>
                         </tr>
                     </thead>
                     <tbody>
                        
                        <?php
                         //Data mentah yang ditampilkan ke tabel    
                        $qwith= "SELECT * FROM kodepembiayaan";
                        $sql = mysqli_query($link,$qwith);
                        while ($r = mysqli_fetch_array($sql)) {
                            ?>
                            <tr class="pilihkomponen" data-namakomponen="<?php echo $r['nama_pembiayaan']; ?>" data-kodepembiayaan="<?php echo $r['kode_pembiayaan'];?>" data-idkomponen="<?php echo $r['id']; ?>">
                                <td><?php echo $r['kode_pembiayaan']; ?></td>
                                <td><?php echo $r['nama_pembiayaan']; ?></td>   
                                 
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
        $('#lookupkomponen thead tr').clone(true).appendTo( '#lookupkomponen thead' );
        $('#lookupkomponen thead tr:eq(1) th').each( function (i) {
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
        var table = $('#lookupkomponen').DataTable( {
            orderCellsTop: true,
            dom: 'lrtip',
        } );
    });
</script>