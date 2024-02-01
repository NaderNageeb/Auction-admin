<?php 
$page = "manage_auction";
include("header.php") ;

//Table fileds//
$table_name = 'auction';
$where_column = 'auc_id';
$auc_id  =  '';
$item_id =  '';
$auc_name =  '';
$auc_desc = '';
$auc_price =  '';
$auc_status =  '';
$auc_end_date = '';
$added_by =  '';
$added_date =  '';
//vars
$edit = '0';
$item_name ='';
$path = "./assets/images/items/" ;

//Get Data Query//
$items_query = Get_Data('items');
//Actions//
if(isset($_GET['action'])){

    $action = $_GET['action'] ;
    $action_id = $_GET['action_id'] ;

        if($action == "del"){

              if($delete =  Delete_Row($action_id,$table_name,$where_column)){
                $alert  = alerts(1,"<b>DELETED :</b> Successfully DELETED !");
            }else{
             $alert  = alerts(4,"<b>ERROR ,</b> Cannot Delete !");      
            }
        }
//Get Info
        if($action =="edit"){
                $edit = "1";
                $get_data = Fetch_Data_Where($table_name,$where_column,$action_id);
                $_result = mysqli_fetch_array($get_data) ;

                $auc_id = $_result['auc_id'] ;
                $item_id = $_result['item_id'] ;
                $auc_name = $_result['auc_name'] ;
                $auc_desc = $_result['auc_desc'] ;
                $auc_price = $_result['auc_price'] ;
                $auc_status = $_result['auc_status'] ;
                $auc_end_date = $_result['auc_end_date'] ;

                if($auc_status =="0"){
                    $auc_status_text = "Open" ;
                }elseif($auc_status =="1"){
                    $auc_status_text = "Closed" ;
                } 
        }
}
///ADD//
    if(isset($_POST['submit'])){

        $item_id = $_POST['item_id'] ;
        $auc_name = $_POST['auc_name'] ;
        $auc_desc = $_POST['auc_desc'] ;
        $auc_price = $_POST['auc_price'] ;
        $auc_end_date = $_POST['auc_end_date'] ;

        if($auc_end_date >= $currentDate){
            $manage_auction= Manage_Auction($auc_id,$item_id , $auc_name ,$auc_desc  , $auc_price  ,$auc_end_date  ,$_SESSION['user_login'] ,'ADD') ;

            if($manage_auction=="Inserted"){
                $alert  = alerts(1,"<b>INSERTED :</b> Auction Successfully Added !");
            }elseif($manage_auction=="Exist"){
                $alert  = alerts(3,"<b>Oops :</b> Auction <b>$auc_name</b> Already Exist !");     
            }
        }else{
            $alert  = alerts(3,"<b>Error :</b> End Date should be greater  than Current Date !");   
        }

      
    }
///Edit//
        if(isset($_POST['edit'])){

            $auc_id = $_POST['auc_id'] ;
            $item_id = $_POST['item_id'] ;
            $auc_name = $_POST['auc_name'] ;
            $auc_desc = $_POST['auc_desc'] ;
            $auc_price = $_POST['auc_price'] ;
            $auc_end_date = $_POST['auc_end_date'] ;
    
            $manage_auction = Manage_Auction($auc_id,$item_id , $auc_name ,$auc_desc  , $auc_price  ,$auc_end_date  ,$_SESSION['user_login'] ,'EDIT') ;
    
                if($manage_auction=="Updated"){
                    $alert  = alerts(1,"<b>Updated :</b> Auction Info Successfully Updated !");
                }elseif($manage_auction=="Error"){
                    $alert  = alerts(3,"<b>Oops :</b> Error While Updating Auction Info !");     
                }
    }
    ?>

    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">			    
			    <h1 class="app-page-title">Manage Auctions</h1>
			    <hr class="mb-4">
                <div class="row g-4 settings-section">
                <h5 class = 'card-subtitle'><?php echo"</br>". $alert ;?></h5>
	                <div class="col-12 col-md-8">
                          
		                <div class="app-card app-card-settings shadow-sm p-4">
						    
						    <div class="app-card-body">
							    <form class="settings-form" action="manage_auction.php" method="post">
                                <input  type="hidden" name= "auc_id" required="required" value="<?php echo $auc_id; ?>">
								    <div class="mb-3">
									    <label for="setting-input-1" class="form-label">Auction Name</label>
									    <input type="text" class="form-control" name="auc_name" placeholder="Auction Name" id="setting-input-1" required="required" value="<?php echo $auc_name ; ?>">
									</div>
									
                                    <div class="mb-3">
									    <label for="setting-input-3" class="form-label">Auction Item</label>
									    <select id="inputText3" class="form-control" name= "item_id" required="required">
                                                   
                                        <?php 
                                                   if($item_id !=""){

                                                    $get_item_name_res = Get_Single_Row('items','item_id' ,$item_id);
                                                    $item_name = $get_item_name_res['item_name'] ;

                                                  ?>
                                            <option value="<?php echo $item_id ?>"><?php echo $item_name ?></option>
                                                  <?php
                                                        }else{
                                                            ?>
                                           <option value="">Select item</option>
                                                        <?php
                                                        }
                                                    ?>
                                                  <?php 
                                                    while($items_res = mysqli_fetch_array($items_query)){
                                                        $item_id = $items_res['item_id'] ;
                                                        $item_name = $items_res['item_name'] ;
                                                      ?>
                                                       <option value="<?php echo $item_id ; ?>"><?php echo $item_name ; ?></option>
                                                      <?php
                                                    }
                                                    ?>   
                                                </select>
									</div>
                                    <div class="mb-3">
									    <label for="setting-input-2" class="form-label">Description</label>
                                        <textarea rows="41" cols="50" class="form-control" placeholder="Description" name= "auc_desc" required="required"><?php echo $auc_desc ; ?></textarea>
									</div>
								   <div class="mb-3">
									    <label for="setting-input-3" class="form-label">Price</label>
									    <input type="number" class="form-control" step="0.01" pattern="[0-9]{4}-[0-9]{6}"  placeholder="Price" id="setting-input-3" name="auc_price" required="required" value="<?php echo $auc_price ; ?>">
									</div> 

                                    <div class="mb-3">
									    <label for="setting-input-3" class="form-label">End Date</label>
									    <input type="date" class="form-control"  placeholder="End Date" id="setting-input-3" name="auc_end_date" required="required" value="<?php echo $auc_end_date ; ?>">
									</div> 
                                
                                    <?php 
                                            if($edit == "1"){
                                    ?>
									<button type="submit" class="btn btn-info  text-white" name="edit">Edit Auction</button>
                                    <?php 
                                            }else{
                                    ?>
                                     <button type="submit" class="btn app-btn-primary" name="submit">Add Auction</button>    
                                    <?php
                                            }
                                    ?>
							    </form>
						    </div><!--//app-card-body-->
						    
						</div><!--//app-card-->
	                </div>
                </div><!--//row-->

                <hr class="my-4">

                <?php 
    if(Check_Rows($table_name)>0){      
        
        $user_qeury  = Get_Data($table_name) ;
                ?>

                <h1 class="app-page-title">View Auctions</h1>
                <hr class="my-4">
                <div class="row g-4 settings-section">

                <div class="col-12 col-md-12">
                    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                
                <th>Auction Name</th>
                <th>Item</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Status</th>
                <th>End Date</th>
                <!-- <th>Date</th> -->
                <th>By</th>
                <th>Edit</th>
                <th>DEL</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($rows = mysqli_fetch_array($user_qeury)){

                $auc_id = $rows['auc_id'] ;
                $item_id = $rows['item_id'] ;
                $auc_name = $rows['auc_name'] ;
                $auc_desc = $rows['auc_desc'] ;
                $auc_price = $rows['auc_price'] ;
                $auc_status = $rows['auc_status'] ;
                $auc_end_date = $rows['auc_end_date'] ;
                $added_by = $rows['added_by'] ;
                $added_date = $rows['added_date'] ;

                $get_item_name_res = Get_Single_Row('items','item_id' ,$item_id);
                $get_user_name_res = Get_Single_Row('users','user_id' ,$added_by);

                $item_name = $get_item_name_res['item_name'] ;
                $item_img = $get_item_name_res['item_img'] ;

                $user_name = $get_user_name_res['username'] ;

                if($auc_status == "0"){
                        $auc_status_text = "<strong style='color:green;'>".'Open'."</strong>" ;
                }elseif($auc_status == "1"){
                        $auc_status_text = "<strong style='color:red;'>".'Closed'."</strong>";
                }
            ?>
            <tr>
                <td><?php echo $auc_name ; ?></td>
                <td><?php echo $item_name ; ?></td>
                <td><?php echo $auc_desc ; ?></td>
                <td><?php echo $auc_price ; ?></td>
                <td><a href="<?php echo $path.$item_img ; ?>" target="_blank" class="btn btn-primary text-white">View Image</a></td>
                <td><?php echo $auc_status_text ; ?></td>
                <td><?php echo $auc_end_date ; ?></td>
                <!-- <td><?php //echo //$added_date ; ?></td> -->
                <td><?php echo $user_name ; ?></td>
                <td><a href="manage_auction.php?action_id=<?php echo $auc_id ; ?>&action=edit" class="btn btn-info text-white">Edit</a></td>
                <td><a href="manage_auction.php?action_id=<?php echo $auc_id ; ?>&action=del" class="btn btn-danger text-white" onClick="return confirm('Are you sure you want to DELETE this Record ?')">DEL</a></td>
            </tr>
            <?php 
            }
            ?>
            </tbody>
        <tfoot>
            <tr>
                <th>Auction Name</th>
                <th>Item</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Status</th>
                <th>End Date</th>
                <!-- <th>Date</th> -->
                <th>By</th>
                <th>Edit</th>
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