<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'C_Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
| ------------------------------
| URL -> LOGIN
| ------------------------------
*/
$route['home']					= 'C_Home';
$route['admin']					= 'admin/C_Admin';
$route['admin/signIn']			= 'C_Home/signIn';
$route['admin/signOut']			= 'C_Home/signOut';

/*
| ------------------------------
| URL -> USUARIOS 
| ------------------------------
*/
$route['admin/usuario']						= 'admin/C_Usuario';
$route['admin/usuario/page']                = 'admin/C_Usuario';
$route['admin/usuario/page/(:num)']         = 'admin/C_Usuario';
$route['admin/usuario/agregar']				= 'admin/C_Usuario/agregar';
$route['admin/usuario/crear']				= 'admin/C_Usuario/insertarUsuario';
$route['admin/usuario/(:num)']    			= 'admin/C_Usuario/editar/$1';
$route['admin/usuario/editar']    			= 'admin/C_Usuario/actualizarUsuario';
$route['admin/usuario/delete']    			= 'admin/C_Usuario/eliminarUsuario';
$route['admin/usuario/generatePassword']    = 'admin/C_Usuario/ajaxGeneratePassword';


/*
| ------------------------------
| URL -> TIPO DE USUARIO 
| ------------------------------
*/

$route['admin/tipousuario']			       = 'admin/C_Tipo_Usuario';
$route['admin/tipousuario/page']           = 'admin/C_Tipo_Usuario';
$route['admin/tipousuario/page/(:num)']    = 'admin/C_Tipo_Usuario';
$route['admin/tipousuario/agregar']		   = 'admin/C_Tipo_Usuario/agregar';
$route['admin/tipousuario/crear']		   = 'admin/C_Tipo_Usuario/insertar';
$route['admin/tipousuario/(:num)']    	   = 'admin/C_Tipo_Usuario/editar/$1';
$route['admin/tipousuario/editar']    	   = 'admin/C_Tipo_Usuario/actualizar';
$route['admin/tipousuario/delete']    	   = 'admin/C_Tipo_Usuario/eliminar';

/*
| ------------------------------
| URL -> OPERACION
| ------------------------------
*/

$route['admin/operacion']			       = 'admin/C_Operacion';
$route['admin/operacion/page']             = 'admin/C_Operacion';
$route['admin/operacion/page/(:num)']      = 'admin/C_Operacion';
$route['admin/operacion/agregar']		   = 'admin/C_Operacion/agregar';
$route['admin/operacion/crear']		       = 'admin/C_Operacion/insertar';
$route['admin/operacion/(:num)']    	   = 'admin/C_Operacion/editar/$1';
$route['admin/operacion/editar']    	   = 'admin/C_Operacion/actualizar';
$route['admin/operacion/delete']    	   = 'admin/C_Operacion/eliminar';

/*
| ------------------------------
| URL -> OPERACION POR USUARIO
| ------------------------------
*/

$route['admin/operacionusuario/(:num)']			      = 'admin/C_OperacionUsuario/operacionusuario/$1';
$route['admin/operacionusuario/(:num)/page']          = 'admin/C_OperacionUsuario/operacionusuario/$1';
$route['admin/operacionusuario/(:num)/page/(:num)']   = 'admin/C_OperacionUsuario/operacionusuario/$1';
$route['admin/operacionusuario/(:num)/agregar']		  = 'admin/C_OperacionUsuario/agregar/$1';
$route['admin/operacionusuario/crear']		          = 'admin/C_OperacionUsuario/insertar';
$route['admin/operacionusuario/delete']    	          = 'admin/C_OperacionUsuario/eliminar';

/*
| ------------------------------
| URL -> PLACAS
| ------------------------------
*/
$route['admin/placas/(:num)']                    = 'admin/C_Placa/placas/$1';
$route['admin/placas/(:num)/page']               = 'admin/C_Placa/placas/$1';
$route['admin/placas/(:num)/page/(:num)']        = 'admin/C_Placa/placas/$1';
$route['admin/placas/(:num)/agregar']	         = 'admin/C_Placa/agregar/$1';
$route['admin/placas/crear']		             = 'admin/C_Placa/insertar';
$route['admin/placas/edit/(:num)']    	         = 'admin/C_Placa/editar/$1';
$route['admin/placas/editar']    	             = 'admin/C_Placa/actualizar';
$route['admin/placas/delete']    	             = 'admin/C_Placa/eliminar';

/*
| ------------------------------
| URL -> RUTAS
| ------------------------------
*/
$route['admin/rutas/(:num)']                     = 'admin/C_Ruta/rutas/$1';
$route['admin/rutas/(:num)/page']                = 'admin/C_Ruta/rutas/$1';
$route['admin/rutas/(:num)/page/(:num)']         = 'admin/C_Ruta/rutas/$1';
$route['admin/rutas/(:num)/agregar']	         = 'admin/C_Ruta/agregar/$1';
$route['admin/rutas/crear']		                 = 'admin/C_Ruta/insertar';
$route['admin/rutas/edit/(:num)']    	         = 'admin/C_Ruta/editar/$1';
$route['admin/rutas/editar']    	             = 'admin/C_Ruta/actualizar';
$route['admin/rutas/delete']    	             = 'admin/C_Ruta/eliminar';


/*
| ------------------------------
| URL -> TRAMOS
| ------------------------------
*/
$route['admin/tramos/(:num)']                   = 'admin/C_Tramo/tramos/$1';
$route['admin/tramos/(:num)/page']              = 'admin/C_Tramo/tramos/$1';
$route['admin/tramos/(:num)/page/(:num)']       = 'admin/C_Tramo/tramos/$1';
$route['admin/tramos/(:num)/agregar']	        = 'admin/C_Tramo/agregar/$1';
$route['admin/tramos/crear']		            = 'admin/C_Tramo/insertar';
$route['admin/tramos/edit/(:num)']    	        = 'admin/C_Tramo/editar/$1';
$route['admin/tramos/editar']    	            = 'admin/C_Tramo/actualizar';
$route['admin/tramos/delete']    	            = 'admin/C_Tramo/eliminar';


/*
| ------------------------------
| URL -> EVENTO RIESGO
| ------------------------------
*/
/*
$route['admin/eventoriesgo']			        = 'admin/C_EventoRiesgo';
$route['admin/eventoriesgo/page']               = 'admin/C_EventoRiesgo';
$route['admin/eventoriesgo/page/(:num)']        = 'admin/C_EventoRiesgo';
$route['admin/eventoriesgo/agregar']		    = 'admin/C_EventoRiesgo/agregar';
$route['admin/eventoriesgo/crear']		        = 'admin/C_EventoRiesgo/insertar';
$route['getRutas']    	                        = 'admin/C_EventoRiesgo/getRutas';
$route['getPlacas']    	                        = 'admin/C_EventoRiesgo/getPlacas';
$route['getTramos']    	                        = 'admin/C_EventoRiesgo/getTramos';
$route['getCategorias']    	                    = 'admin/C_EventoRiesgo/getCategorias';
$route['getTipos']    	                        = 'admin/C_EventoRiesgo/getTipos';
*/
/*
| ------------------------------
| URL -> EVENTO RIESGO ADMIN
| ------------------------------
*/
/*
$route['admin/eventoriesgos']			    = 'admin/C_ListadoEventos/all';
$route['admin/eventoriesgos/page']			= 'admin/C_ListadoEventos/all';
$route['admin/eventoriesgos/page/(:num)']	= 'admin/C_ListadoEventos/all';
$route['admin/eventoriesgos/delete']		= 'admin/C_ListadoEventos/eliminar';
*/
/*
| ------------------------------
| URL -> EVENTO
| ------------------------------
*/
/*
$route['admin/evento']			                = 'admin/C_Evento';
$route['admin/evento/page']                     = 'admin/C_Evento';
$route['admin/evento/page/(:num)']              = 'admin/C_Evento';
$route['admin/evento/agregar']		            = 'admin/C_Evento/agregar';
$route['admin/evento/crear']		            = 'admin/C_Evento/insertar';
$route['admin/evento/(:num)']    	            = 'admin/C_Evento/editar/$1';
$route['admin/evento/editar']    	            = 'admin/C_Evento/actualizar';
$route['admin/evento/delete']    	            = 'admin/C_Evento/eliminar';
$route['admin/evento/generatecodigo']           = 'admin/C_Evento/ajaxGenerateCodigo';
*/
/*
| ------------------------------
| URL -> CATEGORIA
| ------------------------------
*/
$route['admin/categoria/(:num)']                     = 'admin/C_Categoria/categoria/$1';
$route['admin/categoria/(:num)/page']                = 'admin/C_Categoria/categoria/$1';
$route['admin/categoria/(:num)/page/(:num)']         = 'admin/C_Categoria/categoria/$1';
$route['admin/categoria/(:num)/agregar']	         = 'admin/C_Categoria/agregar/$1';
$route['admin/categoria/crear']		                 = 'admin/C_Categoria/insertar';
$route['admin/categoria/edit/(:num)']    	         = 'admin/C_Categoria/editar/$1';
$route['admin/categoria/editar']    	             = 'admin/C_Categoria/actualizar';
$route['admin/categoria/delete']    	             = 'admin/C_Categoria/eliminar';
$route['admin/categoria/generatecodigo']             = 'admin/C_Categoria/ajaxGenerateCodigo';

/*
| ------------------------------
| URL -> TIPO
| ------------------------------
*/
$route['admin/tipo/(:num)']                         = 'admin/C_Tipo/tipo/$1';
$route['admin/tipo/(:num)/page']                    = 'admin/C_Tipo/tipo/$1';
$route['admin/tipo/(:num)/page/(:num)']             = 'admin/C_Tipo/tipo/$1';
$route['admin/tipo/(:num)/agregar']	                = 'admin/C_Tipo/agregar/$1';
$route['admin/tipo/crear']		                    = 'admin/C_Tipo/insertar';
$route['admin/tipo/edit/(:num)']    	            = 'admin/C_Tipo/editar/$1';
$route['admin/tipo/editar']    	                    = 'admin/C_Tipo/actualizar';
$route['admin/tipo/delete']    	                    = 'admin/C_Tipo/eliminar';
$route['admin/tipo/generatecodigo']                 = 'admin/C_Tipo/ajaxGenerateCodigo';

/*
| ------------------------------
| URL -> GRAFICOS ESTADISTICOS
| ------------------------------
*/
$route['admin/piramide']			                = 'admin/C_Grafico/piramide';
$route['admin/comportamiento']			            = 'admin/C_Grafico/pastel';
$route['admin/excelP']			                    = 'admin/C_Grafico/getDataPiramide';
$route['admin/excelC']			                    = 'admin/C_Grafico/getDataComportamiento';


/*
| ------------------------------
| URL -> BACKUP
| ------------------------------
*/
$route['admin/backup']			                = 'admin/C_Backup/hacer_backup';




/*
| ------------------------------
| URL -> NOT FOUND PAGE
| ------------------------------
*/
$route['not-found/store']   = 'C_Not_Found/store';
$route['not-found/company'] = 'C_Not_Found/company';
$route['forbidden-access']  = 'C_Forbidden_Access';

/*
| ------------------------------
| URL -> API REST
| ------------------------------
*/
$route['api-rest/signIn']                                               = 'api-rest/C_Api_Rest_Session/signIn';
$route['api-rest/evento/getAllData']                                    = 'api-rest/C_Api_Rest_Evento/getAllData';
$route['api-rest/evento/registrarEvento']                               = 'api-rest/C_Api_Rest_Evento/registrarEvento';
$route['api-rest/evento/getEventosPiramide']                            = 'api-rest/C_Api_Rest_Evento/getEventosPiramide';
$route['api-rest/evento/getEventosPiramideExportarExcel']               = 'api-rest/C_Api_Rest_Evento/getEventosPiramideExportarExcel';
$route['api-rest/evento/getEventosComportamientoSeguro']                = 'api-rest/C_Api_Rest_Evento/getEventosComportamientoSeguro';
$route['api-rest/evento/getEventosComportamientoSeguroExportarExcel']   = 'api-rest/C_Api_Rest_Evento/getEventosComportamientoSeguroExportarExcel';
