<?php

use Illuminate\Database\Seeder;

class InitialColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$colors = [
    		[
    			"primary_color" 		=> "#037580",
    			"color_one" 			=> "#037580",
    			"color_two" 			=> "#008F7A",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#60c780",
    			"gradient" 				=> "linear-gradient(to right top, #037580, #007c81, #008280, #00897e, #008f7a)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%23037580&hex2=%23008F7A&sub=1
    		[
    			"primary_color" 		=> "#553055",
    			"color_one" 			=> "#431840",
    			"color_two" 			=> "#553055",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#547d78",
    			"gradient" 				=> "linear-gradient(to right top, #553055, #502a50, #4c244a, #471e45, #431840)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%23553055&hex2=%23431840&sub=1
    		[
    			"primary_color" 		=> "#1F7658",
    			"color_one" 			=> "#1D976C",
    			"color_two" 			=> "#1F7658",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#9aa766",
    			"gradient" 				=> "linear-gradient(to right top, #1d976c, #1e8f67, #1e8662, #1f7e5d, #1f7658)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%231D976C&hex2=%231F7658&sub=1
    		[
    			"primary_color" 		=> "#4F2422",
    			"color_one" 			=> "#6B2A2A",
    			"color_two" 			=> "#4F2422",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#61a998",
    			"gradient" 				=> "linear-gradient(to right top, #6b2a2a, #642928, #5d2726, #562624, #4f2422)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%23342D7A&hex2=%23291A3D&sub=1
    		[
    			"primary_color" 		=> "#4F2422",
    			"color_one" 			=> "#4F2422",
    			"color_two" 			=> "#990B05",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#60ab7b",
    			"gradient" 				=> "linear-gradient(to right top, #4f2422, #63211e, #751d19, #881611, #990b05)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%234F2422&hex2=%23990B05&sub=1
    		[
    			"primary_color" 		=> "#234357",
    			"color_one" 			=> "#405474",
    			"color_two" 			=> "#234357",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#6995b1",
    			"gradient" 				=> "linear-gradient(to right top, #405474, #38506d, #304c66, #29475e, #234357)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%23405474&hex2=%23234357&sub=1
    		[
    			"primary_color" 		=> "#494737",
    			"color_one" 			=> "#494737",
    			"color_two" 			=> "#46421F",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#847d40",
    			"gradient" 				=> "linear-gradient(to right top, #494737, #484631, #48452b, #474325, #46421f)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%23494737&hex2=%2346421F&sub=1
    		[
    			"primary_color" 		=> "#2C3E50",
    			"color_one" 			=> "#226DA6",
    			"color_two" 			=> "#2C3E50",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#a2b184",
    			"gradient" 				=> "linear-gradient(to right top, #226da6, #286190, #2b557a, #2d4964, #2c3e50)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%23226DA6&hex2=%232C3E50&sub=1
    		[
    			"primary_color" 		=> "#1F2427",
    			"color_one" 			=> "#45494E",
    			"color_two" 			=> "#1F2427",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#43551B",
    			"gradient" 				=> "linear-gradient(to right top, #45494e, #3b3f44, #31363a, #282d30, #1f2427)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%2345494E&hex2=%231F2427&sub=1
    		[
    			"primary_color" 		=> "#24777E",
    			"color_one" 			=> "#597F81",
    			"color_two" 			=> "#24777E",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#2a4e4b",
    			"gradient" 				=> "linear-gradient(to right top, #597f81, #4e7d80, #437b7f, #35797f, #24777e)"
    		]  // https://mycolor.space/gradient?ori=to+right+top&hex=%23597F81&hex2=%2324777E&sub=1
    	];
    	foreach( $colors as $color ){
    		$colorModel = new \App\Color();
    		$colorModel->fill($color)->save();
    	}
    }
}
