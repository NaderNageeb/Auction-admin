<?php 
$page = "manage_items";
include("header.php") ;

//Table fileds//
$table_name = 'items';
$where_column = 'item_id';
$item_id  =  '';
$item_name =  '';
$cat_id =  '';
$item_desc = '';
$item_img = '';
$item_status = '';
$added_by =  '';
$added_date =  '';
//vars
$edit = '0';
$path = "./assets/images/items/" ;
$cat_name = '';
//Get Data Query//
$cat_query = Get_Data('category');
//Actions//
if(isset($_GET['action'])){

    $action = $_GET['action'] ;
    $action_id = $_GET['action_id'] ;

        if($action == "del"){

              if($delete =  Delete_Row($action_id,$table_name,$where_column)){
                $alert  = alerts(1,"<b>DELETED :</b> Item Successfully DELETED !");
            }else{
             $alert  = alerts(4,"<b>ERROR ,</b> Cannot Delete Item !");      
            }
        }
//Get Info
        if($action =="edit"){
                $edit = "1";
                $get_data = Fetch_Data_Where($table_name,$where_column,$action_id);
                $_result = mysqli_fetch_array($get_data) ;

                $item_id  = $_result['item_id'] ;
                $item_name = $_result['item_name'] ;
                $item_desc = $_result['item_desc'] ;
                $item_img = $_result['item_img'] ;



        }
}
///ADD//
    if(isset($_POST['submit'])){

        $item_name = $_POST['item_name'] ;
        $cat_id = $_POST['cat_id'] ;
        $item_desc = $_POST['item_desc'] ;

        $filename = $_FILES["item_img"]["name"];
        $tempname = $_FILES["item_img"]["tmp_name"];
        

        $manage_items = Manage_Items($item_id , $item_name ,$cat_id  , $item_desc  , $filename ,$tempname  ,$_SESSION['user_login'] ,'ADD') ;

                if($manage_items=="Inserted"){
                    $alert  = alerts(1,"<b>INSERTED :</b> item Successfully Added !");
                }elseif($manage_items=="Exist"){
                    $alert  = alerts(3,"<b>Oops :</b> item <b>$item_name</b> Already Exist !");     
                }
    }
///Edit//
        if(isset($_POST['edit'])){

            $cat_id = $_POST['cat_id'] ;
            $cat_name = $_POST['cat_name'] ;
            $cat_desc = $_POST['cat_desc'] ;
            $filename = $_FILES["cat_img"]["name"];
            $tempname = $_FILES["cat_img"]["tmp_name"];
        
            $manage_items = Manage_Items($item_id , $item_name ,$cat_id  , $item_desc  , $filename ,$tempname  ,$_SESSION['user_login']  ,'EDIT') ;
    
                if($manage_items=="Updated"){
                    $alert  = alerts(1,"<b>Updated :</b> item Info Successfully Updated !");
                }elseif($manage_items=="Error"){
                    $alert  = alerts(3,"<b>Oops :</b> Error While Updating item Info !");     
                }
    }
    ?>

    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">			    
			    <h1 class="app-page-title">Manage Items</h1>
			    <hr class="mb-4">
                <div class="row g-4 settings-section">
                <h5 class = 'card-subtitle'><?php echo"</br>". $alert ;?></h5>
	                <div class="col-12 col-md-8">
                          
		                <div class="app-card app-card-settings shadow-sm p-4">
						    
						    <div class="app-card-body">
							    <form class="settings-form" action="manage_items.php" method="post" enctype="multipart/form-data">
                                <input  type="hidden" name= "item_id" required="required" value="<?php echo $item_id; ?>">
								    <div class="mb-3">
									    <label for="setting-input-1" class="form-label">Item Name</label>
									    <input type="text" class="form-control" name="item_name" placeholder="Item Name" id="setting-input-1" required="required" value="<?php echo $item_name ; ?>">
									</div>
                                    <div class="mb-3">
									    <label for="setting-input-3" class="form-label">Item Category</label>
									    <select id="inputText3" class="form-control" name= "cat_id" required="required">
                                                   
                                        <?php 
                                                   if($cat_id !=""){
                                                  ?>
                                            <option value="<?php echo $cat_id ?>"><?php echo $cat_name ?></option>
                                                  <?php
                                                        }else{
                                                            ?>
                                           <option value="">Select Item Category</option>
                                                        <?php
                                                        }
                                                    ?>
                                                  
                                                    <?php 
                                                    while($cat_res = mysqli_fetch_array($cat_query)){
                                                        $cat_id = $cat_res['cat_id'] ;
                                                        $cat_name = $cat_res['cat_name'] ;
                                                      ?>
                                                       <option value="<?php echo $cat_id ; ?>"><?php echo $cat_name ; ?></option>
                                                      <?php
                                                    }

                                                    ?>   
                                        
                                                </select>
									</div>

									<div class="mb-3">
									    <label for="setting-input-2" class="form-label">Item Description</label>
                                        <textarea rows="41" cols="50" class="form-control" placeholder="Item Description" name= "item_desc" required="required"><?php echo $item_desc ; ?></textarea>
									</div>
                                    <!-- <div class="mb-3">
									    <label for="setting-input-3" class="form-label">Item Price</label>
									    <input type="number" class="form-control" step="0.01" pattern="[0-9]{4}-[0-9]{6}"  placeholder="Item Price" id="setting-input-3" name="item_price" required="required" value="<?php //echo $item_price ; ?>">
									</div> -->
								    <div class="mb-3">
									    <label for="setting-input-3" class="form-label">Item Image</label>
									    <input type="file" class="form-control"  placeholder="Category Image" id="setting-input-3" name="item_img" required="required" value="<?php echo $item_img ; ?>">
									</div>

                                    <?php 
                                            if($edit == "1"){
                                    ?>
									<button type="submit" class="btn btn-info  text-white" name="edit">Edit Item</button>
                                    <?php 
                                            }else{
                                    ?>
                                     <button type="submit" class="btn app-btn-primary" name="submit">Add Item</button>    
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

                <h1 class="app-page-title">View Items</h1>
                <hr class="my-4">
                <div class="row g-4 settings-section">

                <div class="col-12 col-md-12">
                    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th>Date</th>
                <th>Edit</th>
                <th>DEL</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($rows = mysqli_fetch_array($user_qeury)){

                $item_id = $rows['item_id'] ;
                $item_name = $rows['item_name'] ;
                $cat_id = $rows['cat_id'] ;
                $item_img = $rows['item_img'] ;
                $item_desc = $rows['item_desc'] ; 
                $item_status = $rows['item_status'] ; 
                $added_by = $rows['added_by'] ;
                $added_date = $rows['added_date'] ;

                    $get_cat_name_res = Get_Single_Row('category','cat_id' ,$cat_id);

                    $cat_name =$get_cat_name_res['cat_name'] ;

                    if($item_status == "0"){
                        $item_status_text =  "<strong style='color:green;'>".'Available'."</strong>" ;
                    }elseif($item_status =="1"){
                        $item_status_text =  "<strong style='color:red;'>".'Solid'."</strong>" ;
                    }

             
            ?>
            <tr>
                <td><?php echo $item_name ; ?></td>
                <td><?php echo $cat_name ; ?></td>
                <td><?php echo $item_desc ; ?></td>
                <td><a href="<?php echo $path.$item_img ; ?>" target="_blank" class="btn btn-primary text-white">View Image</a></td>
                <td><?php echo $item_status_text ; ?></td>
                <td><?php echo $added_date ; ?></td>
                <td><a href="manage_items.php?action_id=<?php echo $item_id ; ?>&action=edit" class="btn btn-info text-white">Edit</a></td>
                <td><a href="manage_items.php?action_id=<?php echo $item_id ; ?>&action=del" class="btn btn-danger text-white" onClick="return confirm('Are you sure you want to DELETE this Record ?')">DEL</a></td>
            </tr>
            <?php 
            }
            ?>
            </tbody>
        <tfoot>
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th>Date</th>
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