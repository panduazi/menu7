<?php
  session_start();
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
  $user = $_SESSION['cuser'];
  $level = $_SESSION['clevel'];
  $groupid = $_SESSION['cgroupid'];
  $group = $_SESSION['cgroupid'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Menu7</title>
    <link rel="stylesheet" type="text/css" href="themes/bootstrap/easyui.css">
    <link rel="stylesheet" type="text/css" href="themes/icon.css">
    <link rel="stylesheet" type="text/css" href="themes/color.css">
    <link rel="stylesheet" type="text/css" href="jq/demo/demo.css">
    <script type="text/javascript" src="jq/jquery.min.js"></script>
    <script type="text/javascript" src="jq/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="jq/main.js"></script>

</head>
<body class="easyui-layout" style="font-family:Tahoma">
    <div data-options="region:'north',split:true" title="PT. PANDU SIWI BANDUNG | PSB Management System" style="height:35px">
    </div>
	<div data-options="region:'west',split:true,title:'Menu Utama Bandung'" style="width:250px;padding:3px;">
    <!-- <div class="easyui-accordion" fit="true" border="false" iconCls="icon-redo"> -->
       <div title="Aplikasi Lodaya">
		 <ul class="easyui-tree"  data-options="animate:true,lines:true">
            <?php  
	        if ($groupid=='ADMIN' && $level==1) {
               echo "<li data-options=state:'closed'><span>MASTER DATABASE</span>";
                echo "<ul>";
                	echo "<li><a href='?hal=mastercust' style='text-decoration:none'>Master Pelanggan</a></li>";
                    echo "<li>Master Harga Pelanggan</li>";
                    echo "<li>Master Pegawai</li>";
                    echo "<li>Master User</li>";
                echo "</ul>";
               echo "</li>";
			   }
			?>
			<?php
			if ($groupid=='OPS' || $groupid=='ADMIN') {
            //echo "<li><span>TRANSAKSI OPERATIONAL</span>";
            //echo "<ul>";
            //echo "<li data-options=state:'closed'><span>Oubound</span>";
            //echo "<ul>";
            //echo "<li><a href='?hal=entryeawb' style='text-decoration:none'><span>Entry e-AWB Cash</span></a></li>";
            //echo "<li><a href='?hal=entryawb' style='text-decoration:none'><span>Entry AWB-Credit</span></a></li>";
            //echo "<li><a href='#' style='text-decoration:none'><span>Entry Hasil Pickup</span></a></li>";
            //echo "<li><a href='?hal=sinkronawb' style='text-decoration:none'><span>Sinkron Database PSB</span></a></li>";
            //echo "<li><a href='?hal=uploadawb' style='text-decoration:none'><span>Upload AWB ke ODISYS</span></a></li>";
            //echo "</ul>";
            //echo "</li>";
            //echo "</ul>";
            //echo "<ul>";
            //echo "<li data-options=state:'closed'><span>Inbound</span>";
            //echo "<ul>";
            //echo "<li><a href='?hal=entryinb' style='text-decoration:none'><span>Entry Inbound</span></a></li>";
            //echo "<li><a href='?hal=updateinb' style='text-decoration:none'><span>Update Data Inbound</span></a></li>";
            //echo "<li><a href='?hal=entrystatus' style='text-decoration:none'><span>Update Delivery Inbound</span></a></li>";
            //echo "</ul>";
            //echo "</li>";
            //echo "</ul>";
            //echo "</li>";
			}
            ?>
            
            <?php
			if ($groupid=='MKT' || $groupid=='ADMIN' || $groupid=='CSO') {
            echo "<li  data-options=state:'closed'><span>SALES & MARKETING</span>";
            echo "<ul>";
            echo "<li><a href='?hal=harga' style='text-decoration:none'><span>Daftar Harga Umum</span></a></li>";
            echo "<li><a href='?hal=ekunjung' style='text-decoration:none'><span>Entry Kunjungan Sales</span></a></li>";
            echo "<li><a href='?hal=lapout_sales' style='text-decoration:none'><span>View Outbound Detail</span></a></li>";
            echo "</ul>";
            echo "</li>";
			}
            ?>

            <?php
			if ($groupid=='CSO' || $groupid=='ADMIN') {
            echo "<li data-options=state:'closed'><span>CUSTOMER SERVICE</span>";
            echo "<ul>";
            echo "<li><a href='?hal=harga' style='text-decoration:none'><span>Daftar Kota/Harga Umum</span></a></li>";
            echo "<li><a href='?hal=puorder' style='text-decoration:none'><span>Entry Pickup-Order</span></a></li>";
            echo "<li><a href='?hal=komplen' style='text-decoration:none'><span>Entry Keluhan Pelanggan</span></a></li>";
            echo "</ul>";
            echo "</li>";
			}
            ?>

            <?php
			if ($groupid=='ADMIN' && $level==1) {
            echo "<li  data-options=state:'open'><span>ADMIN KEU.</span>";
            echo "<ul>";
            echo "<li><a href='?hal=validasi' style='text-decoration:none'><span>Validasi Resi/AWB</span></a></li>";
            echo "<li><a href='?hal=importresi' style='text-decoration:none'><span>Import/Sinkron Data Resi</span></a></li>";
            echo "</ul>";
            echo "</li>";
			}

            if ($groupid=='ADMIN' && $level==1) {
            echo "<li  data-options=state:'open'><span>ACCOUTING & FINANCIAL</span>";
            echo "<ul>";
            echo "<li><a href='?hal=addjur' style='text-decoration:none'><span>Entry Jurnal Memorial</span></a></li>";
            echo "<li><a href='?hal=edtjur' style='text-decoration:none'><span>Edit Jurnal/Koreksi Jurnal</span></a></li>";
            echo "<li><a href='?hal=bayarjur' style='text-decoration:none'><span>Catat Pembayaran ke Jurnal</span></a></li>";
            echo "</ul>";
            echo "</li>";
			}
            
            ?>


            <li>
                <span>REPORT/LAPORAN</span>
                <ul>
                    <li data-options="state:'open'">
                        <span>Operational</span>
                        <ul>
                           <li><a href="?hal=lappikup" style="text-decoration:none"><span>PickUp Order</span></a></li>
                            <li><a href="?hal=lapout" style="text-decoration:none"><span>Shipment Detail</span></a></li>
                            <li><a href="?hal=lapreksales" style="text-decoration:none"><span>Rekapitulasi Penjualan</span></a></li>
                            <li><a href='?hal=lapmoda' style='text-decoration:none'><span>Persentase By Moda Udara</span></a></li>
                        </ul>
                    </li>
                    <?php
			        if ($groupid=='ADMIN' && $level==1) {
                        echo "<li  data-options=state:'open'><span>Accounting</span>";
                        echo "<ul>";
                        echo "<li><a href='?hal=piutang' style='text-decoration:none'><span>Outstanding Invoice</span></a></li>";
                        echo "<li><a href='?hal=jbayar' style='text-decoration:none'><span>Jadwal cair kontrabon/giro</span></a></li>";
                        echo "<li><a href='?hal=minv' style='text-decoration:none'><span>Monitoring Kolektor</span></a></li>";                     
                        echo "<li><a href='?hal=rekinv' style='text-decoration:none'><span>Monitoring Status Invoice</span></a></li>";
                        echo "<li><a href='?hal=gl' style='text-decoration:none'><span>General Ledger</span></a></li>";                     
                        echo "<li><a href='?hal=xxx' style='text-decoration:none'><span>Kartu Piutang</span></a></li>";
                        echo "</ul>";
                        echo "</li>";
                       }
                    ?>    

                    <?php
					if ($level==1) { 
                     echo "<li data-options=state:'closed'><span>Surat Muatan Udara</span>";
                     echo "<ul>";
                     echo "<li><a href='?hal=taripsmu' style='text-decoration:none'><span>Tarip & Prioritas Vendor</span></a></li>";
                     echo "<li><a href='?hal=lapspk' style='text-decoration:none'><span>Monitoring SPK Vendor-Cargo</span></a></li>";                     
					 echo "<li><a href='?hal=lapsmu' style='text-decoration:none'><span>Monitorind Transaksi Vendor</span></a></li>";
                     echo "</ul>";
                     echo "</li>";
					}
					?>
                    <li data-options="state:'closed'">
                        <span>Download Data</span>
                        <ul>
                            <li><a href="?hal=dlapout" style="text-decoration:none">Data Outbound Detail</a></li>
                            <li><a href="?hal=dlapsout" style="text-decoration:none">Data Status Outbound</a></li>
					<?php
                    if ($level <=2) { 
                        echo "<li><a href='?hal=dlvalid' style='text-decoration:none'>Data Hasil VALDASI</a></li>";
                        echo "<li><a href='?hal=dlproduksi' style='text-decoration:none'>Data PRODUKSI Detail</a></li>";
                        echo "<li><a href='?hal=dlapsmu' style='text-decoration:none'>Data SMU</a></li>";
                        echo "<li><a href='?hal=dlapsmudetail' style='text-decoration:none'>Data SMU Detail AWB</a></li>";
                        echo "<li><a href='?hal=dlapbymoda' style='text-decoration:none'>Outbound Detail AREA dan MODA</a></li>";
                        echo "<li><a href='?hal=dlapbymodakota' style='text-decoration:none'>Tonase per Tujuan Kota/Kab</a></li>";
                        }
                    ?>       
                        <li><a href="?hal=upodisys" style="text-decoration:none">Upload AWB ke server Odisys</a></li>
                        </ul>
                    </li>
                </ul>
                
            <li data-options="state:'closed'"><span>System</span>
                <ul>
       			  <li><a href="?hal=profil" style="text-decoration:none">Dashboard</a></li>
       			  <li><a href="logout.php" style="text-decoration:none">Logout/Exit</a></li>
                </ul>
            </li>
                
            </li>
        </ul>        
       </div>

    </div>
    
	<div data-options="region:'center',title:''" style="padding:1px">
    <!-- <div id="p" class="easyui-panel" title="Basic Panel" style="width:100%;height:550px;padding:10px;">  --> 
  <?php 
    if (isset($_GET['hal'])) {
  		if ($_GET['hal']=='home') {include('home.html');}
        elseif ($_GET['hal']=='mastercust') {include('master/customer/customer.html');}
        elseif ($_GET['hal']=='entryeawb') {include('transak/entri_outbound/entri_eresi.php');}
		elseif ($_GET['hal']=='entryawb') {include('transak/entri_outbound/entri_resi2.php');}
		elseif ($_GET['hal']=='harga') {include('master/harga_new/harga_new.html');}
		elseif ($_GET['hal']=='entryinb') {include('transak/entri_inbound/entri_resi.php');}
		elseif ($_GET['hal']=='updateinb') {include('transak/entri_inbound/update_resi.php');}
		elseif ($_GET['hal']=='entrystatus') {include('transak/entri_inbound/entri_resi_status.php');}
        elseif ($_GET['hal']=='sinkronawb') {include('report/sinkron_awb_psb/form_upload.php');}
        elseif ($_GET['hal']=='uploadawb') {include('report/upload_awb_odisys/form_upload.php');}


        elseif ($_GET['hal']=='validasi') {include('administrasi/validasi/form_validasi.html');}
        elseif ($_GET['hal']=='importresi') {include('administrasi/import_resi/form_import.html');}
        elseif ($_GET['hal']=='addjur') {include('accounting/form_add_jurnal.html');}
        elseif ($_GET['hal']=='edtjur') {include('accounting/form_jurnal.html');}
        elseif ($_GET['hal']=='bayarjur') {include('accounting/form_bayar_jurnal.html');}

		elseif ($_GET['hal']=='piutang') {include('report/piutang/form_piutang.php');}
		elseif ($_GET['hal']=='jbayar') {include('report/jadwalbayar/form_jbayar.php');}
		elseif ($_GET['hal']=='minv') {include('report/monitorinv/form_minv.php');}
		elseif ($_GET['hal']=='rekinv') {include('report/rekapinv/form_rekinv.php');}
		elseif ($_GET['hal']=='gl') {include('report/gl/form_gl.html');}

		elseif ($_GET['hal']=='lappikup') {include('report/pickup/lappikup.php');}
		elseif ($_GET['hal']=='lapout') {include('report/lapout.php');}
		//elseif ($_GET['hal']=='lapout') {include('report/lapjual_detail/form_jdetail.php');}
		elseif ($_GET['hal']=='lapreksales') {include('report/rekapsales/form_reksales.php');}
		elseif ($_GET['hal']=='lapocust') {include('report/lapout_cust.php');}
		elseif ($_GET['hal']=='lapopeg') {include('report/lapout_pegawai.php');}
		elseif ($_GET['hal']=='laparea') {include('report/lapout_area.php');}
		elseif ($_GET['hal']=='lapmoda') {include('report/lapout_moda.php');}
		elseif ($_GET['hal']=='sdc1') {include('report/sdc/forcast.php');}
		//elseif ($_GET['hal']=='lapocust') {include('report/lapout_cust.html');}
		elseif ($_GET['hal']=='taripsmu') {include('master/taripvendor/taripvendor.html');}
		elseif ($_GET['hal']=='lapsmu') {include('report/lapsmu.php');}
		elseif ($_GET['hal']=='lapspk') {include('report/lapsmu_spk.php');}
		elseif ($_GET['hal']=='profil') {include('home.html');}

        elseif ($_GET['hal']=='dlproduksi') {include('report/dw_produksi_form.php');}
        elseif ($_GET['hal']=='dlvalid') {include('report/dw_validasi_form.php');}
		elseif ($_GET['hal']=='dlapout') {include('report/dw_lapout_form.php');}
		elseif ($_GET['hal']=='dlapin') {include('report/dw_lapin_form.php');}
		elseif ($_GET['hal']=='dlapsout') {include('report/dw_lapsout_form.php');}
		elseif ($_GET['hal']=='dlapsmu') {include('report/dw_lapsmu_form.php');}
        elseif ($_GET['hal']=='dlapsmudetail') {include('report/dw_lapsmu_form2.php');}
        elseif ($_GET['hal']=='dlapbymoda') {include('report/dw_lapmoda_form.php');}
        elseif ($_GET['hal']=='dlapbymodakota') {include('report/dw_lapmodakota_form.php');}
        elseif ($_GET['hal']=='upodisys') {include('report/up_awb_odisys_form.php');}

		elseif ($_GET['hal']=='viewharga') {include('master/harga/viewharga.php');}
		elseif ($_GET['hal']=='puorder') {include('transak/pickup/master.html');}
		elseif ($_GET['hal']=='komplen') {include('transak/komplen/entri_komplen.php');}
		elseif ($_GET['hal']=='ekunjung') {include('transak/entri_kunjung/entry_kunjung.php');}
		elseif ($_GET['hal']=='lapout_sales') {include('report/lapout_sales.php');}
		}
	else {include 'home.html';}
  ?>
    <!-- </div> <!-- end of panel -->  
  </div> <!-- end of region -->


    <div region="south" class="fill" style="height: 35px; padding: 5px;" split="true">
      Copyright &copy; 2015 - IT Dept, Bandung
    </div>    
</body>
</html>