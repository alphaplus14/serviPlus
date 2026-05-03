# ServiPlus

Sistema web de gestión de empleados orientado a **PHP** y **MySQL/MariaDB**, con interfaz basada en **AdminLTE** y **Bootstrap 5**. Permite iniciar sesión, consultar el personal en tablas interactivas y, para perfiles administrativos, administrar altas/bajas, generar reportes en PDF y visualizar gráficos estadísticos.

---

## Tabla de contenidos

- [Características](#características)
- [Stack tecnológico](#stack-tecnológico)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Estructura del proyecto](#estructura-del-proyecto)
- [Roles y permisos](#roles-y-permisos)
- [Base de datos](#base-de-datos)
- [Dependencias externas](#dependencias-externas)
- [Consideraciones](#consideraciones)

---

## Características

| Área | Detalle |
|------|---------|
| **Autenticación** | Login por número de documento y contraseña (`password_verify` con hash bcrypt). Sesiones PHP. Usuarios en estado **Inactivo** no pueden acceder. |
| **Dashboard** | Listado de empleados con **DataTables** (paginación, idioma español, responsive). |
| **Administración** (rol administrador) | Alta de empleados (formulario modal + AJAX), edición con validación de contraseña anterior, eliminación lógica/navegación a eliminación. |
| **Reportes** | Generación de listado en PDF por departamento o todos los activos (**FPDF**). |
| **Analítica** | Gráficos (ApexCharts vía vistas JS) por departamento y por cargo; datos expuestos como JSON desde controladores. |

---

## Stack tecnológico

- **Backend:** PHP (compatible con entorno XAMPP; el script SQL indica PHP 8.2.x).
- **Base de datos:** MySQL / MariaDB (UTF-8 / utf8mb4).
- **Cliente:** HTML5, CSS3, JavaScript.
- **UI:** AdminLTE 4, Bootstrap 5, Bootstrap Icons, OverlayScrollbars.
- **Librerías JS:** jQuery, DataTables, SweetAlert2, ApexCharts (CDN).
- **PDF:** FPDF (inclusión local esperada en `libs/fpdf/`).

---

## Requisitos

- [XAMPP](https://www.apachefriends.org/) (o equivalente: Apache + PHP + MariaDB/MySQL).
- PHP con extensiones habituales: `mysqli`, `session`, `password_hash` / `password_verify`.
- Navegador moderno.

---

## Instalación

1. **Clonar o copiar** el proyecto en la carpeta del servidor web, por ejemplo:
   `C:\xampp\htdocs\serviPlus`

2. **Crear la base de datos** en phpMyAdmin o consola MySQL:
   - Importar el archivo `DatabaseScript/serviplus.sql` para crear tablas, índices y datos de ejemplo.

3. **Dependencia PDF**  
   El archivo `views/generar_pdf.php` incluye `../libs/fpdf/fpdf.php`. Si la carpeta `libs/` no existe en tu copia del proyecto:
   - Descarga [FPDF](http://www.fpdf.org/) y coloca `fpdf.php` en `libs/fpdf/fpdf.php` (ajusta la ruta si usas otra convención).

4. **Arrancar servicios**  
   En XAMPP: **Apache** y **MySQL**.

5. **Acceso por navegador**  
   Ejemplo: `http://localhost/serviPlus/views/login.php`  
   El flujo de login redirige al `index.php` en la raíz del proyecto.

---

## Configuración

Los datos de conexión están en `modelo/MySQL.php`:

| Parámetro | Valor por defecto |
|-----------|-------------------|
| Servidor | `localhost` |
| Usuario | `root` |
| Contraseña | *(vacío en XAMPP por defecto)* |
| Base de datos | `serviplus` |

Ajusta estos valores si tu entorno usa otro host, usuario o nombre de BD.

### Fotos de perfil

Las rutas de imagen se guardan en base de datos (por ejemplo `assets/fotos/...`). Asegúrate de que existan las carpetas necesarias y permisos de escritura donde `agregarPersona.php` / `editarPersona.php` suban archivos.

---

## Estructura del proyecto

```
serviPlus/
├── index.php                 # Dashboard principal (lista empleados)
├── css/                      # AdminLTE + estilos propios
├── public/js/                # AdminLTE + scripts de gráficos
├── modelo/
│   ├── MySQL.php             # Conexión y consultas mysqli
│   └── usuarios.php          # Modelo simple de usuario (getter/setter)
├── controller/
│   ├── login.php / logout.php
│   ├── agregarPersona.php, editarPersona.php, eliminar.php
│   ├── info_empleado.php, listarCargos.php, listarDepartamentos.php
│   ├── empleadoController.php    # Datos para PDF según departamento
│   ├── datos_grafico.php, datos_graficoCargo.php
│   └── ...
├── views/
│   ├── login.php
│   ├── generar.php           # UI para disparar PDF
│   ├── generar_pdf.php       # Salida FPDF
│   ├── graficos.php, graficosDepartamento.php, graficosCargo.php
│   └── ...
├── DatabaseScript/
│   └── serviplus.sql         # Esquema y datos iniciales
└── libs/fpdf/                # Añadir manualmente si falta (ver instalación)
```

---

## Roles y permisos

La aplicación usa `$_SESSION['cargo']`, que coincide con `empleados.cargo_id` / `cargos.IDcargo`.

- **Todos los usuarios autenticados** pueden ver el **dashboard** con la tabla de empleados (según la consulta principal del `index.php`).
- **Rol administrador (`cargo_id === 2`)** tiene acceso en menú lateral a:
  - **Documentos** (`views/generar.php`) — reportes PDF.
  - **Gráficos** (`views/graficos.php` y vistas relacionadas).
  - Botones **Agregar**, **Editar** y **Eliminar** en la tabla principal.

Los demás cargos solo conservan vista del listado y **Cerrar sesión**.

> **Nota:** En `index.php`, la etiqueta del cargo en cabecera usa una consulta que selecciona `nombreCargo`; conviene usar la misma columna que en `views/generar.php` (`nombreCargo`) para evitar inconsistencias en el texto del rol mostrado.

---

## Base de datos

### Tablas principales

| Tabla | Descripción |
|-------|-------------|
| `empleados` | Datos del personal, FK a cargo y departamento, contraseña hasheada, imagen, estado. |
| `cargos` | Catálogo de cargos. |
| `departamentos` | Catálogo de áreas / departamentos. |

El volcado SQL incluye registros de ejemplo en `empleados`. Las contraseñas están almacenadas con **bcrypt**; para pruebas locales usa las credenciales que hayas definido al poblar la BD o crea un usuario nuevo desde el panel (rol administrador).

---

## Dependencias externas

La mayor parte de JS/CSS se carga por **CDN** (jQuery, Bootstrap, DataTables, SweetAlert2, ApexCharts, fuentes). Solo **FPDF** debe residir localmente según la ruta indicada arriba.

---

## Consideraciones

- **Seguridad:** Varias consultas concatenan valores directamente en SQL; en entornos de producción conviene migrar a **consultas preparadas** (`mysqli_prepare`) y revisar validación de entradas en todos los controladores.
- **Sesiones:** Varias vistas redirigen a `login.php` con rutas relativas distintas; unifica rutas si encuentras redirecciones inesperadas según desde qué carpeta se cargue la vista.
- **Entorno:** Proyecto pensado para desarrollo local con XAMPP; para producción habría que configurar HTTPS, credenciales seguras de BD y políticas de subida de archivos.

---

## Licencia y créditos UI

El proyecto usa plantillas y estilos **AdminLTE** (referencias en meta y pie de página del HTML). Conserva los créditos de terceros si redistribuyes la interfaz tal cual.

---

*README generado a partir del análisis del código del repositorio ServiPlus.*
