<?php 
date_default_timezone_set("Africa/Khartoum");

$conn = mysqli_connect("localhost", "root", "", "auction");
mysqli_set_charset($conn, 'UTF8');
mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, 'SET CHARACTER SET utf8');

if (!$conn) {
	echo "Error," . mysqli_connect_error($conn);
	die;
}
global $conn;
//========================= Global Variables =======================//
$alert = '';
$star = "<font style='color:#900;'> * </font>";
//=============Session===============//
session_start();
$currentDate = date('Y-m-d');
function alerts($type, $message)
{
	switch ($type) {
		case 1: {
				$res = '<div class="alert alert-success alert-dismissible" role="alert" style="text-align:center">' . $message . '</div>';
				break;
			} //Green
		case 2: {
				$res = '<div class="alert alert-info alert-dismissible" role="alert" style="text-align:center">' . $message . '</div>';
				break;
			} //Blue
		case 3: {
				$res = '<div class="alert alert-warning alert-dismissible" role="alert" style="text-align:center">' . $message . '</div>';
				break;
			} //Yellow
		case 4: {
				$res = '<div class="alert alert-danger alert-dismissible" role="alert" style="text-align:center">' . $message . '</div>';
				break;
			} //Red	
	}
	return $res;
}

function Login($user_name, $password)
{
	global $conn;

	$password = md5($password);

	$sql = "SELECT * FROM `users` where `username` = '{$user_name}' and `password` = '{$password}' and `del` = 0 ";

	if ($query = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($query)) {
			$row = mysqli_fetch_array($query);
			//echo $sql;die;
			$_SESSION['user_login'] = $row['user_id'];
			$_SESSION['user_name'] = $row['username'];
            $_SESSION['user_type'] = $row['user_type'];
				
		header("location:./index.php");
		
		} else {
			header("location:./login.php?error");
		}
	} else {
		echo $sql;
		die;
	}
}


function Manage_Users($user_id ,$username,$user_full_name,$user_type,$user_phone,$added_by,$action_type){

	global $conn;  

    $password = md5($username) ;

	if($action_type == 'ADD'){
	$check_sql = "SELECT * FROM `users` WHERE `user_phone` = '$user_phone' and `del` = 0 ";
	$check_query = mysqli_query($conn, $check_sql);

	if (mysqli_num_rows($check_query)) {

		return "Exist";

	}else{

		$insert_sql = "INSERT INTO `users`(`username`,`user_full_name`,`password`,`user_type`,`user_phone`,`added_by`)VALUES('$username' ,'$user_full_name' ,'$password' , $user_type , '$user_phone' , $added_by)";
		$insert_query = mysqli_query($conn, $insert_sql);

			if($insert_query){

				return "Inserted";
			}else{
				return "Error";
			}
	}
		}
		if($action_type =='EDIT'){

$update_Sql = "UPDATE `users` SET `username` = '$username' , `user_full_name` = '$user_full_name' , `user_type` = $user_type , `user_phone` = '$user_phone' , `added_by`  = $added_by  WHERE `user_id` = $user_id ";
$update_query = mysqli_query($conn, $update_Sql);
	if($update_query){

		return "Updated";
	}else{
		echo $update_Sql;die;return false ;
		return "Error";
	}
		}
}

function Manage_Categories($cat_id ,$cat_name,$cat_desc,$filename ,$tempname  ,$added_by,$action_type){

    global $conn;  
    $path = "./assets/images/category/" ;
    $folder = $path.$filename ;

    $cat_img = $filename ;


    if($action_type == 'ADD'){
         $check_sql = "SELECT * FROM `category` WHERE `cat_name` = '$cat_name' and `del` = 0 ";
        $check_query = mysqli_query($conn, $check_sql);
    
        if (mysqli_num_rows($check_query)) {
    
            return "Exist";
    
        }else{
    
            $insert_sql = "INSERT INTO `category`(`cat_name`,`cat_desc`,`cat_img`,`added_by`)VALUES('$cat_name' ,'$cat_desc' ,'$cat_img'  , $added_by)";
            $insert_query = mysqli_query($conn, $insert_sql);
    
                if($insert_query && move_uploaded_file($tempname, $folder)){
    
                    return "Inserted";
                }else{
                    return "Error";
                }
        }
            }
            if($action_type =='EDIT'){
    
    $update_Sql = "UPDATE `category` SET `cat_name` = '$cat_name' , `cat_desc` = '$cat_desc' , `cat_img` = '$cat_img' ,  `added_by`  = $added_by  WHERE `cat_id` = $cat_id ";
    $update_query = mysqli_query($conn, $update_Sql);
        if($update_query && move_uploaded_file($tempname, $folder)){
    
            return "Updated";
        }else{
            echo $update_Sql;die;return false ;
            return "Error";
        }
            }
}

function Manage_Items($item_id , $item_name ,$cat_id  , $item_desc ,$filename ,$tempname  ,$added_by,$action_type){

    global $conn;  
    $path = "./assets/images/items/" ;
    $folder = $path.$filename ;

    $item_img = $filename ;


    if($action_type == 'ADD'){
         $check_sql = "SELECT * FROM `items` WHERE `item_name` = '$item_name' and `del` = 0 ";
        $check_query = mysqli_query($conn, $check_sql);
    
        if (mysqli_num_rows($check_query)) {
    
            return "Exist";
    
        }else{
    
            $insert_sql = "INSERT INTO `items`(`item_name`,`cat_id`,`item_desc`,`item_img`,`added_by`)VALUES('$item_name' ,$cat_id ,'$item_desc' , '$item_img'   , $added_by)";
            $insert_query = mysqli_query($conn, $insert_sql);
    
                if($insert_query && move_uploaded_file($tempname, $folder)){
    
                    return "Inserted";
                }else{
                    return "Error";
                }
        }
            }
            if($action_type =='EDIT'){
    
    $update_Sql = "UPDATE `items` SET `item_name` = '$item_name' , `cat_id` = $cat_id , `item_desc` = '$item_desc'  ,`item_img`  = '$item_img'  ,  `added_by`  = $added_by  WHERE `item_id` = $item_id ";
    $update_query = mysqli_query($conn, $update_Sql);
        if($update_query && move_uploaded_file($tempname, $folder)){
    
            return "Updated";
        }else{
            echo $update_Sql;die;return false ;
            return "Error";
        }
            }
}

function Manage_Auction($auc_id,$item_id , $auc_name ,$auc_desc  , $auc_price  ,$auc_end_date,$added_by,$action_type){

	global $conn;  

	if($action_type == 'ADD'){
	$check_sql = "SELECT * FROM `auction` WHERE `auc_name` = '$auc_name' and `del` = 0 ";
	$check_query = mysqli_query($conn, $check_sql);

	if (mysqli_num_rows($check_query)) {

		return "Exist";

	}else{

		$insert_sql = "INSERT INTO `auction`(`item_id`,`auc_name`,`auc_desc`,`auc_price`,`auc_end_date`,`added_by`)VALUES($item_id ,'$auc_name' ,'$auc_desc' , '$auc_price' , '$auc_end_date' , $added_by)";
		$insert_query = mysqli_query($conn, $insert_sql);
        $item_last_id  = mysqli_insert_id($conn);

        $update_sql = "UPDATE `items` SET `item_status` = 1 WHERE `item_id` = $item_last_id and `del` = 0 ";
        $update_query = mysqli_query($conn, $update_sql);

			if($insert_query && $update_query){

				return "Inserted";
			}else{
				return "Error";
			}
	}
		}
		if($action_type =='EDIT'){

$update_Sql = "UPDATE `auction` SET `item_id` = $item_id , `auc_name` = '$auc_name' , `auc_price` = '$auc_price' , `auc_end_date` = '$auc_end_date' , `added_by`  = $added_by  WHERE `auc_id` = $auc_id ";
$update_query = mysqli_query($conn, $update_Sql);
	if($update_query){

		return "Updated";
	}else{
		echo $update_Sql;die;return false ;
		return "Error";
	}
		}
}

function Check_Rows($table_name)
{
    global $conn;   

    $sql = "SELECT * FROM `$table_name` where  `del` = 0 ";
    $query = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($query);

        return $rows;
}



function Get_Data($table_name)
{
    global $conn;
            if($table_name == 'items'){
                $sql = "SELECT * FROM `$table_name` where  `del` = 0 and `item_status` = 0 ";	
            }elseif($table_name == 'auction'){
                $sql = "SELECT * FROM `$table_name` where  `del` = 0 ";	 
            }else{
				$sql = "SELECT * FROM `$table_name` where  `del` = 0 ";	
			}

            $query = mysqli_query($conn, $sql);
        return $query;
}



function Delete_Row($action_id,$table_name,$where_column){
	global $conn;

	 $update_sql = "UPDATE `$table_name` SET `del` = 1 WHERE `$where_column` = $action_id " ;

        if($table_name == "auction"){

            $sql  ="SELECT * FROM `$table_name` WHERE `$where_column` = $action_id and `del` = 0 ";
            $query = mysqli_query($conn, $sql);

            $item_res = mysqli_fetch_array($query);
                $item_id = $item_res['item_id'] ;

                $update_items_sql = "UPDATE `items` SET `item_status` = 0 WHERE `item_id` = $item_id and `del` = 0 ";
                $update_items_query = mysqli_query($conn, $update_items_sql);

        }

		if($update_query = mysqli_query($conn, $update_sql)){
				return true ; 
		}else{
			echo $update_sql;die;return false ;
		}
}

function Fetch_Data_Where($table_name,$where_column,$action_id){
	global $conn;
	 $sql = "SELECT * from `$table_name` WHERE `$where_column` = $action_id and `del` = 0" ;
	$query  = mysqli_query($conn, $sql);
	return $query ;
	}


function Get_Single_Row($table_name , $column_name ,$id){

	global $conn;

    if($table_name == 'items'){
        $sql = "SELECT * FROM `$table_name` where  `$column_name` = $id and `del` = 0 ";
    }else{
        $sql = "SELECT * FROM `$table_name` where  `$column_name` = $id and `del` = 0";
    }

    $query = mysqli_query($conn, $sql);
	$res = mysqli_fetch_array($query) ;
        return $res;

}

function Total_Sales(){

	$order_price =0;

	global $conn;

	$sql = "SELECT * FROM `orders` WHERE `order_status` = 1 and `del` = 0";
	$query = mysqli_query($conn, $sql) ;
		
	while($rows = mysqli_fetch_array($query)){
		$order_price += $rows['order_price'] ;

	}
	return $order_price;
}

function Total_Rows($table_name){

	global $conn;

	$sql = "SELECT * FROM `$table_name` WHERE  `del` = 0";
	$query = mysqli_query($conn, $sql) ;
		
	$rows = mysqli_num_rows($query) ;

	return $rows ;
	
}

function Reports($auc_name , $item_name , $cus_id){

	global $conn;

		if($auc_name =!''){

			echo $sql = "SELECT * FROM `auction` WHERE `auc_name`  ='auction test II' and `del` = 0 ";
		}

		if($item_name !=''){
			$sql = "SELECT * FROM `items` WHERE `item_name`  ='$item_name' and `del` = 0 ";
		}

		if($cus_id !=''){
			$sql = "SELECT * FROM `customers` WHERE `cus_id`  = $cus_id and `del` = 0 ";
		}

		$query = mysqli_query($conn, $sql) ;

		return $query ;


}

function Update_Status($table_name,$id,$status , $auc_id){

	global $conn;
		if($table_name =='orders'){
			
			$update1_sql = "UPDATE `orders` SET `order_status` = $status WHERE `order_id`  = $id";
			$update2_sql = "UPDATE `auction` SET `auc_status` = $status WHERE `auc_id`  = $auc_id";

			 $update3_sql = "UPDATE `orders` SET `order_status` = 2 WHERE `auc_id`  = $auc_id and `order_id` != $id " ;
		}

		if($update_query1 = mysqli_query($conn, $update1_sql)  && $update_query2 = mysqli_query($conn, $update2_sql)  && 
		$update_query3 = mysqli_query($conn, $update3_sql) ){
			//return true ;
		}
}


?>