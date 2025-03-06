<?php 
 $hoy=date("d");
 $fechaHoy=date("Y-M-D");
 session_start();
 include "modulos/conexion.php";
 include "modulos/validar.php";

 $busqueda = isset($_REQUEST['busqueda']) ? $_REQUEST['busqueda'] : '';
 $bus_date1 = isset($_REQUEST['date1']) ? $_REQUEST['date1'] : '';
 $bus_date2 = isset($_REQUEST['date2']) ? $_REQUEST['date2'] : ''; 

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
  
  <title>Prueba</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
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
      <span class="brand-text font-weight-light">Prueba</span>
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
     <div class="content">
      <div class="container-fluid pt-5">
        
        
        
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                  <form  method="get"> 
                   <div style="display:flex; justify-content: flex-start; align-items: flex-end; flex-wrap: wrap;">
                      <h5 class="card-title col-lg-12">Por nombre</h5>
                      
                       <div class="col-12 col-lg-6">
                           <div class="input-group col-12">
                            <input type="text" name="busqueda" id="busqueda" placeholder="Search.." class="form-control col-lg-6" >
                           <span class="input-group-btn">
                            <button class="btn btn-secondary" type="submit" name="search" class="btn btn-flat">
                             <i class="fa fa-search"></i>
                            </button>
                          </span>
                         </div>
                       </div>
                       
                       <form method="get">
                       <div class="col-12 col-lg-6" style="display:flex; justify-content: center; align-items: center; flex-wrap: wrap;">
                          
                           <h5 class="col-lg-12">Por fechas</h5>
                            <input class="col-lg-6" type="date" name="date1" class="form-control col-lg-6">
                           
                         
                            
                            <input class="col-lg-6" type="date" name="date2" class="form-control col-lg-6" >
                            <button type="submit" name="search" class="btn btn-block btn-primary">
                             <i class="fa fa-search"></i>
                            </button>
                           
                           
                       </div>
                       </form>
                   </div> 
                  </form>    
              </div>
              
            </div>

            
          </div>
         
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        
        
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body col-12">
                   <h5 class="card-title">Listado de archivos:</h5>     
              </div>
              <ul class="list-group">
                 
                  <?php
                  if(empty($busqueda) && empty($bus_date1)&&empty($bus_date2) or empty($busqueda)&&empty($bus_date1)&&!empty($bus_date2) or empty($busqueda)&&!empty($bus_date1)&&empty($bus_date2)){  
                   $consulta = "SELECT * FROM archivo ORDER BY cod_archivo DESC";
                   $resultado = mysqli_query($conexion,$consulta);
                   while($fila = mysqli_fetch_array($resultado)){
                  ?>
                  <li class="list-group-item"><span type="text" class="float-left" ><?=$fila['nombre_archivo']?></span><div class="col-lg-7 float-left"><p class="col-12" id="copy<?=$fila['cod_archivo'];?>">http://localhost/carga-archivos/documentos/<?=$fila['nombre_archivo']?></p></div><div class="float-right col-12 col-md-2
                  " style="display: flex; justify-content: center; align-items: center;
                  ">
                  <a href="documentos/<?=$fila['nombre_archivo']?>" target="_blank"><i class="fa fa-download pr-3" data-toggle="tooltip" title="descargar"></i></a>
                  <a href="edit-documento.php?cod_archivo=<?=$fila['cod_archivo'];?>"><i class="fa fa-edit"data-toggle="tooltip" title="editar"></i></a>
                      <button  class="btn" data-clipboard-target="#copy<?=$fila['cod_archivo'];?>"><a href="inicio.php"data-toggle="tooltip" title="copiar"><i class="fa fa-copy"></i></a></button>
                      <button  data-toggle="modal" data-target="#borrar"style="background: transparent;  border: 0;"><a href="#" data-toggle="tooltip" title="borrar"><i class="fa fa-trash" ></i></a></button>
                  </div>
                       <div class="modal" id="borrar">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header bg-danger">
          <h4 class="modal-title text-center">¿Seguro que desea borrar este elemento?</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body text-center bg-danger">
         <img src="https://image.flaticon.com/icons/svg/497/497738.svg" class="col-5"/>
          <h4>Esta accion no puede ser revertida</h4>
          <button type="button" class="btn btn-light btn-block" onclick="javascript:window.location.href='procesos/borrar-archivo.php?cod_archivo=<?=$fila['cod_archivo'];?>'">Borrar</button>
        </div>
            
      </div>
    </div>
  </div>
                  </li>
                  
                  <?php }}elseif(!empty($busqueda)){
                    $consulta = "SELECT * FROM archivo WHERE nombre_archivo LIKE '%$busqueda%' OR nombre_cat LIKE '%$busqueda%' ORDER BY cod_archivo DESC";
                   $resultado = mysqli_query($conexion,$consulta);
                   while($fila = mysqli_fetch_array($resultado)){
                    ?>   
                  <li class="list-group-item"><span type="text" class="float-left" ><?=$fila['nombre_archivo']?></span><div class="col-lg-7 float-left"><p class="col-12"  id="copy<?=$fila['cod_archivo'];?>">http://localhost/carga-archivos/documentos/<?=$fila['nombre_archivo']?></p></div><div class="float-right col-12 col-md-2
                  " style="display-felx; justify-center; align-items-center;
                  ">
                  <a href="documentos/<?=$fila['nombre_archivo']?>"><i class="fa fa-download pr-3"></i></a>
                  <a href="edit-documento.php?cod_archivo=<?=$fila['cod_archivo'];?>"><i class="fa fa-edit"></i></a>
                      <button  class="btn" data-clipboard-target="#copy<?=$fila['cod_archivo'];?>"><a href="inicio.php"><i class="fa fa-copy"></i></a></button>
                  <button  data-toggle="modal" data-target="#borrar" style="background: transparent;  border: 0;"><a href="#"><i class="fa fa-trash"></i></a></button>
                  </div>
                       <div class="modal" id="borrar">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header bg-danger">
          <h4 class="modal-title text-center">¿Seguro que desea borrar este elemento?</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body text-center bg-danger">
         <img src="https://image.flaticon.com/icons/svg/497/497738.svg" class="col-5"/>
          <h4>Esta accion no puede ser revertida</h4>
          <button type="button" class="btn btn-light btn-block" onclick="javascript:window.location.href='procesos/borrar-archivo.php?cod_archivo=<?=$fila['cod_archivo'];?>'">Borrar</button>
        </div>
            
      </div>
    </div>
  </div>
                  </li>
                <?php
                       
                  }}elseif(!empty($bus_date1)&&!empty($bus_date2)){
                      $consulta = "SELECT * FROM archivo WHERE fecha BETWEEN '$bus_date1' AND '$bus_date2' ORDER BY cod_archivo DESC";
                   $resultado = mysqli_query($conexion,$consulta);
                   while($fila = mysqli_fetch_array($resultado)){
                ?>
                  <li class="list-group-item"><span type="text" class="float-left" ><?=$fila['nombre_archivo']?></span><div class="col-lg-7 float-left"><p class="col-12"  id="copy<?=$fila['cod_archivo'];?>">http://localhost/carga-archivos/documentos/<?=$fila['nombre_archivo']?></p></div><div class="float-right col-12 col-md-2
                  " style="display-felx; justify-center; align-items-center;
                  ">
                  <a href="documentos/<?=$fila['nombre_archivo']?>"><i class="fa fa-download pr-3"></i></a>
                  <a href="edit-documento.php?cod_archivo=<?=$fila['cod_archivo'];?>"><i class="fa fa-edit"></i></a>
                      <button  class="btn" data-clipboard-target="#copy<?=$fila['cod_archivo'];?>"><a href="inicio.php"><i class="fa fa-copy"></i></a></button>
                     <button  data-toggle="modal" data-target="#borrar" style="background: transparent; border: 0;"><a href="#"><i class="fa fa-trash"></i></a></button>
                  </div>
                       <div class="modal" id="borrar">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header bg-danger">
          <h4 class="modal-title text-center">¿Seguro que desea borrar este elemento?</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body text-center bg-danger">
         <img src="https://image.flaticon.com/icons/svg/497/497738.svg" class="col-5"/>
          <h4>Esta accion no puede ser revertida</h4>
          <button type="button" class="btn btn-light btn-block" onclick="javascript:window.location.href='procesos/borrar-archivo.php?cod_archivo=<?=$fila['cod_archivo'];?>'">Borrar</button>
        </div>
            
      </div>
    </div>
  </div>
                  </li>
                <?php               
                  } }
                  ?>
                  
                </ul> 
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
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
<script type="text/javascript">
    
    var clipboard = new ClipboardJS('.btn');
    
    </script>
</body>
</html>
