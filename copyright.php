<?php

//設定
$ccver = "4.0";		//pd,cc0に関してはver1.0を使用
$pdver = "1.0";
$zerover = "1.0";
$ccbt = "88x31.png"; //大きいアイコン
//$ccbt = "80x15.png"  小さいアイコン
$exp = "2";  //1:日本語文章での正式な表示　2：英略記

//第一引数の入力値と返還後一覧
$lcs = array(
	"pd" => "publicdomain",
	"cc0" => "zero",
	"by" => "by",
	"by-sa" => "by-sa",
	"by-nd" => "by-nd",
	"by-nc" => "by-nc",
	"by-nc-sa" => "by-nc-sa",
	"by-nc-nd" => "by-nc-nd",
	"c" => "c",
	"-1" => "publicdomain",
	"0" => "zero",        //cc0
	"1" => "by",
	"2" => "by-sa",
	"3" => "by-nd",
	"4" => "by-nc",
	"5" => "by-nc-sa",
	"6" => "by-nc-nd",
	"9" => "c",           //通常の著作権
	);
//第四引数の入力値と返還後一覧
$fmts = array(
	"0" => "",				//複数、不明
	"1" => "Sound",			//オーディオ
	"2" => "MovingImage",	//動画
	"3" => "StillImage",	//画像
	"4" => "Text",			//テキスト
	"5" => "Dataset",		//データセット
	"6" => "InteractiveResource"	//インタラクティブ
	);
//名称表示用
$ccnames = array(
	"by" => "表示",
	"by-sa" => "表示-継承",
	"by-nd" => "表示-改変禁止",
	"by-nc" => "表示-非営利",
	"by-nc-sa" => "表示-非営利-継承",
	"by-nc-nd" => "表示-非営利-改変禁止",
	);


//$exp === 1 (正式記法)
function cprt_exp1($cpid, $workttl, $author, $format, $workurl, $morepermurl, $f1, $f2, $orgurl){
	global $ccver, $pdver, $zerover, $ccbt, $exp, $lcs, $fmts, $ccnames;
//$codeに必要な文字列を追加していく。最終的に$codeを出力
$code = "";

//元になる作品があった場合
if($orgurl !=  ""){
	$orgn = "<br />本作品は<a xmlns:dct=\"http://purl.org/dc/terms/\" href=\"{$originurl}\" rel=\"dct:source\">こちらの作品({$originurl})</a>を基にして作られています。";
}else{
	$orgn = "";
};

//public domain（著作権切れ等）の時
if($cpid == "publicdomain"){
	//button 
	$code = "<p xmlns:dct=\"http://purl.org/dc/terms/\"><a rel=\"license\" href=\"http://creativecommons.org/publicdomain/mark/{$pdver}/\"><img src=\"http://i.creativecommons.org/p/mark/{$pdver}/{$ccbt}\" style=\"border-style: none;\" alt=\"Public Domain Mark\" /></a><br />";
	//文章
    $code .= "本作品（<span resource=\"[_:creator]\" rel=\"dct:creator\"><span property=\"dct:title\">{$author}</span></span>)による作品『<span property=\"dct:title\">｛$workttl｝</span>』）には確認可能な限りで著作権法上の制約が存在しません。</p>";
	$code .= $orgn;
}
//cc0(著作権者による権利放棄)の時
elseif($cpid == "zero"){
    //button
	$code = "<p xmlns:dct=\"http://purl.org/dc/terms/\" xmlns:vcard=\"http://www.w3.org/2001/vcard-rdf/3.0#\"><a rel=\"license\" href=\"http://creativecommons.org/publicdomain/zero/{$zerover}/\"><img src=\"http://i.creativecommons.org/p/zero/{$zerover}/{$ccbt}\" style=\"border-style: none;\" alt=\"CC0\" /></a><br />";
    //文章
	$code .= "法のもとで可能な限り、<a rel=\"dct:publisher\" href=\"{$workurl}\"><span property=\"dct:title\">{$author}</span></a>は本作品<span property=\"dct:title\">{$workttl}</span>(公開国：<span property=\"vcard:Country\" datatype=\"dct:ISO3166\" content=\"JP\" about=\"{$workurl}\">日本</span>)に関する著作権及び隣接権の一切を放棄します。</p>";
	$code .= $orgn;
}
//C(著作権を保持）の時
elseif($cpid == "c"){
	$code = "<span property=\"dct:title\">{$workttl}</span>: copyright <a rel=\"dct:publisher\" href=\"{$workurl}\"><span property=\"dct:title\">{$author}</span></a> All rights reserved.";
	$code .= $orgn;
	//許可
	$code .= "<br />本作品の利用の可能性については以下のアドレスもご覧下さい。 <a xmlns:cc=\"http://creativecommons.org/ns#\" href=\"{$morepermurl}\" rel=\"cc:morePermissions\">{$morepermurl}</a>";
}
//CCの時
else{
    $ccname = $ccnames[$cpid];
	//btn
	$code = "<a rel=\"license\" href=\"http://creativecommons.org/licenses/{$cpid}/{$ccver}/\"><img alt=\"クリエイティブ・コモンズ・ライセンス\" style=\"border-width:0\" src=\"https://i.creativecommons.org/l/{$cpid}/{$ccver}/{$ccbt}\" /></a>";
	//著者名
	$code .= "<br /><a href=\"{$workurl}\"><span xmlns:cc=\"http://creativecommons.org/ns#\"property=\"cc:attributionName\">{$author}</span>による作品";
	//作品名
	$code .= "『<span xmlns:dct=\"http://purl.org/dc/terms/\" {$f1} property=\"dct:title\" {$f2}>{$workttl}</span>』</a>は";
	//ライセンス
	$code .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/{$lcid}/{$ccver}/\">クリエイティブ・コモンズ {$ccname} {$ccver} 国際 ライセンス</a>で提供されています。";
	$code .= $orgn;
	//さらなる許可
	if($morepermurl != "" && $num){
		$code .= "<br />このライセンスで許諾される範囲を超えた利用の可能性については以下のアドレスもご覧下さい。 <a xmlns:cc=\"http://creativecommons.org/ns#\" href=\"{$morepermurl}\" rel=\"cc:morePermissions\">{$morepermurl}</a>";
	}
}
 return $code;
//関数終わり
};

//$exp === ２ (英略記法)
function cprt_exp2($cpid, $workttl, $author, $format, $workurl, $morepermurl, $f1, $f2, $orgurl){
	global $ccver, $pdver, $zerover, $ccbt, $exp, $lcs, $fmts, $ccnames;
//$codeに必要な文字列を追加していく。最終的に$codeを出力
$code = "";

//元になる作品があった場合
if($orgurl !=  ""){
	$orgn = "(Based on a work at <a xmlns:dct=\"http://purl.org/dc/terms/\" href=\"{$originurl}\" rel=\"dct:source\">{$originurl}</a>)";
}else{
	$orgn = "";
};

//許可URL
if($morepermurl !=  ""){
	$perm = "<a xmlns:cc=\"http://creativecommons.org/ns#\" href=\"{$morepermurl}\" rel=\"cc:morePermissions\">(contact)</a>";
}else{
	$perm = "";
};

//public domain（著作権切れ等）の時
if($lcid == "publicdomain"){
	//button 
	$code = "<p xmlns:dct=\"http://purl.org/dc/terms/\"><a rel=\"license\" href=\"http://creativecommons.org/publicdomain/mark/{$pdver}/\"><img src=\"http://i.creativecommons.org/p/mark/{$pdver}/{$ccbt}\" style=\"border-style: none;\" alt=\"Public Domain Mark\" /></a>";
	//explains
    $code .= "『<span property=\"dct:title\">｛$workttl｝</span>』{$orgn} by <span resource=\"[_:creator]\" rel=\"dct:creator\"><span property=\"dct:title\">{$author}</span></span> is free of known copyright restrictions.";
}
//cc0(著作権者による権利放棄)の時
elseif($lcid == "zero"){
	//button 
	$code = "<p xmlns:dct=\"http://purl.org/dc/terms/\" xmlns:vcard=\"http://www.w3.org/2001/vcard-rdf/3.0#\"><a rel=\"license\" href=\"http://creativecommons.org/publicdomain/zero/{$zerover}/\"><img src=\"http://i.creativecommons.org/p/zero/{$zerover}/{$ccbt}\" style=\"border-style: none;\" alt=\"CC0\" /></a>";
	$code .= "<span property=\"dct:title\">{$workttl}</span>{$orgn} by <a rel=\"dct:publisher\" href=\"{$workurl}\"><span property=\"dct:title\">{$author}</span></a> No rights reserved. (Published from <span property=\"vcard:Country\" datatype=\"dct:ISO3166\" content=\"JP\" about=\"{$workurl}\">Japan</span> )";
}
//C(著作権を保持）の時
elseif($lcid == "c"){
	$code = "<span property=\"dct:title\">{$workttl}</span>{$orgn}: copyright <a rel=\"dct:publisher\" href=\"{$workurl}\"><span property=\"dct:title\">{$author}</span></a> All rights reserved. {$perm}";
}
//CC
else{
	//btn
	$code = "<a rel=\"license\" href=\"http://creativecommons.org/licenses/{$cpid}/{$ccver}/\"><img alt=\"クリエイティブ・コモンズ・ライセンス\" style=\"border-width:0\" src=\"https://i.creativecommons.org/l/{$cpid}/{$ccver}/{$ccbt}\" /></a>";
	//作品名
	$code .= "<a href=\"{$workurl}\">『<span xmlns:dct=\"http://purl.org/dc/terms/\" {$f1} property=\"dct:title\" {$f2}>{$workttl}</span>』";
	//著者名
	$code .= "by <span xmlns:cc=\"http://creativecommons.org/ns#\" property=\"cc:attributionName\">{$author}</span></a> {$perm}";
}
return $code;
//関数終わり
};


//関数定義
function cprt(){
	global $ccver, $pdver, $zerover, $ccbt, $exp, $lcs, $fmts, $ccnames;

   $num = func_num_args(); //引数の数を出力
   if($num >= 8){
     return "error: too much args";
   }elseif($num <= 5){
   	 return "error: need more args";
   }else{

	//変数取得
	//入力変数（必須）
	$cpid = func_get_arg(0);
	//どのライセンスか。とりうる値は以下。
	//"pd", "cc0", "by", "by-sa", "by-nd", "by-nc", "by-nc-sa", "by-nc-nd", "c",
	//"-1", "0", "1", "2", "3", "4", "5", "6", "9"
	$workttl = func_get_arg(1); //作品タイトル
	$author = func_get_arg(2);	//著作権者
	$format = func_get_arg(3);	//フォーマット
	$workurl = func_get_arg(4);		//作品のクレジット用URL
	$morepermurl = func_get_arg(5);	//許可外の使用を希望する際に確認すべきURL
    //入力変数（補足）
    if($num = 7){
    $orgurl = func_get_arg(6);	//元になった作品のURL(改変の場合等)
    }else{
    $orgurl = "";
    }

    //変数処理
    $cpid = $lcs[$cpid];
    $format = $fmts[$format];
    if($format == ""){
    	$f1 = "";
    	$f2 = "";
    }else{
	    $f1 = "href=\"http://purl.org/dc/dcmitype/{$fomat}\"";
	    $f2 = "rel=\"dct:type\"";
	}
    if($exp == "1"){
    	return cprt_exp1($cpid, $workttl, $author, $format, $workurl, $morepermurl, $f1, $f2, $orgurl);
    }elseif($exp == "2"){
    	return cprt_exp2($cpid, $workttl, $author, $format, $workurl, $morepermurl, $f1, $f2, $orgurl);
    }else{
        return "error: something wrong with choosing exp.";
    }
   }
};