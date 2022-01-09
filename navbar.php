<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
   
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
        <div class="logo_name">Hi-Tech Sales and Inventory System</div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list">
      <li>
        <a href="index.php?page=dashboard" class="nav-item nav-home">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
         <span class="tooltip">Dashboard</span>
      </li>
      <li>
       <a href="index.php?page=pos" class="nav-item nav-pos">
         <i class='bx bx-cart-alt' ></i>
         <span class="links_name">POS</span>
       </a>
       <span class="tooltip">POS</span>
     </li>
     <li>
       <a href="index.php?page=customer" class="nav-item nav-customer">
         <i class='bx bx-user' ></i>
         <span class="links_name">Customers</span>
       </a>
       <span class="tooltip">Customers</span>
     </li>
     <li>
       <a href="index.php?page=product" class="nav-item nav-product">
         <i class='bx bx-list-ol' ></i>
         <span class="links_name">Product List</span>
       </a>
       <span class="tooltip">Product List</span>
     </li>
     <li>
       <a href="index.php?page=categories" class="nav-item nav-logs">
       <i class='bx bx-purchase-tag-alt'></i>
         <span class="links_name">Brands</span>
       </a>
       <span class="tooltip">Brands</span>
     </li>
     <li>
       <a href="index.php?page=supplier" class="nav-item nav-supplier">
         <i class='bx bx-box' ></i>
         <span class="links_name">Suppliers</span>
       </a>
       <span class="tooltip">Suppliers</span>
     </li>
     <li>
       <a href="index.php?page=purchaseorder_list" class ="nav-item nav-inventory">
       <i class='bx bx-basket'></i>
         <span class="links_name">Purchase Order</span>
       </a>
       <span class="tooltip">Purchase Order</span>
     </li>
    
     <li>
       <a href="index.php?page=inventory" class ="nav-item nav-inventory">
          <i class='bx bx-receipt'></i>
         <span class="links_name">Inventory Report</span>
       </a>
       <span class="tooltip">Inventory Report</span>
     </li>
     <li>
       <a href="index.php?page=sales" class="nav-item nav-sales">
         <i class='bx bx-shopping-bag' ></i>
         <span class="links_name">Sales Report</span>
       </a>
       <span class="tooltip">Sales Report</span>
     </li>
    
     
     <li>
       <a href="index.php?page=users" class="nav-item nav-users">
         <i class='bx bx-user' ></i>
         <span class="links_name">Users</span>
       </a>
       <span class="tooltip">Users</span>
     </li>
     <li>
       <a href="index.php?page=audit" class="nav-item nav-logs">
       <i class='bx bx-book-open'></i>
         <span class="links_name">Logs</span>
       </a>
       <span class="tooltip">Logs</span>
     </li>
     
    
     <li class="profile">
         <div class="profile-details">
           
           <div class="name_job">
             <div class="name"><?php echo $_SESSION['login_name'] ?></div>
             <span id='time' style="color:white"></span>
           </div>
           <a class="btn-logout" href="./admin_class.php?a=logout" ><i class='bx bx-log-out' id="log_out" ></i></a>
         </div>
        
     </li>
    </ul>
  </div>
  <section class="home-section">
  
  <?php $page = isset($_GET['page']) ? $_GET['page'] :'home'; ?>
  	<?php include $page.'.php' ?>
	
</script></div>
  </section>
  <?php if($_SESSION['login_type'] != 1): ?>
	<style>
		.nav-item{
			display: none!important;
			
		}
		.nav-sales ,.nav-home ,.nav-inventory{
			display: block!important;
		}
    .nav-pos{
      display: none;
    }

		
	</style>
<?php endif ?>
  <script src="./assets/js/script.js"></script>
 

</body>
</html>
