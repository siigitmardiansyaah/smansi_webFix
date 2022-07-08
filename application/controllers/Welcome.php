<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$long_smk = -6.253025502633878 *  0.0174532925;
		$lang_smk = 107.06103869673028 *  0.0174532925;
		$long_gps_d = -6.257362451100673 *  0.0174532925;
		$lang_gps_d = 107.04019560964578 *  0.0174532925;
		$x = ($long_smk - $long_gps_d) * cos(($lang_smk-$lang_gps_d)/2);
		$y = ($lang_smk - $lang_gps_d);
		$jarak = sqrt(($x * $x) + ($y * $y)) * 6371;
		$banding = floor($jarak * 1000);
		if($banding > 500)
		{
			echo 'kelebihan boss';
		}else{
			echo 'absen berhasil';
		}
	}
}
