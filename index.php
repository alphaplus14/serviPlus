<?php 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//conexion a la base de datos
require_once 'modelo/MySQL.php';
session_start();
if (!isset($_SESSION['cargo'])){
  header("location: ./controller/login.php");
  exit();
}
$rol= $_SESSION['cargo'];
$nombre=$_SESSION['nombre_usuario'];
$foto=$_SESSION['fotoPerfil'];
$fecha=$_SESSION['fecha'];



$mysql = new MySQL();
$mysql->conectar();
//consulta para obtener las personas
$resultado=$mysql->efectuarConsulta("SELECT empleados.id,empleados.foto, empleados.nombre, empleados.identificacion, cargo.nombre AS cargo, departamento.nombre AS area, empleados.fecha, empleados.salario, empleados.estado, empleados.correo, empleados.telefono FROM empleados inner join cargo on empleados.cargo_id = cargo.id  inner join departamento on empleados.departamento_id = departamento.id");

$consultaCargo = $mysql->efectuarConsulta("SELECT nombre FROM cargo WHERE id='$rol'");
$cargoUsuario = $consultaCargo->fetch_assoc()['nombre'] ?? 'Sin cargo';





?>

<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> ServiPlus</title>

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant"
    />
    <!--end::Primary Meta Tags-->

    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="./css/adminlte.css" as="style" />
    <!--end::Accessibility Features-->

    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- Estilo propio -->
     <link rel="stylesheet" href="./css/style.css">

    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />

    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables + Bootstrap -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables núcleo -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<!-- Integración Bootstrap 5 -->
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<!-- Extensión Responsive (versión compatible 2.5.0) -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<!-- Extensión Column Control (si de verdad la usas) -->
<link href="https://cdn.datatables.net/columncontrol/1.1.0/css/columnControl.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/columncontrol/1.1.0/js/dataTables.columnControl.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="index.php" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block">
              <a href="index.php" class="nav-link">Home</a>
            </li>
            
          </ul>
          <!--end::Start Navbar Links-->

          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">

            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="<?php echo $foto ?>"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline"> <?php echo $nombre; ?> </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                  <img
                    src="<?php echo $foto ?>"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                  <p>
                    <?php 
                    echo $nombre.'-'.$cargoUsuario;
                    ?>
                    <small> <?php echo 'since '.$fecha; ?> </small>
                  </p>
                </li>
                <!--end::User Image-->
                <!--begin::Menu Body-->
                
                <!--end::Menu Body-->
                <!--begin::Menu Footer-->
                
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar verde shadow">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.php" class="brand-link">
            <!--begin::Brand Image-->
           
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="title"> ServiPlus</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
              <li class="nav-item">
                <a href="./index.php" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                    
                  </p>
                  </a>
              
              <?php if($rol == 2): ?>
              <li class="nav-item">
                <a href="./views/generar.php" class="nav-link">
                  <i class="bi bi-file-earmark-pdf"></i>    
                  <p>
                   Documentos 
                   
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./views/graficos.php" class="nav-link">
                 <i class="bi bi-bar-chart"></i>  
                  <p>
                    Graficos
                   
                  </p>
                </a>
              </li>
              <?php endif; ?>

              <li class="nav-header">Log Out</li>
              <li class="nav-item">
                <a href="controller/logout.php" class="nav-link">
                  <i class="nav-icon bi bi-box-arrow-in-right logout-link "></i>
                  <p>
                    Cerrar Sesión
                   
                  </p>
                </a>
                
              </li>

            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Lista de Empleados</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Lista de Empleados</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row mb-3 align-items-center">
                <div class="col-md-6 d-flex gap-2">
                    <?php if($rol == 2): ?>
                     <button type="button" class="btn btn-success" onclick="agregarPersonas()">➕ Agregar Nueva Persona </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
              <!--begin::Col-->
                <div class="table-responsive">
                    <table id="tablaEmpleados" class="table table-striped table-bordered" width="100%">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Identificación</th>
                        <th>Cargo</th>
                        <th>Área/Departamento</th>
                        <th>Ingreso</th>
                        <th>Salario</th>
                        <th>Estado</th>
                        <th>Correo Electrónico</th>
                        <th>Teléfono</th>
                        <?php if($rol == 2): ?>
                            <th>Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['id']; ?></td>
                        <td> <img src="<?php echo $fila['foto']; ?>" width="50"> </td>
                        <td><?php echo $fila['nombre']; ?></td>
                        <td><?php echo $fila['identificacion']; ?></td>
                        <td><?php echo $fila['cargo']; ?></td>
                        <td><?php echo $fila['area']; ?></td>
                        <td><?php echo $fila['fecha']; ?></td>
                        <td><?php echo $fila['salario']; ?></td>
                        <td><?php echo $fila['estado']; ?></td>
                        <td><?php echo $fila['correo']; ?></td>
                        <td><?php echo $fila['telefono']; ?></td>
                        <?php if($rol == 2): ?>
                        <td>
                          <?php if($fila['estado']=="Activo"): ?>
                     <a class="btn btn-primary btn-sm"  title="editar" onclick="editarPersona(<?php echo $fila['id']; ?>)">
  <i class="bi bi-pencil-square"></i>
</a>

 <a class="btn btn-danger btn-sm"  
   href="javascript:void(0);" 
   onclick="eliminarEmpleado(<?php echo $fila['id']; ?>)" 
   title="Eliminar">
    <i class="bi bi-trash"></i>
</a>
<?php endif; ?>

                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
                </tbody>
                    </table>
                </div>
              <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2014-2025&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">ServiPlus</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="public/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

        // Disable OverlayScrollbars on mobile devices to prevent touch interference
        const isMobile = window.innerWidth <= 992;

        if (
          sidebarWrapper &&
          OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
          !isMobile
        ) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->

    <!-- jsvectormap -->
    <script
      src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
      integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
      integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
      crossorigin="anonymous"
    ></script>
<script>
$(document).ready(function() {
   $('#tablaEmpleados').DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
    },
    pageLength: 5,
    lengthMenu: [5, 10, 20, 50],
    responsive: true,
    autoWidth: true
});

});
</script>

<script>
        function agregarPersonas() {

        Swal.fire({
            title: 'Agregar Nueva Persona',
            html: `
                
                <form id="formAgregarPersona" class="text-start" action="agregar.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="documento" class="form-label">Número de documento</label>
                        <input type="text" class="form-control" id="documento" name="documento" required>
                    </div>
                    <div class="mb-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        <select class="form-select" id="cargo" name="cargo" required>
                            <option value="" disabled selected>Seleccione un cargo</option>
                            <?php
                            $consultaCargos = $mysql->efectuarConsulta("SELECT id, nombre FROM cargo");
                            while($fila=$consultaCargos->fetch_assoc()): ?>
                            <option value="<?php echo $fila['id'];?>"> <?php echo $fila['nombre'];?> </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Área o Departamento</label><br>
                        <?php
                        $consultaDepartamentos = $mysql->efectuarConsulta("SELECT id, nombre FROM departamento");
                        while($fila=$consultaDepartamentos->fetch_assoc()): ?>
                        <div class="form-check
    form-check-inline">
                                <input class="form-check-input" type="radio" name="area" value="<?php echo $fila['id']; ?>" required>
                                <label class="form-check-label"><?php echo $fila['nombre']; ?></label>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="mb-3">
                        <label for="salario" class="form-label">Salario</label>
                        <input type="number" class="form-control" id="salario" name="salario" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha de ingreso</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>   
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                       <div class="mb-3">
                        <label for="imagen" class="form-label">Foto Empleado</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept=".jpg,.jpeg,.png" required>    
                    </div>
                </form>

            `,
            //botones del alert
            confirmButtonText: 'Agregar',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            focusConfirm: false,
            preConfirm: () => {
              
            const nombre    = document.getElementById('nombre').value.trim();
            const password  = document.getElementById('password').value.trim();
            const documento = document.getElementById('documento').value.trim();
            const cargo     = document.getElementById('cargo').value.trim();
            const area      = document.querySelector('input[name="area"]:checked')?.value || '';
            const salario   = document.getElementById('salario').value.trim();
            const fecha     = document.getElementById('fecha').value.trim();
            const correo    = document.getElementById('correo').value.trim();
            const telefono  = document.getElementById('telefono').value.trim();
            const imagen    = document.getElementById('imagen').files[0];

            const formData = new FormData();
            formData.append("nombre", nombre);
            formData.append("password", password);
            formData.append("documento", documento);
            formData.append("cargo", cargo);
            formData.append("area", area);
            formData.append("salario", salario);
            formData.append("fecha", fecha);
            formData.append("correo", correo);
            formData.append("telefono", telefono);
            if (imagen) {
                formData.append("imagen", imagen);
            }
                // si los campos no estan llenos no retorna nada
                if (!nombre || !password || !documento || !cargo || !area || !salario || !fecha || !imagen) {
                    Swal.showValidationMessage('Por favor, complete todos los campos.');
                    return false;
                }
                // si todo esta bien, se retornan los valores
                return formData;
            }
        }).then((result) => {
            if (result.isConfirmed){
                const formData = result.value; 
                
                $.ajax({
    url: 'controller/agregarPersona.php',
    type: 'POST',
    data: formData,    
    contentType: false,   // necesario con FormData
    processData: false,   // necesario con FormData
    dataType: 'json',
    success: function(response){
        console.log("Respuesta del servidor:", response); // ya es JSON

        if (response.success) {
            // Caso de éxito
            Swal.fire('✅ Éxito!', response.message, 'success').then(() => {
                location.reload();
            });
        } else {
            // Caso de documento/correo repetido u otro error controlado
            Swal.fire('⚠️ Atención', response.message, 'warning');
        }
    },
    error: function(xhr, status, error){
        console.error("Error AJAX:", error, xhr.responseText);
        Swal.fire('❌ Error', 'El servidor no respondió correctamente.', 'error');
    }
});
                        
                    }
                });
            }
            
</script>
<script>

function editarPersona(id) {
    // Primero obtenemos los datos del empleado
    $.ajax({
        url: 'controller/info_empleado.php',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (!response.success) {
                Swal.fire('⚠️ Atención', response.message, 'warning');
                return;
            }

            const empleado = response.data;

            Swal.fire({
                title: 'Editar Persona',
                html: `
                    <form id="formEditarPersona" class="form-control" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Foto Empleado</label><br>
                            <img src="${empleado.foto}" width="60" class="img-fluid"><br>
                            <input type="file" class="form-control mt-2" id="imagen" name="imagen" accept=".jpg,.jpeg,.png">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre" value="${empleado.nombre}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña Antigua</label>
                            <input type="password" class="form-control" id="passwordOld" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña Nueva</label>
                            <input type="password" class="form-control" id="passwordNueva" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Número de documento</label>
                            <input type="text" class="form-control" id="documento" value="${empleado.documento}" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cargo</label>
                            <select class="form-control" id="cargo" required></select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Área o departamento</label><br>
                            <div id="areaContainer"></div>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Fecha de ingreso</label>
                            <input type="date" class="form-control" id="fecha" value="${empleado.fecha}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Salario base</label>
                            <input type="number" class="form-control" id="salario" value="${empleado.salario}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="correo" value="${empleado.correo}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono de contacto</label>
                            <input type="text" class="form-control" id="telefono" value="${empleado.telefono}" required>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                // para llenar cargos y departamentos cuando se abre el modal
                didOpen: () => {
                    // Llenar select de los  cargos
                    $.ajax({
                      url: 'controller/listarCargos.php',
                      type: 'GET',
                      dataType: 'json',
                      success: function(cargos) {
                          let select = $('#cargo'); // select es un objeto jQuery

                          cargos.forEach(cargo => {
                              let option = $('<option>')
                                  .val(cargo.id)            // value del option
                                  .text(cargo.nombre);      // nombre de cargo

                              if (cargo.id == empleado.cargo_id) {
                                  option.prop('selected', true); // marcar como seleccionado
                              }

                              select.append(option); // agregar al select 
                          });
                      }
                  });


                    // Llenar con un controlador
                    $.ajax({
                      url: 'controller/listarDepartamentos.php',
                      type: 'GET',
                      dataType: 'json',
                      success: function(departamentos) {
                          let contenedor = $('#areaContainer');

                          departamentos.forEach(dep => {
                              let div = $('<div>').addClass('form-check form-check-inline');

                              let input = $('<input>')
                                  .addClass('form-check-input')
                                  .attr('type', 'radio')
                                  .attr('name', 'area')
                                  .attr('value', dep.id)
                                  .prop('required', true);

                              if (dep.id == empleado.departamento_id) {
                                  input.prop('checked', true);
                              }

                              let label = $('<label>')
                                  .addClass('form-check-label')
                                  .text(dep.nombre);

                              div.append(input).append(label);
                              contenedor.append(div);
                          });
                      }
                  });

                },
                preConfirm: () => {
                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('nombre', $('#nombre').val().trim());
                    formData.append('passwordOld', $('#passwordOld').val().trim());
                    formData.append('passwordNueva', $('#passwordNueva').val().trim());
                    formData.append('cargo', $('#cargo').val());
                    formData.append('area', $('input[name="area"]:checked').val());
                    formData.append('salario', $('#salario').val());
                    formData.append('fecha', $('#fecha').val());
                    formData.append('correo', $('#correo').val().trim());
                    formData.append('telefono', $('#telefono').val().trim());
                    if ($('#imagen')[0].files[0]) {
                        formData.append('imagen', $('#imagen')[0].files[0]);
                    }
                    return formData;
                }
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'controller/editarPersona.php',
                        type: 'POST',
                        data: result.value,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) {
                                Swal.fire('✅ Éxito', res.message, 'success').then(() => location.reload());
                            } else {
                                Swal.fire('⚠️ Atención', res.message, 'warning');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('❌ Error', 'Error en el servidor', 'error');
                            console.error(error, xhr.responseText);
                        }
                    });
                }
            });
        },
        error: function() {
            Swal.fire('❌ Error', 'No se pudo cargar la información del empleado', 'error');
        }
    });
}

</script>

<script>
function eliminarEmpleado(id) {
  Swal.fire({
    title: "¿Deseas eliminar el empleado?",
    text: "No podrás revertir esto",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Eliminado!",
        text: "El empleado ha sido eliminado exitosamente.",
        icon: "success",
        timer: 2000,      // el tiempo que se demora en cerrar el alert 
        showConfirmButton: false
      }).then(() => {
        // Redirige al controlador de eliminar  cuando cierra el alert 
        window.location.href = "./controller/eliminar.php?id=" + id;
      });
    }
  });
}
</script>



  </body>
  <!--end::Body-->
</html>
