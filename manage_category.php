<?php 
$page = "manage_cat";
include("header.php") ;

//Table fileds//
$table_name = 'category';
$where_column = 'cat_id';
$cat_id =  '';
$cat_name =  '';
$cat_desc =  '';
$cat_img = '';
$added_by =  '';
$added_date =  '';
//vars
$edit = '0';
$path = "./assets/images/category/" ;
//Actions//
if(isset($_GET['action'])){

    $action = $_GET['action'] ;
    $action_id = $_GET['action_id'] ;

        if($action == "del"){

              if($delete =  Delete_Row($action_id,$table_name,$where_column)){
                $alert  = alerts(1,"<b>DELETED :</b> Category Successfully DELETED !");
            }else{
             $alert  = alerts(4,"<b>ERROR ,</b> Cannot Delete Category !");      
            }
        }
//Get Info
        if($action =="edit"){
                $edit = "1";
                $get_data = Fetch_Data_Where($table_name,$where_column,$action_id);
                $_result = mysqli_fetch_array($get_data) ;

                $cat_id  = $_result['cat_id'] ;
                $cat_name = $_result['cat_name'] ;
                $cat_desc = $_result['cat_desc'] ;
                $cat_img = $_result['cat_img'] ;
        }
}
///ADD//
    if(isset($_POST['submit'])){

        $cat_name = $_POST['cat_name'] ;
        $cat_desc = $_POST['cat_desc'] ;
        $filename = $_FILES["cat_img"]["name"];
        $tempname = $_FILES["cat_img"]["tmp_name"];
        

        $manage_categories = Manage_Categories($cat_id , $cat_name ,$cat_desc  , $filename ,$tempname  ,$_SESSION['user_login'] ,'ADD') ;

                if($manage_categories=="Inserted"){
                    $alert  = alerts(1,"<b>INSERTED :</b> Category Successfully Added !");
                }elseif($manage_categories=="Exist"){
                    $alert  = alerts(3,"<b>Oops :</b> Category <b>$cat_name</b> Already Exist !");     
                }
    }
///Edit//
        if(isset($_POST['edit'])){

            $cat_id = $_POST['cat_id'] ;
            $cat_name = $_POST['cat_name'] ;
            $cat_desc = $_POST['cat_desc'] ;
            $filename = $_FILES["cat_img"]["name"];
            $tempname = $_FILES["cat_img"]["tmp_name"];
        
    
            $manage_categories = Manage_Categories($cat_id , $cat_name ,$cat_desc  ,  $filename ,$tempname   ,$_SESSION['user_login'] ,'EDIT') ;
    
                if($manage_categories=="Updated"){
                    $alert  = alerts(1,"<b>Updated :</b> Category Info Successfully Updated !");
                }elseif($manage_categories=="Error"){
                    $alert  = alerts(3,"<b>Oops :</b> Error While Updating Category Info !");     
                }
    }
    ?>

    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">			    
			    <h1 class="app-page-title">Manage Categories</h1>
			    <hr class="mb-4">
                <div class="row g-4 settings-section">
                <h5 class = 'card-subtitle'><?php echo"</br>". $alert ;?></h5>
	                <div class="col-12 col-md-8">
                          
		                <div class="app-card app-card-settings shadow-sm p-4">
						    
						    <div class="app-card-body">
							    <form class="settings-form" action="manage_category.php" method="post" enctype="multipart/form-data">
                                <input  type="hidden" name= "cat_id" required="required" value="<?php echo $cat_id; ?>">
								    <div class="mb-3">
									    <label for="setting-input-1" class="form-label">Category Name</label>
									    <input type="text" class="form-control" name="cat_name" placeholder="Category Name" id="setting-input-1" required="required" value="<?php echo $cat_name ; ?>">
									</div>
									<div class="mb-3">
									    <label for="setting-input-2" class="form-label">Category Description</label>
                                        <textarea rows="41" cols="50" class="form-control" placeholder="Category Description" name= "cat_desc" required="required"><?php echo $cat_desc ; ?></textarea>
									</div>
								    <div class="mb-3">
									    <label for="setting-input-3" class="form-label">Category Image</label>
									    <input type="file" class="form-control"  placeholder="Category Image" id="setting-input-3" name="cat_img" required="required" value="<?php echo $cat_img ; ?>">
									</div>

                                    <?php 
                                            if($edit == "1"){
                                    ?>
									<button type="submit" class="btn btn-info  text-white" name="edit">Edit Category</button>
                                    <?php 
                                            }else{
                                    ?>
                                     <button type="submit" class="btn app-btn-primary" name="submit">Add Category</button>    
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

                <h1 class="app-page-title">View Categories</h1>
                <hr class="my-4">
                <div class="row g-4 settings-section">

                <div class="col-12 col-md-12">
                    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                
                <th>Category Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Date</th>
                <th>Edit</th>
                <th>DEL</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($rows = mysqli_fetch_array($user_qeury)){

                $cat_id = $rows['cat_id'] ;
                $cat_name = $rows['cat_name'] ;
                $cat_desc = $rows['cat_desc'] ;
                $cat_img = $rows['cat_img'] ;
                $added_by = $rows['added_by'] ;
                $added_date = $rows['added_date'] ;

             
            ?>
            <tr>
                <td><?php echo $cat_name ; ?></td>
                <td><?php echo $cat_desc ; ?></td>
                <td><a href="<?php echo $path.$cat_img ; ?>" target="_blank" class="btn btn-primary text-white">View Image</a></td>
                <td><?php echo $added_date ; ?></td>
                <td><a href="manage_category.php?action_id=<?php echo $cat_id ; ?>&action=edit" class="btn btn-info text-white">Edit</a></td>
                <td><a href="manage_category.php?action_id=<?php echo $cat_id ; ?>&action=del" class="btn btn-danger text-white" onClick="return confirm('Are you sure you want to DELETE this Record ?')">DEL</a></td>
            </tr>
            <?php 
            }
            ?>
            </tbody>
        <tfoot>
            <tr>
                <th>Category Name</th>
                <th>Description</th>
                <th>Image</th>
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