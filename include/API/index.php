<?php 
$db = "auction"; //database name
$dbuser = "root"; //database username
$dbpassword = ""; //database password
$dbhost = "localhost"; //database host

$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);

mysqli_set_charset($conn, 'UTF8');
mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, 'SET CHARACTER SET utf8');
global $conn;
$currentDate = date('Y-m-d');

//Login//
if(isset($_GET['login'])){

    if (isset($_POST["username"])){
   
      $username = $_POST["username"];
      $user_pass = MD5($_POST["pass"]);
   
       $sql = "select * from `customers` where  `cus_login_name` = '{$username}' and `cus_pass` = '$user_pass' and `del` = 0 ";
   
       $result = mysqli_query($conn,$sql);
       $data = mysqli_fetch_array($result);
   
     if(mysqli_num_rows($result)){
   
           $resarray = array();
           array_push($resarray , array("cus_id"=>$data['cus_id'] , "cus_login_name"=>$data['cus_login_name'] , "cus_full_name"=>$data['cus_full_name']));
           echo json_encode(array("result" => $resarray ));
         
     }else{
           echo json_encode(array("result" => 'NULL' ));
     }
     }
   }

   //addNewCus
   if(isset($_GET['addNewCus'])){

    $cus_full_name = $_POST['cus_full_name'];
    $cus_login_name = $_POST['cus_login_name'];
    $cus_pass = MD5($_POST['cus_pass']);
    $cus_phone = $_POST['cus_phone'];
    $cus_id_number = $_POST['cus_id_number'];

    $sql = "SELECT * FROM `customers` WHERE `cus_phone` = '{$cus_phone}' and `del` = 0";
  $query = mysqli_query($conn, $sql);
  if(mysqli_num_rows($query)>0)
          {
        echo json_encode(array("cus_result" => 'Exist' ));
          }else{
$insert_sql = "INSERT INTO `customers`(`cus_login_name`,`cus_pass`,`cus_full_name`,`cus_phone`,`cus_id_number`)VALUES('{$cus_login_name}','{$cus_pass}','{$cus_full_name}','{$cus_phone}','{$cus_id_number}')";
      if($query = mysqli_query($conn, $insert_sql))
          {
  echo json_encode(array("cus_result" => 'Inserted' ));
  }else{
    echo json_encode(array("cus_result" => 'Error' ));
  }	
      }
  }

  if(isset($_GET['GetCat'])){

    $cat_array = array();
  
    $sql = "SELECT * FROM `category` WHERE `del` = 0 ";
    $sql_query = mysqli_query($conn, $sql);
  
      if(mysqli_num_rows($sql_query))
        {
        while($data = mysqli_fetch_array($sql_query)){
  array_push($cat_array , array( "cat_id"=>$data['cat_id'] , "cat_name"=>$data['cat_name'] , "cat_desc"=>$data['cat_desc'], "cat_img"=>$data['cat_img']));
          }
        echo json_encode(array_reverse($cat_array));
      }
  }

  if(isset($_GET['GetItems'])){

    $items_array = array();

    $cat_id = $_GET['cat_id'] ;
  
    $sql = "SELECT * FROM `items` WHERE `del` = 0 and `item_status` = 0 and `cat_id` = $cat_id ";
    $sql_query = mysqli_query($conn, $sql);
  
      if(mysqli_num_rows($sql_query))
        {
        while($data = mysqli_fetch_array($sql_query)){

          $item_id = $data['item_id'];

          $auction_sql = "SELECT * FROM `items` I , `auction` A WHERE I.`item_id` = $item_id and  A.`item_id` = $item_id and A.`auc_status` = 0 and A.`auc_end_date` >= '$currentDate' and A.`del` = 0" ;
          $auction_query = mysqli_query($conn, $auction_sql);

            while($res  = mysqli_fetch_array($auction_query)){

              array_push($items_array , array("auc_id"=>$res['auc_id'] , "item_id"=>$res['item_id'] , "item_name"=>$res['item_name'] , 
              "cat_id"=>$res['cat_id'], "item_desc"=>$res['item_desc'], "item_img"=>$res['item_img'] , 
              "item_status"=>$res['item_status'] ,  "auc_name"=>$res['auc_name'] , "auc_desc"=>$res['auc_desc'] , "auc_price"=>$res['auc_price'] ,
              "auc_status"=>$res['auc_status'] ,  "auc_end_date"=>$res['auc_end_date'] 
              
            ));

            }

          }
        echo json_encode(array_reverse($items_array));
      }
  }


  if(isset($_GET['GetAuctionItems'])){

    $items_array = array();

    $auc_id = $_GET['auc_id'] ;
    //  $lastauctionprice = GetLastAuctionPrice($auc_id);
    $auction_sql = "SELECT * FROM `items` I , `auction` A WHERE I.`item_id` = A.`item_id` and  A.`auc_id` = $auc_id and A.`auc_status` = 0 and A.`del` = 0 " ;
    $auction_query = mysqli_query($conn, $auction_sql);
// i change the $res['auc_price'] by $lastauctionprice;

      while($res  = mysqli_fetch_array($auction_query)){

        array_push($items_array , array("auc_id"=>$res['auc_id'] , "item_id"=>$res['item_id'] , "item_name"=>$res['item_name'] , 
        "cat_id"=>$res['cat_id'], "item_desc"=>$res['item_desc'], "item_img"=>$res['item_img'] , 
        "item_status"=>$res['item_status'] ,  "auc_name"=>$res['auc_name'] , "auc_desc"=>$res['auc_desc'] , "auc_price"=>$res['auc_price'],
        "auc_status"=>$res['auc_status'] ,  "auc_end_date"=>$res['auc_end_date']));

      }
      echo json_encode(array_reverse($items_array));
  }
// ///////
  if(isset($_GET['GetLastAuctionPrice'])) {
    $data = array();
    $auc_id = $_POST['auc_id'];
    global $conn;
    $sql = "SELECT MAX(order_price) as c from orders  where `auc_id` = $auc_id";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query)){

      while($row = mysqli_fetch_assoc($query)){
          $data[] = $row;
      }
           echo json_encode(array("data"=>$data));
      
      }else{
      
            echo  json_encode(array("status"=>"Faild"));
      }

  }
  // /////////

  if(isset($_GET['myOrders'])){

    $items_array = array();

    $cus_id = $_GET['cus_id'] ;
    $auction_sql = "SELECT * FROM `orders` O ,`items` I , `auction` A WHERE O.`cus_id` = $cus_id and I.`item_id` = A.`item_id` and  O.`auc_id` = A.`auc_id` and  O.`del` = 0 " ;
    $auction_query = mysqli_query($conn, $auction_sql);

    if(mysqli_num_rows($auction_query)){
      while($res  = mysqli_fetch_array($auction_query)){

        array_push($items_array , array("order_id"=>$res['order_id'],"auc_id"=>$res['auc_id'] , "item_id"=>$res['item_id'] , "item_name"=>$res['item_name'] , 
        "cat_id"=>$res['cat_id'], "item_desc"=>$res['item_desc'], "item_img"=>$res['item_img'] , 
        "item_status"=>$res['item_status'] ,  "auc_name"=>$res['auc_name'] , "auc_desc"=>$res['auc_desc'] , "auc_price"=>$res['auc_price'] ,
        "auc_status"=>$res['auc_status'] ,  "auc_end_date"=>$res['auc_end_date'] ,"order_price"=>$res['order_price'],"order_status"=>$res['order_status']   ));
      }
      echo json_encode(array_reverse($items_array));
    }
  }

  if(isset($_GET['OrderByID'])){

    $items_array = array();
    
    $order_id = $_GET['order_id'] ;

    $auction_sql = "SELECT * FROM `orders` O ,`items` I , `auction` A WHERE O.`order_id` = $order_id and I.`item_id` = A.`item_id` and  O.`auc_id` = A.`auc_id` and  O.`del` = 0 " ;
    $auction_query = mysqli_query($conn, $auction_sql);

      while($res  = mysqli_fetch_array($auction_query)){

        array_push($items_array , array("order_id"=>$res['order_id'],"auc_id"=>$res['auc_id'] , "item_id"=>$res['item_id'] , "item_name"=>$res['item_name'] , 
        "cat_id"=>$res['cat_id'], "item_desc"=>$res['item_desc'], "item_img"=>$res['item_img'] , 
        "item_status"=>$res['item_status'] ,  "auc_name"=>$res['auc_name'] , "auc_desc"=>$res['auc_desc'] , "auc_price"=>$res['auc_price'] ,
        "auc_status"=>$res['auc_status'] ,  "auc_end_date"=>$res['auc_end_date'] ,"order_price"=>$res['order_price'],"order_status"=>$res['order_status']   ));

      }
      echo json_encode(array_reverse($items_array));
  }

 //addNewOrder
 if(isset($_GET['addNewOrder'])){

  $auc_id = $_POST['auc_id'];
  $cus_id = $_POST['cus_id'];
  $order_price = $_POST['order_price'];

  //   $sql = "SELECT * FROM `orders` WHERE `auc_id` = $auc_id and `cus_id` = $cus_id and `del` = 0";
  //   $query = mysqli_query($conn, $sql);
  // if(mysqli_num_rows($query)>0)
  //         {
  //       echo json_encode(array("order_result" => 'Exist' ));
  //         }else{
  $insert_sql = "INSERT INTO `orders`(`auc_id`,`cus_id`,`order_price`)VALUES($auc_id,$cus_id,'{$order_price}')";
      if($query = mysqli_query($conn, $insert_sql))
          {
  echo json_encode(array("order_result" => 'Inserted' ));
  }else{
    echo json_encode(array("order_result" => 'Error' ));
  }	
      // }
}


if(isset($_GET['deleteOrder'])){

  $order_id = $_POST['order_id'] ;
  $cus_id = $_POST['cus_id'] ;
  $item_id = $_POST['item_id'] ;

    $update_sql = "UPDATE `orders` SET `del` = 1 WHERE `order_id` = $order_id and `order_status` = 0";
    $update_query = mysqli_query($conn, $update_sql);

    $update_item_sql = "UPDATE `items` SET `item_status` = 0 WHERE `item_id` = $item_id ";
    $update_item_query = mysqli_query($conn, $update_item_sql);


      if($update_query && $update_item_query){
        echo json_encode(array("order_result" => 'Updated' ));
      }else{
        echo json_encode(array("order_result" => 'Error' ));
      }
}

if(isset($_GET['MyProfile'])){

  $cus_array = array();

  $cus_id = $_GET['cus_id'] ;

  $sql = "SELECT * FROM `customers` WHERE `cus_id` = $cus_id and `del` = 0";
  $query = mysqli_query($conn, $sql) ;
    if(mysqli_num_rows($query)){
    while($res = mysqli_fetch_array($query)){

      array_push($cus_array , array( "cus_id"=>$res['cus_id'] , "cus_login_name"=>$res['cus_login_name'] , 
      "cus_pass"=>$res['cus_pass'], "cus_full_name"=>$res['cus_full_name'] ,
      "cus_phone"=>$res['cus_phone'] , "cus_id_number"=>$res['cus_id_number']));
  }

echo json_encode(array_reverse($cus_array));
    }
}

//UpdateProfile//
if(isset($_GET['EditInfo'])){

  $cus_id  =$_POST['cus_id'] ;
  $cus_full_name = $_POST['cus_full_name'];
  $cus_login_name = $_POST['cus_login_name'];
  $cus_pass = MD5($_POST['cus_pass']);
  $cus_phone = $_POST['cus_phone'];
  $cus_id_number = $_POST['cus_id_number'];

    $update_sql = "UPDATE `customers` SET `cus_login_name` = '$cus_login_name' , `cus_full_name` = '$cus_full_name' , `cus_phone` ='$cus_phone' ,
    `cus_pass` = '$cus_pass' , `cus_id_number` = '$cus_id_number' WHERE `cus_id` = $cus_id ";

        if($query = mysqli_query($conn, $update_sql))
        {
        echo json_encode(array("cus_result" => 'Updated' ));
        }else{
        echo json_encode(array("cus_result" => 'Error' ));
        }	


}

  ?>