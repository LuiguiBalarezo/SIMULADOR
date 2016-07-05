<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ManagerPagination {
    
    var $CI;

	public function __construct() {
		parent::__construct();
        $this->CI =& get_instance();
		$this->CI->load->library('pagination');
	}

	public function upload($file, $name, $mainPath) {
		$pathUploadFile = "/".$mainPath;

		if (!file_exists(".".$pathUploadFile)) {
			if(!mkdir(".".$pathUploadFile, 0777, true)) {
		        die('Fallo al crear las carpetas...');
			}
		}

		// $pathUpload = ".".$pathUploadFile.basename($_FILES["$file"]['name']).".png";
		$pathUpload = ".".$pathUploadFile.$name.".png";
		// $fullPath = "http://".$_SERVER["HTTP_HOST"]."/AlliNight".$pathUploadFile.basename($_FILES["$file"]['name']);
		// $fullPath = base_url().$pathUploadFile.basename($_FILES["$file"]['name']);
		// $fullPath = base_url().$mainPath.$_FILES["$file"]['name'];
		$fullPath = base_url().$pathUploadFile.$name.".png";
		
		if (move_uploaded_file($_FILES["$file"]['tmp_name'], $pathUpload)) {
		    //  echo "Success";
			// rename($pathUpload, $pathUpload.".png");
		} else{
		    // echo "Error";
		}

		return $fullPath;
	}

}