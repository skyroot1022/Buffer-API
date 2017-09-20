<?
	session_start();
	require('buffer.php');

	$client_id = '';
	$client_secret = '';
	$access_token = '';
	
	
	$cmd = $_REQUEST['cmd'];	

	$buffer = new BufferApp($client_id, $client_secret, $access_token);

	switch($cmd) {
		case "/user":		
		case "/profiles":
			$user = $buffer->go("get", $cmd);
			break;

		case "/user/deauthorize":
			$user = $buffer->go("post", $cmd);
			break;

		case "/profiles/:id":
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$user = $buffer->go("get", '/profiles/'.$id);
			break;

		case "/profiles/:id/schedules":
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$user = $buffer->go("get", "/profiles/".$id."/schedules");
			break;

		case "/profiles/:id/schedules/update":
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$days = isset($_REQUEST['days'])?$_REQUEST['days']:"mon";
			$times = isset($_REQUEST['times'])?$_REQUEST['times']:"12:00";
			$user = $buffer->go("post", "/profiles/".$id."/schedules/update",array('schedules[0][days][]' => $days, 'schedules[0][times][]' => $times));
			break;

		case "/updates/:id":
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$user = $buffer->go("get", '/updates/'.$id);
			break;

		case "/profiles/:id/updates/pending":
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$user = $buffer->go('get', '/profiles/'.$id.'/updates/pending');
			break;

		case "/profiles/:id/updates/sent":
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$user = $buffer->go('get', '/profiles/'.$id.'/updates/sent');
			break;

		case "/profiles/:id/updates/reorder":
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$offset = isset($_REQUEST['offset'])?$_REQUEST['offset']:"10";
			$order = isset($_REQUEST['order'])?$_REQUEST['order']:"5995cc2fe1e07fa728ab5d1b";
			$user = $buffer->go('post', '/profiles/'.$id.'/updates/reorder', array("order[]"=>"3", "offset"=> 1, "utc"=> true));
			break;

		case "/profiles/:id/updates/shuffle":
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$count = isset($_REQUEST['count'])?$_REQUEST['count']:"10";
			$user = $buffer->go('post', '/profiles/'.$id.'/updates/shuffle', array("count" => "2", "utc" => true));
			break;

		case "/updates/create":
			$profile_ids = isset($_REQUEST['profile_ids'])?$_REQUEST['profile_ids']:"";
			$media_description = isset($_REQUEST['media_description'])?$_REQUEST['media_description']:"";
			$media_link = isset($_REQUEST['media_link'])?$_REQUEST['media_link']:"";
			$text = isset($_REQUEST['text'])?$_REQUEST['text']:"";
			$user = $buffer->go('post', '/updates/create', array("text"=>$text, "profile_ids[]"=>$profile_ids, "media[link]"=>$media_link, "media[description]"=>$media_description));
			break;

		case "/updates/:id/update":///////////////////////////
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$text = isset($_REQUEST['text'])?$_REQUEST['text']:"";
			$user = $buffer->go('post', '/updates/'.$id.'/update', array("text"=>$text));
			break;

		case "/updates/:id/share"://///////////////////////////
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$user = $buffer->go('post', '/updates/'.$id.'/share');
			break;

		case "/updates/:id/destroy":///////////////////////////////
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$user = $buffer->go('post', '/updates/'.$id.'/destroy');
			break;
		case "/updates/:id/move_to_top":////////////////////////////
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
			$user = $buffer->go('post', '/updates/'.$id.'/destroy');
			break;

		case "/links/shares":///////////////////////////////
			$url = isset($_REQUEST['url'])?$_REQUEST['url']:"";
			$user = $buffer->go('get', '/links/shares', array("url"=>$url));
			break;

		case "/info/configuration":////////////////////////////
			$user = $buffer->go('get', '/info/configuration');
			break;
	}
	
	echo json_encode($user);
