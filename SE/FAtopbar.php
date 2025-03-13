<!DOCTYPE html>
<html>
<head>
<style>
.sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #333;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidebar a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 17px;
  color: #f2f2f2;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  color: #ddd;
}

.sidebar .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

.openbtn {
  font-size: 20px;
  cursor: pointer;
  background-color: #333;
  color: white;
  padding: 10px 15px;
  border: none;
}

.openbtn:hover {
  background-color: #444;
}

#main {
  transition: margin-left 0.5s;
  padding: 16px;
}

.submenu {
  padding-left: 22px;
  display: none; /* Initially hide the submenu */
  background-color: #555; 
}

.submenu a {
  padding-left: 22px;
}

</style>
</head>
<body>

<div id="mySidebar" class="sidebar">
  <a href="Fadmin_edit_profile.php"><span class="material-symbols-outlined">account_circle</span> User</a>
  <a href="ClassSession.php"><span class="material-symbols-outlined">self_improvement</span>Class Session</a>
  
  <a href="#" onclick="toggleSubmenu('fitnessPackageSubMenu')"><span class="material-symbols-outlined">package</span>Fitness Package</a>
  <div class="submenu" id="fitnessPackageSubMenu">
    <a href="FitnessPackage.php"><span class="material-symbols-outlined">list</span>Fitness Package List</a>
    <a href="Sales_Report.php"><span class="material-symbols-outlined">shopping_bag</span>Sales Report</a>
  </div>
  <a href="Announcement.php"><span class="material-symbols-outlined">brand_awareness</span>Announcement</a>
  <a href="AnalyticReport.php"><span class="material-symbols-outlined">finance</span>Member Analytics Report</a>
  <a href="FAlogout.php"><span class="material-symbols-outlined">logout</span> Exit</a>
  <a href="index.php"><span class="material-symbols-outlined">domain</span> Main Portal</a>
</div>

<div id="main">
  <button class="openbtn" onclick="toggleSidebar()">☰</button>  
</div>

<script>
function toggleSidebar() {
  var sidebar = document.getElementById("mySidebar");
  var main = document.getElementById("main");
  if (sidebar.style.width === "250px") {
    sidebar.style.width = "0";
    main.style.marginLeft = "0";
  } else {
    sidebar.style.width = "250px";
    main.style.marginLeft = "250px";
  }
}

function toggleSubmenu(submenuId) {
  var submenu = document.getElementById(submenuId);
  submenu.style.display = (submenu.style.display === 'none' || submenu.style.display === '') ? 'block' : 'none';
}
</script>

</body>
</html>
