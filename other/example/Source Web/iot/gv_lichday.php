<?php
  require_once("controller/xacthuc_gv.php");
  $user = $_SESSION['username'];
?>
<script language="javascript">
function isEmpty(ten)
{
	if (ten=="")
		return false;
	return true;
}
function ktra_lichday(hocky,namhoc){
	if(hocky=='default' && namhoc=='default'){
		alert ("Vui lòng chọn học kỳ, năm học!");
		return false;
	}
	return true;
}

</script>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<div>

  <header>
   
    <!-- Main content -->
    <section >
      <div style="padding-top: 50px">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header" style="text-align: center">
            <!-- form start -->
            <form class="form-horizontal" method="post" action="#" onSubmit="return ktra_lichday(hocky.value, namhoc.value);">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Học kỳ</label>

                  <div class="col-sm-10">
                    <select name="hocky" style="width: 100%; height: 35px; margin: 2px;">
                    	<option disabled="true" selected="true" value="default" >Chọn học kỳ</option>
                    	<option value='1' >1</option>
                        <option value='2' >2</option>
                        <option value='3' >Hè</option>

                  </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-2 control-label">Năm học</label>

                  <div class="col-sm-10">
                  <select name="namhoc" style="width: 100%; height: 35px; margin: 2px;">
                    		<option disabled="true" selected="true" value="default" >Chọn năm học</option>
                    <?php 
				 		 $sql2= "SELECT DISTINCT NAMHOC FROM nhom_hp, hocky_namhoc WHERE nhom_hp.ID_HKNH=hocky_namhoc.ID_HKNH AND nhom_hp.TAIKHOAN_USER='$user'";
 			 	  		 $query2 = mysqli_query($conn,$sql2);
 			     		 while($kq2 = mysqli_fetch_array($query2)){
	  			 		echo "
                    		<option value='$kq2[NAMHOC]' >$kq2[NAMHOC]</option>
                    		
							";
 					 }
				  ?>
                  </select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer" style="text-align: center">
                <button type="submit" class="btn btn-info pull-center" style="text-align: center">Tìm kiếm</button>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        
      </form>
            
				<span class="box-title" style="font-size:40px; margin-left: 43%; color: white;">LỊCH DẠY     
                </span>
                </br>
                <span class="box-title" style="font-size:30px; margin-left: 40%; font-style:italic;color: white;">
               <?php if(isset($_POST["hocky"]) AND isset($_POST["namhoc"]) ){
			   			echo "Học kì " .$_POST["hocky"]." (".$_POST["namhoc"].")" ;
			         }
					 else if(isset($_POST["hocky"])){
			   			echo "Học kì " .$_POST["hocky"];
					 }
					 else if(isset($_POST["namhoc"])){
			   			echo "Năm học " .$_POST["namhoc"];
					 }
			   ?>
                </span>
            </div>
            <!-- /.box-header -->
            <div class="box-body" >
              <table id="example2" class="table table-bordered table-hover">
                <thead style="background-color: #066EB0; color: white; text-align-last: center">
                <tr>
                  <th>Thứ</th>
                  <th>Mã học phần</th>
                  <th>Mã nhóm</th>
                  <th>Tiết bắt đầu</th>
                  <th>Số tiết</th>
                  <th>Phòng học</th>
                  <th>Tuần học</th>
                  <th>Chi tiết</th>
                </tr>
                </thead>
                <tbody style="text-align:center; background-color: white;">
                <?php
				
				if(isset($_POST["hocky"]) AND isset($_POST["namhoc"]) )
				{
					$hk=$_POST["hocky"];
					//echo "Nhan duoc $hk";
					$namhoc = $_POST["namhoc"];
					//echo "Nam hoc $namhoc";
				 $sql= "SELECT lich_hoc.THU, lich_hoc.SO_TIET, lich_hoc.ID_TUAN, lich_hoc.ID_NHOM_HP, mon_hoc.MA_MH, nhom_hp.MA_NHOM_HP,phong.TEN_PHONG, tiet_hoc.GIO_BD, tiet_hoc.ID_TIET
				                 FROM lich_hoc, nhom_hp, mon_hoc, phong, hocky_namhoc, tiet_hoc
       							 WHERE 
								 lich_hoc.ID_NHOM_HP=nhom_hp.ID_NHOM_HP AND
								 nhom_hp.MA_MH = mon_hoc.MA_MH AND
								 lich_hoc.ID_PHONG = phong.ID_PHONG AND
								 lich_hoc.ID_TIET = tiet_hoc.ID_TIET AND
								 nhom_hp.ID_HKNH = hocky_namhoc.ID_HKNH AND
							 	 hocky_namhoc.HOCKY='$hk' AND 
			 					 hocky_namhoc.NAMHOC='$namhoc' AND
								 nhom_hp.TAIKHOAN_USER='$user'
								 GROUP BY lich_hoc.THU, tiet_hoc.ID_TIET
								";
 				 $query = mysqli_query($conn,$sql);
				 $sodong = mysqli_num_rows($query);
				 //echo "$sodong";
				 if($sodong>0){
  				 while($kq = mysqli_fetch_array($query)){
	  				echo "
						<tr>
				 			 <td>$kq[THU]</td>
                 			 <td>$kq[MA_MH]</td>
                 			 <td>$kq[MA_NHOM_HP]</td>
							 <td>$kq[GIO_BD]</td>
                 			 <td>$kq[SO_TIET]</td>
                 			 <td>$kq[TEN_PHONG]</td>
                 			 <td>
				     ";
					  
					  $sql3="SELECT lich_hoc.ID_TUAN FROM lich_hoc, tiet_hoc WHERE ID_NHOM_HP=$kq[ID_NHOM_HP] AND lich_hoc.THU= $kq[THU] AND lich_hoc.ID_TIET=tiet_hoc.ID_TIET AND tiet_hoc.ID_TIET=$kq[ID_TIET]";
					  $query3=mysqli_query($conn,$sql3);
					  $sodong3 = mysqli_num_rows($query3);
					  if($sodong3>0){
  				 		$i=1;
  				 		while($kq3 = mysqli_fetch_array($query3)){
  				 			if($i<$sodong3){
  				 				echo "$kq3[ID_TUAN]-";
  				 			}
	  						else{
	  							echo "$kq3[ID_TUAN]";
	  						}
	  						$i++;
          			 	} //while kq3
					  	echo "</td>
					        <td ><a href=\"?khoatrang=gv_lichday_ct&hocky=$hk&namhoc=$namhoc&mahp=$kq[ID_NHOM_HP]\"><img src=\"icon/xem.png\" style=\"width: 15px; height: 15px;\"/></a></td>
							</tr>";
					  	} //if so dong3
				 else {
					 echo "
					     <td>Không có dữ liệu</td>
					 </tr>
					 
					 ";
				 }
          			  } //while kq
					  } //if dong
					 else 
					 echo "
					   <tr>
					      <td colspan='8'>Không có dữ liệu </td>
					   </tr>  
						  ";
				} //if
				
				else if(isset($_POST["hocky"]))
				{
					$hk=$_POST["hocky"];
					//echo "Nhan duoc $hk";
				$sql= "SELECT lich_hoc.THU, lich_hoc.SO_TIET, lich_hoc.ID_TUAN, lich_hoc.ID_NHOM_HP, mon_hoc.MA_MH, nhom_hp.MA_NHOM_HP,phong.TEN_PHONG, tiet_hoc.GIO_BD, tiet_hoc.ID_TIET
				                 FROM lich_hoc, nhom_hp, mon_hoc, phong, hocky_namhoc, tiet_hoc
       							 WHERE 
								 lich_hoc.ID_NHOM_HP=nhom_hp.ID_NHOM_HP AND
								 nhom_hp.MA_MH = mon_hoc.MA_MH AND
								 lich_hoc.ID_PHONG = phong.ID_PHONG AND
								 lich_hoc.ID_TIET = tiet_hoc.ID_TIET AND
								 nhom_hp.ID_HKNH = hocky_namhoc.ID_HKNH AND
							 	 hocky_namhoc.HOCKY='$hk' AND 
								 nhom_hp.TAIKHOAN_USER='$user'
								 GROUP BY lich_hoc.THU, tiet_hoc.ID_TIET
								";
 				 $query = mysqli_query($conn,$sql);
				 $sodong = mysqli_num_rows($query);
				 //echo "$sodong";
				 if($sodong>0){
  				 while($kq = mysqli_fetch_array($query)){
	  				echo "
						<tr>
				 			 <td>$kq[THU]</td>
                 			 <td>$kq[MA_MH]</td>
                 			 <td>$kq[MA_NHOM_HP]</td>
							 <td>$kq[GIO_BD]</td>
                 			 <td>$kq[SO_TIET]</td>
                 			 <td>$kq[TEN_PHONG]</td>
                 			 <td>
				     ";
					  
					  $sql3="SELECT lich_hoc.ID_TUAN FROM lich_hoc, tiet_hoc WHERE ID_NHOM_HP=$kq[ID_NHOM_HP] AND lich_hoc.THU= $kq[THU] AND lich_hoc.ID_TIET=tiet_hoc.ID_TIET AND tiet_hoc.ID_TIET=$kq[ID_TIET]";
					  $query3=mysqli_query($conn,$sql3);
					  $sodong3 = mysqli_num_rows($query3);
					  if($sodong3>0){
					  	$i=1;
  				 		while($kq3 = mysqli_fetch_array($query3)){
  				 			if($i<$sodong3){
  				 				echo "$kq3[ID_TUAN]-";
  				 			}
	  						else{
	  							echo "$kq3[ID_TUAN]";
	  						}
	  						$i++;
          			 	} //while kq3
					  	echo "</td>
					        <td ><a href=\"?khoatrang=gv_lichday_ct&hocky=$hk&mahp=$kq[ID_NHOM_HP]\"><img src=\"icon/xem.png\" style=\"width: 15px; height: 15px;\"/></a></td>
							</tr>";
					  	} //if so dong3
				 else {
					 echo "
					     <td>Không có dữ liệu</td>
					 </tr>
					 
					 ";
				 }
          			  } //while kq
					  } //if dong
					 else 
					 echo "
					   <tr>
					      <td>Không có dữ liệu</td>
					   </tr>  
						  ";
				} //if
				else if(isset($_POST["namhoc"]) )
				{
					$namhoc = $_POST["namhoc"];
					//echo "Nam hoc $namhoc";
					$sql= "SELECT lich_hoc.THU, lich_hoc.SO_TIET, lich_hoc.ID_TUAN, lich_hoc.ID_NHOM_HP, mon_hoc.MA_MH, nhom_hp.MA_NHOM_HP,phong.TEN_PHONG, tiet_hoc.GIO_BD, tiet_hoc.ID_TIET
				                 FROM lich_hoc, nhom_hp, mon_hoc, phong, hocky_namhoc, tiet_hoc
       							 WHERE 
								 lich_hoc.ID_NHOM_HP=nhom_hp.ID_NHOM_HP AND
								 nhom_hp.MA_MH = mon_hoc.MA_MH AND
								 lich_hoc.ID_PHONG = phong.ID_PHONG AND
								 lich_hoc.ID_TIET = tiet_hoc.ID_TIET AND
								 nhom_hp.ID_HKNH = hocky_namhoc.ID_HKNH AND
							 	 hocky_namhoc.NAMHOC='$namhoc' AND 
								 nhom_hp.TAIKHOAN_USER='$user'
								 GROUP BY lich_hoc.THU, tiet_hoc.ID_TIET
								";
 				 	$query = mysqli_query($conn,$sql);
				 	$sodong = mysqli_num_rows($query);
				 	//echo "$sodong";
				 	if($sodong>0){
  				 	while($kq = mysqli_fetch_array($query)){
	  				echo "
						<tr>
				 			 <td>$kq[THU]</td>
                 			 <td>$kq[MA_MH]</td>
                 			 <td>$kq[MA_NHOM_HP]</td>
							 <td>$kq[GIO_BD]</td>
                 			 <td>$kq[SO_TIET]</td>
                 			 <td>$kq[TEN_PHONG]</td>
                 			 <td>
				     ";
					  
					  $sql3="SELECT lich_hoc.ID_TUAN FROM lich_hoc, tiet_hoc WHERE ID_NHOM_HP=$kq[ID_NHOM_HP] AND lich_hoc.THU= $kq[THU] AND lich_hoc.ID_TIET=tiet_hoc.ID_TIET AND tiet_hoc.ID_TIET=$kq[ID_TIET]";
					  $query3=mysqli_query($conn,$sql3);
					  $sodong3 = mysqli_num_rows($query3);
					  if($sodong3>0){
  				 		$i=1;
  				 		while($kq3 = mysqli_fetch_array($query3)){
  				 			if($i<$sodong3){
  				 				echo "$kq3[ID_TUAN]-";
  				 			}
	  						else{
	  							echo "$kq3[ID_TUAN]";
	  						}
	  						$i++;
          			 	} //while kq3
					  	echo "</td>
					        <td ><a href=\"?khoatrang=gv_lichday_ct&namhoc=$namhoc&mahp=$kq[ID_NHOM_HP]\"><img src=\"icon/xem.png\" style=\"width: 15px; height: 15px;\"/></a></td>
							</tr>";
					  	} //if so dong3
				 else {
					 echo "
					     <td>Không có dữ liệu</td>
					 </tr>
					 
					 ";
				 }
          			  } //while kq
					  } //if dong
					 else 
					 echo "
					   <tr>
					      <td>Không có dữ liệu</td>
					   </tr>  
						  ";
				} //if
				?>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 

  <!-- Control Sidebar -->
 
</body>
</html>