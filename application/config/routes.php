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
| URL -> panel cliente
| ------------------------------
*/

$route['/panel']                    = 'panel/C_panel';
$route['/panel/perfil']             = 'panel/C_panel/perfil';
$route['/panel/estudio/']           = 'panel/C_panel/estudio';
$route['/panel/cienpreguntas/']     = 'panel/C_panel/cienpreguntas';
$route['/panel/completo/']          = 'panel/C_panel/completo';
$route['/panel/bibliografia/']      = 'panel/C_panel/bibliografia';
$route['/panel/manual/']            = 'panel/C_panel/manual';
$route['/panel/soporte/']           = 'panel/C_panel/soporte';
$route['/panel/licencia/']          = 'panel/C_panel/licencia';


/*
| ------------------------------
| URL -> panel
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
/*
$route['admin/tipousuario']			       = 'admin/C_Tipo_Usuario';
$route['admin/tipousuario/page']           = 'admin/C_Tipo_Usuario';
$route['admin/tipousuario/page/(:num)']    = 'admin/C_Tipo_Usuario';
$route['admin/tipousuario/agregar']		   = 'admin/C_Tipo_Usuario/agregar';
$route['admin/tipousuario/crear']		   = 'admin/C_Tipo_Usuario/insertar';
$route['admin/tipousuario/(:num)']    	   = 'admin/C_Tipo_Usuario/editar/$1';
$route['admin/tipousuario/editar']    	   = 'admin/C_Tipo_Usuario/actualizar';
$route['admin/tipousuario/delete']    	   = 'admin/C_Tipo_Usuario/eliminar';
*/
/*$route['/panel
| ------------------------------
| URL -> OPERACION
| ------------------------------
*/
/*
$route['admin/operacion']			       = 'admin/C_Operacion';
$route['admin/operacion/page']             = 'admin/C_Operacion';
$route['admin/operacion/page/(:num)']      = 'admin/C_Operacion';
$route['admin/operacion/agregar']		   = 'admin/C_Operacion/agregar';
$route['admin/operacion/crear']		       = 'admin/C_Operacion/insertar';
$route['admin/operacion/(:num)']    	   = 'admin/C_Operacion/editar/$1';
$route['admin/operacion/editar']    	   = 'admin/C_Operacion/actualizar';
$route['admin/operacion/delete']    	   = 'admin/C_Operacion/eliminar';
*/


