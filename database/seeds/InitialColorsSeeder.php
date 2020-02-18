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
    			"primary_color" 		=> "#642450",
    			"color_one" 			=> "#642450",
    			"color_two" 			=> "#AA5991",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#642450",
    			"gradient" 				=> "linear-gradient(to right top, #642450, #753160, #863e70, #984b80, #aa5991)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%23642450&hex2=%23AA5991&sub=1
    		[
    			"primary_color" 		=> "#3F5B00",
    			"color_one" 			=> "#1A3710",
    			"color_two" 			=> "#3F5B00",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#577f7c",
    			"gradient" 				=> "linear-gradient(to right top, #1a3710, #21400f, #2a490c, #345207, #3f5b00)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%231A3710&hex2=%233F5B00&sub=1
    		[
    			"primary_color" 		=> "#291A3D",
    			"color_one" 			=> "#342D7A",
    			"color_two" 			=> "#291A3D",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#87cac4",
    			"gradient" 				=> "linear-gradient(to right top, #342d7a, #34286a, #32235a, #2e1e4b, #291a3d)"
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
    			"primary_color" 		=> "#9B4028",
    			"color_one" 			=> "#9B6354",
    			"color_two" 			=> "#9B4028",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#b97d70",
    			"gradient" 				=> "linear-gradient(to right top, #9b6354, #9c5b49, #9c523e, #9c4933, #9b4028)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%239B6354&hex2=%239B4028&sub=1
    		[
    			"primary_color" 		=> "#051937",
    			"color_one" 			=> "#051937",
    			"color_two" 			=> "#43551B",
    			"text_color" 			=> "#FFFFFF",
    			"contrast_color" 		=> "#43551B",
    			"gradient" 				=> "linear-gradient(to right top, #051937, #002c46, #003d42, #004b2f, #43551b)"
    		], // https://mycolor.space/gradient?ori=to+right+top&hex=%23051937&hex2=%2343551B&sub=1
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
