<?php
class Model_Ajax extends Model
{

	public function get_data()
	{
		echo "get out";
	}


	public function dimension()
	{
		if( isset($_POST['width']) && isset($_POST['height']) ){

			setcookie("width", $_POST['width'], time() + 10000000, '/');
			setcookie("height", $_POST['height'], time() + 10000000, '/');
		} else {
			echo "<script>alert(2)</script>";
		}
	}
}
