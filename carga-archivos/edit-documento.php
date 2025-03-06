<?php 
 $hoy=date("d");
 $fechaHoy=date("Y-M-D");
 session_start();
 include "modulos/conexion.php";
 include "modulos/validar.php";
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <style>
  .border {
    display: inline-block;
    width: 100px;
    height: 100px;
  }
  </style>
  <title>Prueba</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="dist/css/dropzone.css">
  <script type="text/javascript" src="dist/js/dropzone.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- SEARCH FORM -->
    

    <!-- Right navbar links -->

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" onclick="javascript:window.location.href='inicio.php'; return false;">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Web Juarez Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="javascript:window.location.href='inicio.php'; return false;">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="javascript:window.location.href='reg-documento.php'; return false;">
              <i class="nav-icon fa fa-book" ></i>
              <p>
                Registro de documentos
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="javascript:window.location.href='add-documento.php'; return false;">
              <i class="nav-icon fa fa-book"></i>
              <p>
                Registro de categoria
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="procesos/cerrar-sesion.php" class="nav-link" >
              <i class="nav-icon fa fa-user-times"></i>
              <p>
                Cerrar sesion
                
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid pt-5">
        
        
    
          
           
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body" style="display:flex; justify-content: center; align-items: center;">
                <div class="col-lg-6">
                <!--espacio del drag and drop-->
               <form class="dropzone mt-2 mb-5" id="formulariodocs" style="border: dashed; 4px dodgerblue; border-radius: 10px; color: dodgerblue;" enctype="multipart/form-data">
                   <div class="fallback">
                    <input type="file" name="file" id="documento"/>
                   </div>
               </form>
               <form action="procesos/editar.php" method="post">
               <div class="form-group">
                <label for="sel1">Categoria:</label>
                <select class="form-control" id="sel1" name="namecat">
                <?php
                   $cod_archivo=$_GET['cod_archivo'];
                   $consulta2 = "SELECT * FROM archivo WHERE cod_archivo='$cod_archivo'";
                   $resultado2 = mysqli_query($conexion,$consulta2);
                   $fila2 = mysqli_fetch_array($resultado2);
                  ?>
                <option><?=$fila2['nombre_cat'];?></option> 
                <?php
                   $consulta = "SELECT * FROM categoria ORDER BY cod_categoria ASC";
                   $resultado = mysqli_query($conexion,$consulta);
                   while($fila = mysqli_fetch_array($resultado)){
                  ?>
                
                  <option><?=$fila['nombre_cat']?></option>   
               
                <?php }?>
                </select>
                
            <input type="text" name="namearch" class="form-control mb-1 mt-1" id="nameform" value="<?=$fila2['nombre_archivo'];?>" readonly required>
            <input type="hidden" name="proceso" class="form-control mb-1 mt-1" id="nameform" value="Iniciar"  required>
            <input type="hidden" name="codarch" class="form-control mb-1 mt-1" id="nameform" value="<?=$fila2['cod_archivo'];?>"  required>
            <button class="btn btn-secondary col-lg-12 mb-1" type="button" onclick="fAgregar();">Agregar documento</button>
              
            <button class="btn btn-primary col-lg-12 mb-1" type="submit">Registro</button> 
             </form> 
            </div>
            <!--drop and drag -->
             
               
           </div>
            
          <div class="col-lg-6">
              <p>1) En el &#225;rea de "arrastrar y soltar" se puede o dar clic o arrastrar el documento a dicha &#225;rea.</p>
              <p>2) Posteriormente se debe seleccionar la categor&#237;a a la que pertenece el documento dando clic en el bot&#243;n desplegable.</p>
              <p>3) Luego se da clic en el bot&#243;n de agregar documento.</p>
              <p>4) Como paso final se da clic en el bot&#243;n de Registro para actualizar dicho documento.</p>
          </div>
              </div>
            </div>

            
          </div>
         
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="https://www.webjuarez.com">Web juarez</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
</script>

<script type="text/javascript">
    Dropzone.autoDiscover = false;
    
    $(function(){
        var myDropzone = new Dropzone(".dropzone", {
            url: "procesos/subir-post.php",
            paramName: "file",
            maxFilesize: 256,
            maxFiles: 1,
            acceptedFiles: "image/*,application/pdf,.zip,.rar*",
        });
    });    
</script>

<script type="text/javascript">
 function fAgregar()
    {
        document.getElementById("nameform").value=
            document.getElementById("namedz").innerText;
    }
</script>

</body>
</html>
