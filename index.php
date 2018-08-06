<?php
ini_set('max_execution_time', '0');
set_time_limit(0);
ignore_user_abort (true);
//error_reporting(E_ALL);
require_once ('phpQuery.php');
require_once('PHPExcel.php');
require_once('PHPExcel/Writer/Excel5.php');
require_once('PHPExcel/IOFactory.php');
	function get_content($url){
		
		define('DOMAIN','m.avito.ru');
		define('SCHEME','https://');
		
		$contentPage = "";
		//$url = "https://m.avito.ru/stavropolskiy_kray/nedvizhimost?s_trg=3";//kaliningrad/kvartiry/1-k_kvartira_30.6_m_25_et._979450294";
		$referer = "https://www.yandex.ru/?yclid=".rand(0, 100).rand(0, 100).rand(0, 100).rand(0, 100).rand(0, 100);
		
		$headers = [
			'Host: m.avito.ru',
			'Upgrade-Insecure-Requests: 1',
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
			'Content-Type: text/html; charset=utf-8',
			//'Transfer-Encoding: chunked',
			'Connection: keep-alive',
			'Keep-Alive: timeout=75',
			'Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
			'Cookie: u=21vmd2no.n9j660.f6wvmteb71; _ym_uid=14714265131042248860; __gads=ID=abdce9bfb52a4f31:T=1471609884:S=ALNI_Man9QAeuZ6Tl3tkxrGSUGG6wcNWTA; dfp_group=16; weborama-viewed=1; f=4.b53ee41b77d9840ae5ba07059b0d202f6e619f2005f5c6dc6e619f2005f5c6dc6e619f2005f5c6dc6e619f2005f5c6dc6e619f2005f5c6dc6e619f2005f5c6dc6e619f2005f5c6dc6e619f2005f5c6dc6e619f2005f5c6dc6e619f2005f5c6dc5b68b402642848be5b68b402642848bead33eaef55dd0da15b68b402642848be44620aa09dfab02de75a2b007093b89d05886bb864a616652f4891ba472e4f2618dc79c78ea31ba1ea48e2d99c5312aaffe65fd77b784b7bffe65fd77b784b7bb8a109ce707ef6137c6d6c44a42cb1c70176a16018517b5da399e993193588ae728b89f8cc435269728b89f8cc435269728b89f8cc435269728b89f8cc435269ffe65fd77b784b7b862357a052e106f23f601feec47f73646b10d486f2e98b94bbdd84537b03ad770afd39af11174777efa5660fd55a65b968eae11c327fbc017e3896e0dc5507a54fe26563f7e70342b3db510bee0b105f2878bfba0574374f5b68b402642848be5b68b402642848beec8be4370a6135b1dca1b47b9709106b31ad00aa0bbae7adb817e52b74497bd1; _ym_isad=1; nfh=2be1f7c16dcf4b7be36a84c5eded50d7; _ga=GA1.2.64612684.1471426513; _gid=GA1.2.56430582.1495885618; nps_sleep=1; __utmt=1; anid=removed; sessid=ba5227935cff55ff872b4e7e339801d6.1495906334; v=1495906269; crtg_rta=cravadb240%3D1%3B; __utma=99926606.64612684.1471426513.1495887691.1495906259.182; __utmb=99926606.7.9.1495906326960; __utmc=99926606; __utmz=99926606.1495216859.178.58.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided)',
			'X-XSS-Protection: 1; mode=block',
			'X-Content-Type-Options: nosniff',		
		    'Referer: ' . str_replace(SCHEME . DOMAIN, '', $url)
			//'Referer: https://m.avito.ru/moskva/uslugi?p=17&sgtd=1&q=%D0%BC%D0%B0%D1%81%D1%82%D0%B5%D1%80+%D0%BC%D0%B0%D0%BD%D0%B8%D0%BA%D1%8E%D1%80%D0%B0+%D0%B8+%D0%BF%D0%B5%D0%B4%D0%B8%D0%BA%D1%8E%D1%80%D0%B0',
		];
		$cookie = dirname(__FILE__) . "/cookie.txt";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);	
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);		
		curl_setopt($ch, CURLOPT_REFERER, $referer);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36'); 	
		curl_setopt($ch, CURLOPT_COOKIESESSION, $url);
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($cookie) );
		curl_setopt($ch, CURLOPT_COOKIEFILE, realpath($cookie) );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_ENCODING, 'utf-8');
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		//echo $contentPage = curl_exec($ch);
		$contentPage = curl_exec($ch);
        curl_close($ch);
        return $contentPage;
    }

$strMax = 10;
$pageElement = 50;
function getSinglePage($n,$numPage)
{
    //$mainurl = 'https://m.avito.ru/stavropolskiy_kray/kvartiry/prodam?s_trg=10';
    $mainurl = 'https://m.avito.ru/stavropolskiy_kray/nedvizhimost?';
    $dom = phpQuery::newDocument(get_content($mainurl . "&p=$numPage"));
//$blocks= $dom->find('article.b-item.js-catalog-item-enum.item-highlight');
    $blocks = $dom->find('section.b-content-main');

    foreach ($blocks as $block) {
        $pq = pq($block);
        //$el =  $pq->find('a.item-link.item-link-visited-highlight')->text();
        $href = $pq->find('div.b-item-wrapper.visited-highlight-wrapper')->html();
        $doc = new DOMDocument();
        @$doc->loadHTML($href);
        $ahreftags = $doc->getElementsByTagName('a');
        $j = 0;
        foreach ($ahreftags as $tag) {
            $tags[$j] = $tag->getAttribute('href');
            $j++;
        }
        $k = count($tags);
        $description = $pq->find('a.item-link.item-link-visited-highlight')->getString();
        $bind = 2;
        for ($i = 0; $i < $k; $i++) {
            $domdoc = phpQuery::newDocument(get_content('https://m.avito.ru' . $tags[$i]));
            $contents = $domdoc->find('article.b-single-item');
            //get_content('https://m.avito.ru'.$tags[$i]);
            $mob_href = $domdoc->find('a.action-show-number')->attr('href');
            $mob_phone = get_content('https://m.avito.ru'.$mob_href.'?async');
            //var_dump($mob_content);
            foreach ($contents as $content) {
                $pqContent = pq($content);
                //$id = 1;
                $type = $pqContent->find('span.text.text-main')->getString();
                $desc = $pqContent->find('header.single-item-header.b-with-padding')->getStrings();
                $param = $pqContent->find('span.param.param-last')->getString();
                $price = $pqContent->find('span.price-value')->getString();
                $date = $pqContent->find('div.item-add-date')->getString();
                $address = $pqContent->find('span.info-text.user-address-text')->getString();
                $addressString = $address;
                //$CITY_TYPE = '';
                var_dump($type);
                $text = $address[0];

                $main_str = $text;

                $pos4 = strpos($main_str, 'посёлок') !== false;
                $pos = strpos($main_str, 'пос.') !== false;
                $pos1 = strpos($main_str, 'п.') !== false;
                $pos3 = strpos($main_str, 'сдт') !== false;
                $town = strpos($main_str, 'г.') !== false;
                $town1 = strpos($main_str, 'город') !== false;

                if ($pos && $town) {
                    $CITY_TYPE='003';
                } else {
                    if ($pos or $pos1 or $pos3 or $pos4) {
                        $CITY_TYPE='003';
                    } elseif ($town or $town1) {
                        $CITY_TYPE='002';
                    } else {
                        $CITY_TYPE='002';
                    }
                }
                $address = explode(",", $address[0]);
                //$time = $pqContent->find('div.item-add-date')->attr('data-date');
                $bind++;
            }
//var_dump($address);
            $filename = 'avito.xlsx';
            global $obj;
            if (file_exists($filename)) {
                $objPHPExcel = PHPExcel_IOFactory::load($filename);
            } else {
                $objPHPExcel = new PHPExcel();
                $page = $objPHPExcel->setActiveSheetIndex(0);
                $page->setCellValue("A1", "ID");
                $page->setCellValue("B1", "TYPE_CODE");
                $page->setCellValue("C1", "ABOUT");
                $page->setCellValue("D1", "DEAL_DATE");
                $page->setCellValue("E1", "DEAL_PRICE");
                $page->setCellValue("F1", "CITY_TYPE");
                $page->setCellValue("G1", "REGION");
                $page->setCellValue("H1", " ADDRESS");
//                $page->setCellValue("H1", "ADDRESS");
//                $page->setCellValue("I1", "1");
                $page->setCellValue("I1", "PHONE");
                $page->setCellValue("J1", "REF");
            }
//            if (trim($param[0])=='Квартиры'){
//                $param[0]='2001003000';
//                $PURPOSE_CODE = '204004000000';
//            }
//            if ($param[0]=='Дома, дачи, коттеджи'){
//                $param[0]='2001001000';
//            }
            $obj = [trim($n), trim($param[0]),trim($type[0]), $date[0], trim($price[0]),$CITY_TYPE, '26',trim($addressString[0]),$mob_phone,'https://m.avito.ru' . $tags[$i]];
            //$obj = [trim($n), trim($param[0]), $date[0], trim($price[0]),$CITY_TYPE, '26',trim($address[1]),trim($address[0]),'улица',$mob_phone,'https://m.avito.ru' . $tags[$i]];
            var_dump($obj);
            $objPHPExcel->getActiveSheet(0)->fromArray($obj, NULL, 'A' . $n);

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($filename);

            $n++;
        }
    }
}

//function getads_avito_www($url,$html)
//{
/*    $pattern = "'<div class=\"item.{1,100} id=\"i(?<avito_id>.{7,12})\".*?<h3 .*? href=\"(?<href>.*?)\".*?>(?<title>.*?)</a>.*?<div class=\"about\">(?<price>.*?)<.*?v>(?<details>.*?)<div class=\"date c-2\">(?<data>.*?)</div>'si";*/
//
//    $titre=preg_match_all($pattern, $html, $ads) ;
//    unset($ads[0]);
//    for ($i=0;$i<count($ads["price"]);$i++)
//    {
//        $ads["price"][$i]=preg_replace('/[^\d]+/', '',$ads["price"][$i]);
//        $ads["href"][$i]="https://www.avito.ru".$ads["href"][$i];
//        $ads["details"][$i]=strip_tags($ads["details"][$i]);
//    }
//    return $ads;
//}
//$mainurl = 'https://m.avito.ru/stavropolskiy_kray/nedvizhimost?';
//$e = getads_avito_www('https://m.avito.ru/kislovodsk/kvartiry/1-k_kvartira_35_m_23_et._638865793',get_content('https://m.avito.ru/kislovodsk/kvartiry/1-k_kvartira_35_m_23_et._638865793'));
//var_dump($mainurl,$e);
$t=2;
$str=1;
$max = 50;
while($t<$max)
{
    getSinglePage($t,$str);
    $t=$t+23;
    $str++;
}
	
