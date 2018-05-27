 <?php require_once "../view/header-admin.php"; ?>

 <?php
 $tampil_kategori = tampil_kategori_admin();
 $sukses ="";
 $error = "";

 if  (isset ($_POST ['submit'])) {
 //print_r ($_FILES);

 $judul =  $_POST ['judul'];
 $konten = $_POST['editor1'];
 $kategori = $_POST['kategori'];

 $i = "";
 // $koko=mysqli_insert_id($link);
 // $kaka=mysqli_insert_id($link);

 //image
 $nama       = $_FILES ['image'] ['name'];
 $lokasi     = $_FILES ['image'] ['tmp_name'];
 $type_file = $_FILES ['image'] ['type'];
 $size       = $_FILES ['image'] ['size'];
 $error      = $_FILES ['image'] ['error'];
 $time = time();
 $_format = ['image/png','image/jpeg','image/jpg', 'image/gif'];
 $hen = in_array($type_file, $_format);
 $namafile = $nama;

 if (!empty(trim($judul)) && !empty(trim($konten))) {
 if ($error == 0){
   if ($size < 5000000) {

     if ($hen) {

       switch ($hen){
         case ($type_file =='image/jpeg'):
         $namafile = str_replace(".jpg", "", $namafile);
         $namafile = $namafile. "_". $time . ".jpg";
         break;

         case ($type_file =='image/jpg'):
         $namafile = str_replace(".jpg", "", $namafile);
         $namafile = $namafile. "_". $time . ".jpg";
         break;

         case ($type_file =='image/png'):
         $namafile = str_replace(".png", "", $namafile);
         $namafile = $namafile. "_". $time . ".png";
         break;

         case ($type_file =='image/gif'):
         $namafile = str_replace(".gif", "", $namafile);
         $namafile = $namafile. "_". $time . ".gif";
         break;
         default:
         break;
       }
  if (move_uploaded_file($lokasi,'../gambar/blog/'. $namafile)) {

    if (tambah_data($judul, $konten, $namafile, $kategori )) {
      echo  '<script language="javascript">alert("Artikel berhasil dimasukan"); document.location="post.php";</script>';


      }else {
              $error ='File tidak dapat dimasukan ke dalam database';
            }
  } else { $error = "file tidak dapat di upload";}

 }else {$error ="format harus JPEG/PNG";}
 } else {$error = "File harus kurang dari 5 Mb"; }
 }else {$error = "Terdapat error pada image";}
 } else {$error ='Semua form wajib di isi';}
 }


  ?>

  <aside class="right-side">


      <!-- Content Header (Page header) -->
      <section class="content-header">

          <h1>
              Post
              <small>Tulis</small>
          </h1>
          <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Post</li>
          </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class='row'>
            <div class='col-md-12'>

              <div class='box box-info'>
                    <div class='box-header'>
                        <h3 class='box-title'>Editor <small>Mulailah menulis</small></h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button class="btn btn-info btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-info btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div><!-- /. tools -->
                    </div><!-- /.box-header -->
                    <div class='box-body'>
                      <?php if($sukses){ ?>
                        <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-check"></i>
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                       <p><?php echo $sukses; ?></P>
                      </div>
                    <?php } ?>

                             <?php if($error){ ?>
                               <div class="alert alert-danger
                                alert-dismissable">
                               <i class="fa fa-ban"></i>
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <p><?php echo $error; ?></P>
                             </div>
                           <?php } ?>

                        <!--form begin -->
                       <form action="" method="post" enctype="multipart/form-data">
                       <!-- Form Judul -->
                          <div class="form-group">
                          <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2">Judul</span>
                            <input type="text" class="form-control" placeholder="Masukan Judul" name="judul" aria-describedby="sizing-addon2">
                        </div>
                      </div>

                      <!-- Form Kategori -->
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon" id="sizing-addon2">Kategori</span>
                          <select class="form-control" name="kategori">
                            <?php while ($row= mysqli_fetch_assoc ($tampil_kategori)):?>
                              <option value="<?php echo $row ['id_tag'] ?>"> <?php echo $row ['judul_tag'];?></option>
                            <?php endwhile ?>
                          </select>
                        </div>
                      </div>

                  <!-- upload gambar -->

                  <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon2">Penulis</span>
                    <input type="file" class="form-control" id="fileToUpload" placeholder="Masukan Judul" name="image" aria-describedby="sizing-addon2">
                </div>
              </div>

                       <!--Form Editor -->
                        <div class="form-group">
                            <textarea id="editor1" name="editor1" rows="10" cols="80" placeholder="Silahkan Masukan"></textarea>
                        </div>

                        <!--Submit -->
                        <div class="box-footer">
                         <button class="btn btn-success" name="submit" value="upload image">Publikasikan</button>
                         <a href="post.php" class="btn btn-danger"> lihat semua artikel</a>
                        </div>

                       </div>

                       </div>
                        </form>
                    </div>
                </div><!-- /.box -->
      </section><!-- /.content -->
  </aside><!-- /.right-side -->


  <!-- jQuery 2.0.2 -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
 <!-- CK-Editor  -->
 <script src="//cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo $siteurl;?>/view/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo $siteurl;?>/view/js/AdminLTE/app.js" type="text/javascript"></script>
   <!-- Bootstrap WYSIHTML5 -->
  <script src="<?php echo $siteurl;?>/view/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
  <script type="text/javascript">
 if ( typeof CKEDITOR == 'undefined' ){
 document.write(
    'CKEditor not found');
 }else{
 var editor = CKEDITOR.replace( 'editor1' );
 CKFinder.setupCKEditor( editor, '' ) ;
 }
 </script>


 </body>
 </html>
