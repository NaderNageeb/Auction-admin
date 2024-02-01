<?php 
$page = "manage_requests";
include("header.php") ;

//Table fileds//
$table_name = 'auction';
$where_column = 'auc_id';
$auc_id =  '';
$item_id =  '';
$auc_name =  '';
$auc_desc = '';
$auc_price =  '';
$auc_status =  '';
$auc_end_date =  '';
$order_status ='';
//vars
$edit = '0';
    if(isset($_GET['action_id']) ){
        $auc_id  = $_GET['action_id'] ;
//Actions//
if(isset($_GET['action'])){

    $action = $_GET['action'] ;
    $action_id = $_GET['action_id'] ;

        if($action == "Del"){

              if($delete =  Delete_Row($action_id,'orders','order_id')){
                $alert  = alerts(1,"<b>DELETED :</b> Request Successfully DELETED !");
            }else{
             $alert  = alerts(4,"<b>ERROR ,</b> Cannot Delete Request !");      
            }
            
        }


        if($action =='Confirm'){
                $auction_id  =$_GET['auction_id'] ;
            $update_status  = Update_Status('orders' , $action_id , '1' , $auction_id) ;

        }
}
    ?>
    <div class="app-wrapper">
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">			    
			 
                <?php 
  

        $auction_qeury  = Fetch_Data_Where($table_name,'auc_id',$auc_id) ;
        
                ?>

                <h1 class="app-page-title">View Sale Requests</h1>
                <hr class="my-4">
                <div class="row g-4 settings-section">
                <h5 class = 'card-subtitle'><?php echo"</br>". $alert ;?></h5>
                <div class="col-12 col-md-12">
                    <table class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Auction Name</th>
                <th>Item Name</th>
                <th>Auction Price</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($rows = mysqli_fetch_array($auction_qeury)){

                $auc_id = $rows['auc_id'] ;
                $auc_name = $rows['auc_name'] ;
                $item_id = $rows['item_id'] ;
                $auc_price = $rows['auc_price'] ;
                $auc_end_date = $rows['auc_end_date'] ;
                $auc_status = $rows['auc_status'] ;

                $get_item_name_res = Get_Single_Row('items','item_id' ,$item_id);

                $item_name = $get_item_name_res['item_name'] ;

                    if($auc_status == '0'){
                            $auc_status_text = '<strong style="color:yellow;">'."Pending".'</strong>' ;
                    }
                    if($auc_status == '1'){
                        $auc_status_text = '<strong style="color:green;">'."Confirmed".'</strong>'  ;
                    }
                    if($auc_status == '2'){
                        $auc_status_text = '<strong style="color:red;">'."Rejected".'</strong>'  ;
                    }
       
            ?>
            <tr>
                <td><?php echo $auc_name ; ?></td>
                <td><?php echo $item_name ; ?></td>
                <td><?php echo $auc_price.".SDG" ; ?></td>
                <td><?php echo $auc_end_date ; ?></td>
                <td><?php echo $auc_status_text ; ?></td>
            </tr>
            <?php 
            }
            ?>
            </tbody>
       
    </table>
    <hr/>

            <?php 
            $get_orders_query = Fetch_Data_Where('orders','auc_id',$auc_id) ;
            ?>

<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Auction Price</th>
                <th>Customer Price</th>
                <th>Current Status</th>
                <?php 
                    if ($order_status  == "0"){
                ?>
                <th>Confirm</th>
                <th>Reject</th>
                <?php 
                    }
                        ?>
                <th></th>
                <th></th>
                <th></th>
                
              
            </tr>
        </thead>
        <tbody>
            <?php 
            while($res = mysqli_fetch_array($get_orders_query)){

                $order_id = $res['order_id'] ;
                $auc_id = $res['auc_id'] ;
                $cus_id = $res['cus_id'] ;
                $order_price = $res['order_price'] ;
                $order_status = $res['order_status'] ;

                if($order_status == '0'){
                    $order_status_text = '<strong style="color:yellow;">'."Pending".'</strong>' ;
            }
            if($order_status == '1'){
                    $order_status_text = '<strong style="color:green;">'."Confirmed".'</strong>' ;
            }
            if($order_status == '2'){
                    $order_status_text = '<strong style="color:red;">'."Rejected".'</strong>'  ;
            }

                $get_cus_name_res = Get_Single_Row('customers','cus_id' ,$cus_id);
                $cus_full_name = $get_cus_name_res['cus_full_name'] ;

       
            ?>
            <tr>
                <td><?php echo $cus_full_name ; ?></td>
                <td><?php echo $auc_price.".SDG" ; ?></td>
                <td><?php echo $order_price.".sdg" ; ?></td>
                <td><?php echo $order_status_text ; ?></td>
                <?php 
                    if ($order_status  == "0"){
                ?>
                <td><a href="manage_requests_details.php?action_id=<?php echo $order_id ; ?>&action=Confirm&auction_id=<?php echo $auc_id ;?>" class="btn btn-success text-white" onClick="return confirm('Are you sure you want to Confirm request ?')">Confirm</a></td>
                <td><a href="manage_requests_details.php?action_id=<?php echo $order_id ; ?>&action=Reject&auction_id=<?php echo $auc_id ;?>" class="btn btn-warning text-white" onClick="return confirm('Are you sure you want to Reject request ?')">Reject</a></td>
                        <?php 
                    }
                        ?>
                <td><a href="manage_requests_details.php?action_id=<?php echo $order_id ; ?>&action=Del" class="btn btn-danger text-white" onClick="return confirm('Are you sure you want to Delete request ?')">Delete</a></td>
            </tr>
            <?php 
            }
            ?>
            </tbody>
       
    </table>

	                </div>
            </div>
            <?php 
    //}
            ?>
<!-- //if shoud endhere -->

                </div><!--//row-->
         
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
        <?php 
    }
include("footer.php") ;
?>	    