<?php
    include_once 'config/db.php';
    $role       = $_SESSION['role'];
    $nama       = $_SESSION['nama'];
    $username   = $_SESSION['username'];
    $ta         = $_SESSION['ta'];
    $tw         = $_SESSION['triwulan'];

    $cekrole = mysqli_query($link,"SELECT * FROM role WHERE id=$role");
    $datarole= mysqli_fetch_array($cekrole);
    $namarole= $datarole['nama'];

    if ($role=="2") {
        # code...
        $loggedinid = $_SESSION['id'];
        $sql        = mysqli_query($link,"SELECT * FROM sekolah WHERE id_sekolah=$loggedinid");
        $datasidebar= mysqli_fetch_array($sql);
        $foto       = $datasidebar['foto'];
        if ($foto=="") {
            $foto="0.jpg";
        }
    }
    else{
        $loggedinid = $_SESSION['id'];
        $sql        = mysqli_query($link,"SELECT * FROM admin WHERE id=$loggedinid");
        $datasidebar= mysqli_fetch_array($sql);
        $foto       = $datasidebar['foto'];
        if ($foto=="") {
            $foto="0.jpg";
        }
    }

?>

        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile">
                    <!-- User profile image -->
                    <!-- <div class="text-center">
                                                
                    </div> -->
                        <h6 style="margin-top: 15px;text-align: center;"><?php echo "TA: ".$ta." (TW:".$tw.")";?></h6>
                    <div class="profile-img"> 
                        <img src="foto/<?php echo $foto;?>" alt="user" />  
                             <!-- this is blinking heartbit-->
                            <!-- <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div> -->
                    </div>
                    <!-- User profile text-->
                    <div class="profile-text"> 
                            <h6><?php echo ucfirst($nama); ?></h6>
                            <!-- <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a> -->
                             
                            <!-- <a href="javascript:logout()" class="" title="Logout"><i class="mdi mdi-power"></i></a> -->

                        <div class="dropdown-menu animated flipInY">
                        <!-- text--> 
                        <a href="profile.php" class="dropdown-item"><i class="ti-user"></i> Profil Saya</a>
                        <!-- text-->  
                        <div class="dropdown-divider"></div>
                        <!-- text-->  
                        <a href="javascript:logout()" class="sa-warning dropdown-item"><i class="fa fa-power-off"></i> Keluar</a>
                        <!-- text-->  
                        </div>
                    </div>  
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-small-cap"><?php echo strtoupper($namarole); ?>
                            
                        </li>
                        <?php
                            $sqlmenu=mysqli_query($link,"SELECT modul.id as id, isparent, modul.nama, url, icon FROM menu
                                LEFT JOIN modul
                                ON menu.id_modul=modul.id
                                WHERE id_role=$role");
                            while($row =mysqli_fetch_array($sqlmenu)){
                                $isparent=$row['isparent'];
                                $idmodul =$row['id']
                                ?>
                                <li> 
                                    <a class="waves-effect waves-dark <?php if($isparent) echo "has-arrow";?>" href="<?php echo $row['url'];?>" aria-expanded="false"><i class="mdi <?php echo $row['icon'];?>"></i><span class="hide-menu"><?php echo $row['nama'];?></span>
                                    </a>
                                    <?php
                                        if ($isparent) {
                                            ?>
                                            <ul aria-expanded="false" class="collapse">
                                            <?php
                                            $sqlsubmenu=mysqli_query($link,"SELECT * FROM submenu
                                                LEFT JOIN submodul
                                                ON submenu.id_submodul=submodul.id
                                                WHERE id_role=$role
                                                AND id_modul=$idmodul
                                                AND submodul.submodul=0 ORDER BY submenu.id
                                                ");
                                            while($row =mysqli_fetch_array($sqlsubmenu)){
                                                $idsubmodul= $row['id'];
                                                $punyaanak= $row['isparent'];
                                            ?>
                                                <li>
                                                    <a class="<?php if($punyaanak) echo "has-arrow";?>" href="<?php echo $row['url'];?>" aria-expanded="false"><?php echo $row['nama'];?></a>
                                                    <?php
                                                    if ($punyaanak) {
                                                    ?>
                                                        <ul aria-expanded="false" class="collapse">
                                                        <?php
                                                            $sqlsubmenu2=mysqli_query($link,"SELECT * FROM submenu
                                                                LEFT JOIN submodul
                                                                ON submenu.id_submodul=submodul.id
                                                                WHERE id_role=$role
                                                                AND submodul=$idsubmodul");
                                                            while($row2 =mysqli_fetch_array($sqlsubmenu2)){
                                                               
                                                            ?>
                                                            <li>
                                                                <a href="<?php echo $row2['url'];?>" aria-expanded="false"><?php echo $row2['nama'];?></a>
                                                            </li>
                                                        <?php } ?>
                                                        </ul>
                                                    <?php } ?>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                            <?php
                                        }
                                    ?>
                                    
                                </li>
                                <?php
                            }
                        ?>
                        <li> 
                            <a class="waves-effect waves-dark " href="javascript:logout()" aria-expanded="false"><i class="mdi mdi-power"></i><span class="hide-menu">Keluar</span>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>