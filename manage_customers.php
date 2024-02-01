<?php 
$page = "manage_customers";
include("header.php") ;

//Table fileds//
$table_name = 'customers';
$where_column = 'cus_id';
$cus_id =  '';
$cus_login_name =  '';
$cus_pass =  '';
$cus_full_name = '';
$cus_phone =  '';
$cus_id_number =  '';
$added_date =  '';
//vars
$edit = '0';

//Actions//
if(isset($_GET['action'])){

    $action = $_GET['action'] ;
    $action_id = $_GET['action_id'] ;

        if($action == "del"){

              if($delete =  Delete_Row($action_id,$table_name,$where_column)){
                $alert  = alerts(1,"<b>DELETED :</b> Customer Successfully DELETED !");
            }else{
             $alert  = alerts(4,"<b>ERROR ,</b> Cannot Delete Customer !");      
            }
        }
}
    ?>
    <div class="app-wrapper">
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">			    
			 
                <?php 
    if(Check_Rows($table_name)>0){      

        $customers_qeury  = Get_Data($table_name) ;
        
                ?>

                <h1 class="app-page-title">View Customers</h1>
                <hr class="my-4">
                <div class="row g-4 settings-section">
                <h5 class = 'card-subtitle'><?php echo"</br>". $alert ;?></h5>
                <div class="col-12 col-md-12">
                    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Full name</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Identity Number</th>
                <th>Date</th>
                <th>DEL</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($rows = mysqli_fetch_array($customers_qeury)){

                $cus_id = $rows['cus_id'] ;
                $cus_full_name = $rows['cus_full_name'] ;
                $cus_login_name = $rows['cus_login_name'] ;
                $cus_phone = $rows['cus_phone'] ;
                $cus_id_number = $rows['cus_id_number'] ;
                $added_date = $rows['added_date'] ;

            ?>
            <tr>
                <td><?php echo $cus_full_name ; ?></td>
                <td><?php echo $cus_login_name ; ?></td>
                <td><?php echo $cus_phone ; ?></td>
                <td><?php echo $cus_id_number ; ?></td>
                <td><?php echo $added_date ; ?></td>
                <td><a href="manage_customers.php?action_id=<?php echo $cus_id ; ?>&action=del" class="btn btn-danger text-white" onClick="return confirm('Are you sure you want to DELETE this Record ?')">DEL</a></td>
            </tr>
            <?php 
            }
            ?>
            </tbody>
        <tfoot>
            <tr>
            <th>Full name</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Type</th>
                <th>Date</th>
                <th>DEL</th>
                
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