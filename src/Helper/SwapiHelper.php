<?php

/*
 * Helper class that connects with end-points of the api SWAPI
 */
class SwapiHelper {

    /**
     * @var mysqli
    */
    protected $mysqli;

    public function __construct() {

        $configContents = file_get_contents(dirname(__DIR__,2)."/config/config.json");
        $config = json_decode($configContents, true);
        $host = $config["parameters"]["database_host"];
        $user = $config["parameters"]["database_user"];
        $pass = $config["parameters"]["database_password"];
        $db = $config["parameters"]["database_name"];

        $this->mysqli = new mysqli($host, $user, $pass, $db);

        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
         } 

    }

    /**
     * @param String $id;
     * @return String
    */
    function getVehicle(String $id){

        $url = "https://swapi.py4e.com/api/vehicles/".$id."/";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result=curl_exec($ch);
        curl_close($ch);
    
        $vehicleInfo = json_decode($result, true);

        if( isset( $vehicleInfo['detail'] ) ){
            if($vehicleInfo['detail']=="Not found"){
                $vehicleInfo['additionalData'] = ["error"=>true, "msj"=>"Vehicle not found!!!"];
                return json_encode($vehicleInfo);
            }
        }
   
        $stmt = $this->mysqli->prepare("SELECT * FROM vehicle where vehicle_id = ?");
        $stmt->bind_param('i',$id);
        $result = $stmt->execute();
        $result = $stmt->get_result(); 
        $vehicle = $result->fetch_assoc(); 
        $stmt->close();
    
    
        $total = $vehicle['total'];
    
        if ($result->num_rows == 0){
            $total = 0;
            //Insert new vehicle
            $sql = "INSERT INTO vehicle ".
                   "(vehicle_id,total) "."VALUES ".
                   "('$id','$total')";
    
            $result = $this->mysqli->query($sql);
        }
           
        $this->mysqli->close();
        $vehicleInfo['additionalData'] = ["id"=>$id,"total"=>$total,"error"=>false,"msj"=>null];
        $jsonData = json_encode($vehicleInfo);
    
        return $jsonData;
    }

    /**
     * @param String $id;
     * @param String $amount;
     * @return String
    */
    function setTotalVehicle(String $id, String $amount){

        $stmt = $this->mysqli->prepare("SELECT * FROM vehicle where vehicle_id = ?");
        $stmt->bind_param('i',$id);
        $result = $stmt->execute();
        $result = $stmt->get_result(); 
        $vehicle = $result->fetch_assoc(); 
        $stmt->close();
    
        $total = $amount;
    
        if ($result->num_rows > 0){
            //Update total units
            $sql = 'UPDATE vehicle SET total='.$total.' where vehicle_id='.$id;
            $result = $this->mysqli->query($sql);
        }
           
        $this->mysqli->close();
    
        $starshipInfo['additionalData'] = ["error"=>false,"msj"=>"Vehicle updated successfully","total"=>$total];
        $jsonData = json_encode($starshipInfo);
        
        return $jsonData;
    }

    /**
     * @param String $id;
     * @param String $amount;
     * @return String
    */
    function incrementTotalVehicle(String $id, String $amount){

        $stmt = $this->mysqli->prepare("SELECT * FROM vehicle where vehicle_id = ?");
        $stmt->bind_param('i',$id);
        $result = $stmt->execute();
        $result = $stmt->get_result(); 
        $vehicle = $result->fetch_assoc(); 
        $stmt->close();
    
        $total = $vehicle['total'] + $amount;
    
        if ($result->num_rows > 0){
            $sql = 'UPDATE vehicle SET total='.$total.' where vehicle_id='.$id;
            $result = $this->mysqli->query($sql);
        }
           
        $this->mysqli->close();
    
        $starshipInfo['additionalData'] = ["error"=>false,"msj"=>"Vehicle updated successfully","total"=>$total];
        $jsonData = json_encode($starshipInfo);
        
        return $jsonData;
    }

    /**
     * @param String $id;
     * @param String $amount;
     * @return String
    */
    function decrementTotalVehicle(String $id, String $amount){

        $stmt = $this->mysqli->prepare("SELECT * FROM vehicle where vehicle_id = ?");
        $stmt->bind_param('i',$id);
        $result = $stmt->execute();
        $result = $stmt->get_result(); 
        $vehicle = $result->fetch_assoc(); 
        $stmt->close();
    
        $total = $vehicle['total'] - $amount;

        if($total < 0){
            $total = 0;
        }
    
        if ($result->num_rows > 0){
            $sql = 'UPDATE vehicle SET total='.$total.' where vehicle_id='.$id;
            $result = $this->mysqli->query($sql);
        }
           
        $this->mysqli->close();
    
        $starshipInfo['additionalData'] = ["error"=>false,"msj"=>"Vehicle updated successfully","total"=>$total];
        $jsonData = json_encode($starshipInfo);
        
        return $jsonData;
    }

    /**
     * @param String $id;
     * @return String
    */
    function getStarship(String $id){

        $url = "https://swapi.py4e.com/api/starships/".$id."/";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result=curl_exec($ch);
        curl_close($ch);
    
        $starshipInfo = json_decode($result, true);

        if( isset( $starshipInfo['detail'] ) ){
            if($starshipInfo['detail']=="Not found"){
                $starshipInfo['additionalData'] = ["error"=>true, "msj"=>"Starship not found!!!"];
                return json_encode($starshipInfo);
            }
        }
    
        $stmt = $this->mysqli->prepare("SELECT * FROM starship where starship_id = ?");
        $stmt->bind_param('i',$id);
        $result = $stmt->execute();
        $result = $stmt->get_result(); 
        $starship = $result->fetch_assoc(); 
        $stmt->close();
    
    
        $total = $starship['total'];
    
        if ($result->num_rows == 0){
            $total = 0;
            //Insert new starship
            $sql = "INSERT INTO starship ".
                   "(starship_id,total) "."VALUES ".
                   "('$id','$total')";
    
            $result = $this->mysqli->query($sql);
        }
           
        $this->mysqli->close();
        $starshipInfo['additionalData'] = ["id"=>$id,"total"=>$total,"error"=>false,"msj"=>null];
        $jsonData = json_encode($starshipInfo);
    
        return $jsonData;
    }
    
    /**
     * @param String $id;
     * @param String $amount;
     * @return String
    */
    function setTotalStartship(String $id, String $amount){

        $stmt = $this->mysqli->prepare("SELECT * FROM starship where starship_id = ?");
        $stmt->bind_param('i',$id);
        $result = $stmt->execute();
        $result = $stmt->get_result(); 
        $starship = $result->fetch_assoc(); 
        $stmt->close();
    
        $total = $amount;
    
        if ($result->num_rows > 0){
            //Update starship total
            $sql = 'UPDATE starship SET total='.$total.' where starship_id='.$id;
            $result = $this->mysqli->query($sql);
        }
           
        $this->mysqli->close();
    
        $starshipInfo['additionalData'] = ["error"=>false,"msj"=>"Starship updated successfully","total"=>$total];
        $jsonData = json_encode($starshipInfo);
        
        return $jsonData;
    }

    /**
     * @param String $id;
     * @param String $amount;
     * @return String
    */
    function incrementTotalStartship(String $id, String $amount){

        $stmt = $this->mysqli->prepare("SELECT * FROM starship where starship_id = ?");
        $stmt->bind_param('i',$id);
        $result = $stmt->execute();
        $result = $stmt->get_result(); 
        $starship = $result->fetch_assoc(); 
        $stmt->close();
    
        $total = $starship['total'] + $amount;
    
        if ($result->num_rows > 0){
            //Update total units
            $sql = 'UPDATE starship SET total='.$total.' where starship_id='.$id;
            $result = $this->mysqli->query($sql);
        }
           
        $this->mysqli->close();
    
        $starshipInfo['additionalData'] = ["error"=>false,"msj"=>"Starship updated successfully","total"=>$total];
        $jsonData = json_encode($starshipInfo);
        
        return $jsonData;
    }

    /**
     * @param String $id;
     * @param String $amount;
     * @return String
    */
    function decrementTotalStartship(String $id, String $amount){

        $stmt = $this->mysqli->prepare("SELECT * FROM starship where starship_id = ?");
        $stmt->bind_param('i',$id);
        $result = $stmt->execute();
        $result = $stmt->get_result(); 
        $starship = $result->fetch_assoc(); 
        $stmt->close();
    
        $total = $starship['total'] - $amount;

        if($total < 0){
            $total = 0;
        }
    
        if ($result->num_rows > 0){
            //Update starship total
            $sql = 'UPDATE starship SET total='.$total.' where starship_id='.$id;
            $result = $this->mysqli->query($sql);
        }
           
        $this->mysqli->close();
    
        $starshipInfo['additionalData'] = ["error"=>false,"msj"=>"Starship updated successfully","total"=>$total];
        $jsonData = json_encode($starshipInfo);
    
        return $jsonData;
    }
}
?>