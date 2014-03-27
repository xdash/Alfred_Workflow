require('workflows.php');


// Settings
define('TRANS_QUERY_URL','http://openapi.baidu.com/public/2.0/bmt/translate?client_id=Vn8ockFtPxNM655RP4iVWixU&from=auto&to=auto&q=');


// Main Phrase

$wf = new Workflows();

$query = "{query}";
$json = json_decode($wf->request(TRANS_QUERY_URL.$query));


// Fetch Result

foreach ($json->trans_result as $translation):

	$result['src']	=	$translation->src;
	$result['dst']	=	$translation->dst;

	$wf->result(1, 'http://www.baidu.com',$result['dst'],$query,'icon.png','yes');

endforeach;


// Export Results
echo $wf->toxml();