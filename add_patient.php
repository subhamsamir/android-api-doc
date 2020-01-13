<?php 

	require_once 'DbConnect.php';
	
	//an array to display response
	$response = array();
	
	//if it is an api call 
	//that means a get parameter named api call is set in the URL 
	//and with this parameter we are concluding that it is an api call

	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			case 'add_patient':
				//checking the parameters required are available or not 
				if(isTheseParametersAvailable(array('pName', 'pAge', 'pGender', 'pEmail','pPhone', 'pLocation', 'pPhoto'))){
					
					//getting the values 
					$pName = $_POST['pName'];
					$pAge = $_POST['pAge'];
					$pGender = $_POST['pGender'];
					$pEmail = $_POST['pEmail']; 
					$pPhone = $_POST['pPhone'];
					$pLocation = $_POST['pLocation'];
					$pPhoto = $_POST['pPhoto'];
					//$password = md5($_POST['password']);
					

					
					//checking if the user is already exist with this username or email
					//as the email and username should be unique for every user 
					$stmt = $conn->prepare("SELECT pName FROM Homeopatient WHERE pName = ? OR pEmail = ?");
					$stmt->bind_param("ss", $pName, $pEmail);
					$stmt->execute();
					$stmt->store_result();
					
					//if the user already exist in the database 
					if($stmt->num_rows > 0){
						$response['error'] = true;
						$response['message'] = 'patient already registered';
						$stmt->close();
					}else{
						
						//if user is new creating an insert query 
						$stmt = $conn->prepare("INSERT INTO Homeopatient (pName, pAge, pGender, pEmail, pPhone, pLocation, pPhoto) VALUES (?, ?, ?, ?, ?, ?, ?)");
						$stmt->bind_param("sssssss",$pName, $pAge, $pGender, $pEmail, $pPhone, $pLocation, $pPhoto);
						
						//if the user is successfully added to the database 
						if($stmt->execute()){
							
							//fetching the user back 
							$stmt = $conn->prepare("SELECT pName, pAge, pGender, pEmail, pPhone, pLocation, pPhoto  FROM Homeopatient WHERE pName = ?"); 
							$stmt->bind_param("s", $pName);
							$stmt->execute();
							$stmt->bind_result($pName, $pAge, $pGender, $pEmail, $pPhone, $pLocation, $pPhoto);
							$stmt->fetch();
							
							$user = array(
							'pName'=> $pName,
							'pAge'=> $pAge,
							'pGender'=> $pGender,
							'pEmail'=> $pEmail,
							'pPhone'=> $pPhone,
							'pLocation'=> $pLocation,
							'pPhoto'=> $pPhoto
							);
							
							$stmt->close();
							
							//adding the user data in response 
							$response['error'] = false; 
							$response['message'] = 'patient added successfully'; 
							$response['user'] = $user; 
						}
					}
					
				}else{
					$response['error'] = true; 
					$response['message'] = 'required parameters are not available'; 
				}
				
			break; 
			
			/*case 'login':
				//for login we need the username and password 
				if(isTheseParametersAvailable(array('username', 'password'))){
					//getting values 
					$username = $_POST['username'];
					$password = md5($_POST['password']); 
					
					//creating the query 
					$stmt = $conn->prepare("SELECT id, username, email, gender FROM users WHERE username = ? AND password = ?");
					$stmt->bind_param("ss",$username, $password);
					
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $username, $email, $gender);
						$stmt->fetch();
						
						$user = array(
							'id'=>$id, 
							'username'=>$username, 
							'email'=>$email,
							'gender'=>$gender
						);
						
						$response['error'] = false; 
						$response['message'] = 'Login successfull'; 
						$response['user'] = $user; 
					}else{
						//if the user not found 
						$response['error'] = false; 
						$response['message'] = 'Invalid username or password';
					}
				}
			break; 
			*/
			default: 
				$response['error'] = true; 
				$response['message'] = 'Invalid Operation Called';
		}
		
	}else{
		//if it is not api call 
		//pushing appropriate values to response array 
		$response['error'] = true; 
		$response['message'] = 'Invalid API Call';
	}
	
	//displaying the response in json structure 
	echo json_encode($response);
	
	//function validating all the paramters are available
	//we will pass the required parameters to this function 
	function isTheseParametersAvailable($params){
		
		//traversing through all the parameters 
		foreach($params as $param){
			//if the paramter is not available
			if(!isset($_POST[$param])){
				//return false 
				return false; 
			}
		}
		//return true if every param is available 
		return true; 
	}