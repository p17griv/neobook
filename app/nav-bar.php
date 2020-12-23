<?php
include("connect_to_db.php");

$query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]." RETURN u.profileImageUrl"; // Get current user's profile image url
$result = $client->sendCypherQuery($query)->getResult(); // Execute query
$profileImageUrl = $result->get('u.profileImageUrl'); // Get the image url


echo '<div class="topbar stick">
		<div class="logo">
			<a title="" href="index.php"><img src="images/logo.png" alt=""></a>
		</div>
		
		<div class="top-area">
			<div class="top-search">
				<form>
				    <input id="searchBar" type="text" placeholder="Find People" autocomplete="off" onkeydown="showResults(this.value)" onkeyup="showResults(this.value)">';

echo '
<div id="Results"></div>
<script>

function showResults(str) {
  var xhttp;    
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("Results").innerHTML = this.responseText;
    }
  };  
  xhttp.open("GET", "search.php?searchTerm="+str, true);
  xhttp.send();
}
</script>
';

echo '
                    <button data-ripple disabled><i class="ti-search"></i></button>
				</form>
			</div>
			<ul class="setting-area">
				<li>
                    <a id="homeBtn" href="index.php" title="Home" data-ripple="">
                        <i class="ti-home"></i>
                    </a>
                </li>
			</ul>
			<div class="user-img">
                <img style="width: 65px; height: 60px" src="'.$profileImageUrl.'">
				<div class="user-setting">
					<a id="profileBtn" href="time-line.php"><i class="ti-user"></i> view profile</a>
					<a id="editProfileBtn" href="edit-profile-basic.php" title=""><i class="ti-pencil-alt"></i>edit profile</a>
					<a id="accountSettingBtn" href="setting.php" title=""><i class="ti-settings"></i>account setting</a>
					<a id="logoutBtn" href="log-out.php" title=""><i class="ti-power-off"></i>log out</a>
				</div>
				<script>
				    document.getElementById("homeBtn").onclick = function () { location.href = "index.php"; };
				    document.getElementById("profileBtn").onclick = function () { location.href = "time-line.php"; };
				    document.getElementById("editProfileBtn").onclick = function () { location.href = "edit-profile-basic.php"; };
				    document.getElementById("accountSettingBtn").onclick = function () { location.href = "setting.php"; };
				    document.getElementById("logoutBtn").onclick = function () { location.href = "log-out.php"; };
                </script>
			</div>
			<ul class="setting-area"><li></li></ul>
		</div>
	</div><!-- topbar -->';