header("content-type:text/html; charset=utf-8");

require('workflows.php');


// Settings
define('OUROCG_QUERY_URL','http://www.ourocg.cn/Api/Search.aspx');
define('OUROCG_PIC_URL','http://p.ocgsoft.cn/');
define("OUROCG_WEB_URL" , "http://www.ourocg.cn/Cards/View-");


// Function for Post Request
function request_by_curl($remote_server,$post_string){
/*** $post_string = "app=request&version=beta"; ***/
/*** request_by_curl('http://facebook.cn/restServer.php',$post_string); ***/
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $remote_server);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$post_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Alfred Request');
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}


// Main Phrase

$wf = new Workflows();

$query = "{query}";
$json = json_decode(request_by_curl(OUROCG_QUERY_URL,"Key=".$query));


// Fetch Result

$i=0;

foreach ($json->data as $card):

	$result['name']	= $card->name;
	$result['cardType'] = $card->cardType;
	$result['ID'] = $card->ID;
	$result['url'] = OUROCG_WEB_URL.$result['ID'];
	$result['pic'] = OUROCG_PIC_URL.$result['ID'].'.jpg';

	if (strpos($result['cardType'],'怪兽')>0){
		$result['tribe']	= '种族:'.$card->tribe;
		$result['element']	= '属性:'.$card->element;
		$result['level']	= '星阶:'.$card->level;
		$result['atk'] = 'ATK:'.$card->atk;
		$result['def'] = 'DEF:'.$card->def;

		$wf->result($i, $result['url'], $result['name'], '【'.$result['cardType'].'】'.$result['element'].' / '.$result['tribe'].' / '.$result['level'].' / '.$result['atk'].' / '.$result['def'], 'cardback.jpg','yes');

	}else{
	}

	$i++;

endforeach;


// Export Results
echo $wf->toxml();