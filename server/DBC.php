<?php 
//login book unbook register
header('Access-Control-Allow-Origin:*');

 
class DBC {
	
	private $server = "localhost";
	private $dbuser = "Radiology-DBC";
	private $dbpass = "Radiology-DBC";
	private $dbname = "DBC";
 
    public function get() {  
    	$conn = new mysqli($this->server, $this->dbuser, $this->dbpass, $this->dbname);
        $stmt = $conn->prepare("SELECT `user`, `time`, `price`, `status`, `auth`, `broker` FROM `Trade` WHERE 1");
        $stmt->execute();
        $stmt->store_result();
        $return = array();
        $stmt->bind_result($user,$time,$price,$status,$auth,$broker);
        while ($stmt->fetch()){
        	$rawData = array('user'=>$user,'time'=>$time,'price'=>$price,'status'=>$status,'auth'=>$auth,'broker'=>$broker);
        	$return[] = $rawData;
        }
        $rawData = array('trade'=>$return);
        $response = $this->encodeJson($rawData);
        echo $response;

    }

    public function upload($user,$time,$price,$status,$auth,$broker){
        $conn = new mysqli($this->server, $this->dbuser, $this->dbpass, $this->dbname);
        $stmt_create = $conn->prepare("INSERT INTO `Trade`(`user`, `time` , `price`, `status`, `auth`, `broker`) VALUES (?,?,?,?,?,?)");
        $stmt_create ->bind_param("ssssss", $user,$time,$price,$status,$auth,$broker);
        if ($stmt_create->execute()){
            $rawData = array('msg'=>1);
            $response = $this->encodeJson($rawData);
            echo $response;
        }
    }

    public function landing($user){
    	$test ='GoodByCT';
        $conn = new mysqli($this->server, $this->dbuser, $this->dbpass, $this->dbname);
        $stmt = $conn->prepare("SELECT `auth`,`landing` FROM `Trade` WHERE `user` = 'GoodByCT'");
        //$stmt ->bind_param("s",$test);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($auth, $landing);
        $stmt->fetch();
        if ($landing < 4){
            $landing+=1;
            $stmt = $conn->prepare("UPDATE `Trade` SET `landing`=? WHERE `user`=?");
            $stmt -> bind_param('is',$landing,$user);
            $stmt->execute();
            $rawData = array ('msg' => $auth);
            $response = $this->encodeJson($rawData);
            echo $response;
        } else {
            $rawData = array ('msg' => 0);
            $response = $this->encodeJson($rawData);
            echo $response;
        }

    }
    
    public function encodeJson($responseData) {
        $jsonResponse = json_encode($responseData);
        return $jsonResponse;        
    }
    
    
}

?>