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

.fa-calendar:before {
    content: "\f073"; /* Unicode character for calendar icon */
}
</style>
</head>
<body>

<div id="mySidebar" class="sidebar">
  <a href="trainer_profile.php"><span class="material-symbols-outlined">account_circle</span> Trainer Account</a>
  <a href="Tmember_list.php"><span class="fa fa-users"></span> Members Page</a>
  <a href="trainer_schedule_page.php"><span class="fa fa-calendar"></span> My Schedule</a>
  <a href="member_analytic_report.php"><span class="fa fa-file"></span> Member Analytic Report</a>
  <a href="tlogout.php"><span class="material-symbols-outlined">logout</span> Exit</a>
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
</script>

</body>
</html>
