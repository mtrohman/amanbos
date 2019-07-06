<div class="modal fade" id="modalsekolah" tabindex="-1" role="dialog" aria-labelledby="modalsekolah" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 90%; width: 700px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kode Sekolah</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body table-responsive">
                <table id="lookupsekolah" class="dt table table-bordered table-sm table-hover">
                     <thead>
                         <tr>
                            <th style="width:10%">NPSN</th>
                            <th style="width:40%">Nama Sekolah</th>
                            <th>Alamat</th>
                         </tr>
                     </thead>
                     <tbody>
                        
                        <?php
                         //Data mentah yang ditampilkan ke tabel    
                        $qwith= "SELECT * FROM sekolah";
                        $sql = mysqli_query($link,$qwith);
                        while ($r = mysqli_fetch_array($sql)) {
                            ?>
                            <tr class="pilihsekolah" data-namasekolah="<?php echo $r['nama_sekolah']; ?>" data-npsn="<?php echo $r['npsn'];?>" data-idsekolah="<?php echo $r['id']; ?>">
                                <td><?php echo $r['npsn']; ?></td>
                                <td><?php echo $r['nama_sekolah']; ?></td>   
                                <td><?php echo $r['alamat']; ?></td>    
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
        $('#lookupsekolah thead tr').clone(true).appendTo( '#lookupsekolah thead' );
        $('#lookupsekolah thead tr:eq(1) th').each( function (i) {
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
        var table = $('#lookupsekolah').DataTable( {
            orderCellsTop: true,
            dom: 'lrtip',
        } );
    });
</script>