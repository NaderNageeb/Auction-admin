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
//vars
$edit = '0';
//Actions//
if(isset($_GET['action'])){

    $action = $_GET['action'] ;
    $action_id = $_GET['action_id'] ;

        if($action == "del"){

              if($delete =  Delete_Row($action_id,$table_name,$where_column)){
                $alert  = alerts(1,"<b>DELETED :</b> Request Successfully DELETED !");
            }else{
             $alert  = alerts(4,"<b>ERROR ,</b> Cannot Delete Request !");      
            }
        }
}
    ?>
    <div class="app-wrapper">
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">			    
			 
                <?php 
    if(Check_Rows($table_name)>0){      

        $auction_qeury  = Get_Data($table_name) ;
        
                ?>

                <h1 class="app-page-title">View Sale Requests</h1>
                <hr class="my-4">
                <div class="row g-4 settings-section">
                <h5 class = 'card-subtitle'><?php echo"</br>". $alert ;?></h5>
                <div class="col-12 col-md-12">
                    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Auction Name</th>
                <th>Item Name</th>
                <th>Auction Price</th>
                <th>End Date</th>
                <th>Status</th>
                <th>View Reqeusts</th>
                <th>DEL</th>
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
                <td><?php echo $auc_price ; ?></td>
                <td><?php echo $auc_end_date ; ?></td>
                <td><?php echo $auc_status_text ; ?></td>

                <td><a href="manage_requests_details.php?action_id=<?php echo $auc_id ; ?>&action=view" class="btn btn-info text-white">View</a></td>
                <td><a href="manage_requests.php?action_id=<?php echo $auc_id ; ?>&action=del" class="btn btn-danger text-white" onClick="return confirm('Are you sure you want to DELETE this Record ?')">DEL</a></td>
            </tr>
            <?php 
            }
            ?>
            </tbody>
        <tfoot>
            <tr>
            <th>Auction Name</th>
                <th>Item Name</th>
                <th>Auction price</th>
                <th>End Date</th>
                <th>Status</th>
                <th>View Reqeusts</th>
                <th>DEL</th>
            </tr>
        </tfoot>
    </table>
	                </div>
            </div>
            <?php 
    }
            ?>
<!-- //if shoud endhere -->

                </div><!--//row-->
         
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
        <?php 
include("footer.php") ;
?>	    