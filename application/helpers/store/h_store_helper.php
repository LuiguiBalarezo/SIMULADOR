<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('cargarDatosCategoriasPrincipales')) {

    function cargarDatosCategoriasPrincipales() {
        $CI =& get_instance();
        return $CI->M_Store->getPrimaryCategories($CI->uri->segment(2));
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('cargarDatosSubCategorias')) {

    function cargarDatosSubCategorias() {
        $CI =& get_instance();
        $dataSubCategorias = $CI->M_Store->getSubCategories(
            array(
                "id_empresa"            => $CI->uri->segment(2)
                
            )
        );
        return $dataSubCategorias;
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('cargarDatosSubCategoriaSeleccionada')) {

    function cargarDatosSubCategoriaSeleccionada($id_categoria_superior) {
        $CI =& get_instance();
        $dataSubCategorias = $CI->M_Store->getSubCategoriesSelected(
            array(
                "id_empresa"            => $CI->uri->segment(2),
                "id_categoria_superior" => $id_categoria_superior
            )
        );
        return $dataSubCategorias;
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('cargarDatosProductos')) {

    function cargarDatosProductos() {
        $CI =& get_instance();
        $dataProductos = $CI->M_Store->getProducts(
            array(
                "id_empresa"    => $CI->uri->segment(2),
                "id_tienda"     => $CI->uri->segment(4)
            )
        );
        return $dataProductos;
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('cargarDatosProductosbyCategory')) {

    function cargarDatosProductosbyCategory($id_categoria) {
        $CI =& get_instance();
        $dataProductos = $CI->M_Store->getProductsbyCategory(
            array(
                "id_empresa"    => $CI->uri->segment(2),
                "id_tienda"     => $CI->uri->segment(4),
                "id_categoria"  => $id_categoria
            )
        );
        return $dataProductos;
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('cargarDatosProducto')) {

    function cargarDatosProducto($idProducto) {
        $CI =& get_instance();
        $dataProductos = $CI->M_Store->getProduct(
            array(
                "id_empresa"    => $CI->uri->segment(2),
                "id_tienda"     => $CI->uri->segment(4),
                "id_producto"   => $idProducto
            )
        );
        return $dataProductos;
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('cargarDatosProductosConPromocion')) {

    function cargarDatosProductosConPromocion($id_categoria) {
        $CI =& get_instance();
        $dataProductos = $CI->M_Store->getProductsPromotion(
            array(
                "id_empresa"    => $CI->uri->segment(2),
                "id_tienda"     => $CI->uri->segment(4),
                "id_categoria"  => $id_categoria
            )
        );
        return $dataProductos;
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('cargarDatosProductoConPromocion')) {

    function cargarDatosProductoConPromocion($idProducto) {
        $CI =& get_instance();
        $dataProductos = $CI->M_Store->getProductPromotion(
            array(
                "id_empresa"    => $CI->uri->segment(2),
                "id_tienda"     => $CI->uri->segment(4),
                "id_producto"   => $idProducto
            )
        );
        return $dataProductos;
    }

}


// ------------------------------------------------------------------------

if ( ! function_exists('cargarGaleriaPorProducto')) {

    function cargarGaleriaPorProducto($producto) {
        $CI =& get_instance();
        $geleriaProducto = $CI->M_Store->getGalleryByProduct(
            array(
                "id_producto"    => $producto->id_producto
            )
        );

        if (sizeof($geleriaProducto) > 0) {
            $producto->galeria_producto = $geleriaProducto;
        } else {
            $galeria = new stdClass();
            $galeria->url_archivo = base_url().PATH_RESOURCE_ADMIN."img/image_not_found.png";
            $producto->galeria_producto = array($galeria);
        }
        return $producto;
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('validarListaCategorias')) {

    function validarListaCategorias($listaCategorias) {
        $CI =& get_instance();
        $listaCategorias = explode(".", $listaCategorias);
        foreach ($listaCategorias as $categoria) {
            $dataCategoria = $CI->M_Store->getCategorygetCategory(
                array(
                    "id_categoria"  => $categoria,
                    "id_empresa"    => $CI->uri->segment(2)
                )
            );
        }
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('generarNavegacionSubCategorias')) {

    function generarNavegacionSubCategorias($url_store, $listaIdCategorias, $tipoSubCategoria) {
        $CI =& get_instance();
        $lista = array();
        $urlIdCategorias = "";

        for ($c = 0; $c < sizeof($listaIdCategorias); $c++) {
            $dataCategoria = $CI->M_Store->getCategory(
                array(
                    "id_categoria"  => $listaIdCategorias[$c],
                    "id_empresa"    => $CI->uri->segment(2)
                )
            );

            if ($c == 0) {
                $urlIdCategorias .= $listaIdCategorias[$c];
            } else {
                $urlIdCategorias .= ".".$listaIdCategorias[$c];
            }

            if (sizeof($dataCategoria) > 0) {
                if ($tipoSubCategoria == "products") {
                    $dataCategoria[0]->url_id_categorias = $url_store."/categories/".$urlIdCategorias;
                } else if ($tipoSubCategoria == "promotions") {
                    $dataCategoria[0]->url_id_categorias = $url_store."/promotions/".$urlIdCategorias;
                }
                array_push($lista, $dataCategoria[0]);
            } else {
                $lista = array();
                break;
            }

        }
        return $lista;
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('generarUrlSubCategoria')) {

    function generarUrlSubCategoria($url_store, $id_categoria, $id_categoria_superior, $tipoSubCategoria) {
        $CI =& get_instance();
        $idCategoria         = $id_categoria;
        $idCategoriaSuperior = $id_categoria_superior;
        $urlIdCategorias     = intval($idCategoria);

        while ( $idCategoriaSuperior != 0 ) {
            $dataCategoria = $CI->M_Store->getCategory(
                array(
                    "id_categoria"          => $idCategoriaSuperior,
                    "id_empresa"            => $CI->uri->segment(2)
                )
            );

            if ( sizeof($dataCategoria) > 0 ) {
                $idCategoria            = intval($dataCategoria[0]->id_categoria);
                $idCategoriaSuperior    = intval($dataCategoria[0]->id_categoria_superior);
                $urlIdCategorias        = $idCategoria.".".$urlIdCategorias;
            } else {
                $urlIdCategorias = substr($urlIdCategorias, 1);
                $idCategoriaSuperior = 0;
            }
        }

        if ($tipoSubCategoria == "products") {
            $urlIdCategorias = $url_store."/categories/".$urlIdCategorias;
        } else if ($tipoSubCategoria == "promotions") {
            $urlIdCategorias = $url_store."/promotions/".$urlIdCategorias;
        }

        return $urlIdCategorias;
    }

}

// ------------------------------------------------------------------------
if ( ! function_exists('obtenerModificadorByID')) {
    function obtenerModificadorByID($idmodifier){
        $CI =& get_instance();
        $dataModifier = $CI->M_Store->getModifierByID(
            array(
                "id_modificador" => $idmodifier
            )
        );
        return $dataModifier[0];
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('configurarColorModificadores')) {

    function configurarColorModificadores($dataModifiers) {
        $paletaColores = array(
            "white"         => "#ffffff",
            "black"         => "#000000",
            "yellow"        => "#ffe100",
            "brown"         => "#4b320a",
            "purple"        => "#8f00ff",
            "pink"          => "#ff0074", // #ff007f
            "orange"        => "#ff5500",
            "red"           => "#eb1e1e",
            "green"         => "#12d63c",
            "blue"          => "#005fe5",
            "navy blue"     => "#000080",
            "gray"          => "#7c7c7c",
            "cyan"          => "#00ffff",
            "sky blue"      => "#37d2dc",
            "golden"        => "#b4af00",
            "gold"          => "#b4af00",
            "silver"        => "#e5e5e5",
            "mustard"       => "#b08101"
        );

        foreach ($dataModifiers as $modificador) {
            $tipo_modificador = trim(strtolower($modificador->tipo_modificador));
            $descripcion_modificador = trim(strtolower($modificador->descripcion_modificador));
            if ($tipo_modificador == "color") {
                foreach ($paletaColores as $nombreColor => $color) {
                    if ($nombreColor == $descripcion_modificador) {
                        $modificador->color_rgb = $color;
                    }
                }
            }
        }

        return $dataModifiers;
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('filtrarSubCategorias')) {

    function filtrarSubCategorias($dataSubCategorias) {
        $nuevaListaSubCategorias = array();
        for ( $c = 0; $c < sizeof($dataSubCategorias); $c++ ) {
            if ( intval($dataSubCategorias[$c]->nivel_categoria) != 1 ) { // Buscar Sub Categorias
                array_push($nuevaListaSubCategorias, $dataSubCategorias[$c]);
            }
        }
        return $nuevaListaSubCategorias;
    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('cargarLogoEmpresa')) {

    function cargarLogoEmpresa($modulo, $dataEmpresa) {
        $CI =& get_instance();
        $dataLogoEmpresa    = $CI->M_Archivo->getByID($dataEmpresa->id_archivo_logo);

        if (sizeof($dataLogoEmpresa) > 0) {
            $modulo->icono_empresa = $dataLogoEmpresa[0]->url_archivo;
        } else {
            $modulo->icono_empresa = PATH_RESOURCE_ADMIN."img/image_not_found.png"; // Colocar logo de store por defecto
        }
    }

}