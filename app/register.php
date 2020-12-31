<?php
// Check if there is someone already logged in
if(isset($_COOKIE["user"])) {
    header('Location: index.php'); // Redirect to index.php
}

include("connect_to_db.php");

if (isset($_POST["fullname"], $_POST["password"], $_POST["email"], $_POST["day"], $_POST["month"], $_POST["year"], $_POST["gender"])) {
    $query = "MATCH (u:User) WHERE u.email = '" . $_POST['email'] . "' RETURN u.email"; // Get an user email that's equal to the given email
    $result = $client->sendCypherQuery($query)->getResult(); // Execute query
    $email = $result->get('u.email'); // Get the email
    $hashed_pass = hash('sha256', $_POST["password"]); // Hash the given password text

    // Check if day, month & year fields have not the default values
    if ($_POST["day"] != "Day" and $_POST["month"] != "Month" and $_POST["year"] != 'Year') {

        // Make day in an appropriate format
        $day = (int)$_POST["day"];
        if ($day < 10) {
            $day = '0' . $day;
        }

        // Make month in an appropriate format
        $arrayVariable = [
            'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4,
            'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8,
            'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12,
        ];
        $month = $arrayVariable[$_POST["month"]];
        if ($month < 10) {
            $month = '0' . $month;
        } else {
            $month = $arrayVariable[$_POST["month"]];
        }

        // Make birthDate in an appropriate format
        $birthDate = $_POST["year"] . '/' . $month . '/' . $day;
    }

    // If there isn't an email in db that's equal with the given email
    if ($email != $_POST["email"]) {
        $query = 'MATCH (u:User) RETURN MAX(u.id) AS mx'; // Get the maximum value of user's id
        $lastId = $client->sendCypherQuery($query)->getResult(); // Execute query
        $newId = $lastId->get('mx');
        $newId = (int)$newId + 1; // Calculate the id of the new user

        // Create the new user with all given information as properties
        $query = "CREATE (u:User { id: " . $newId . ", fullname: '" . $_POST["fullname"] . "', email: '" . $_POST["email"] . "', gender: '" . $_POST["gender"] . "', birthDate: '" . $birthDate . "', password: '" . $hashed_pass . "', profileImageUrl: 'https://github.com/p17griv/neobook/blob/main/app/images/blank-profile-picture.jpg'})";
        $client->sendCypherQuery($query); // Execute query

        setcookie("user", $newId, time() + (86400 * 30), "/"); // Set a cookie with the new user's id as value
        header('Location: index.php'); // Redirect to index.php
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome | NeoBook</title>
    <link rel="icon" href="images/fav.png" type="image/png" sizes="16x16"> 
    
    <link rel="stylesheet" href="css/main.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/responsive.css">

</head>
<body>
<!--<div class="se-pre-con"></div>-->
<div class="theme-layout">
	<div class="container-fluid pdng0">
		<div class="row merged">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="land-featurearea">
					<div class="land-meta">
						<h1>NeoBook</h1>
						<p>
							NeoBook is a free online social network for everyone who loves graphs!
						</p>
						<div class="friend-logo">
							<span><img src="https://static.thenounproject.com/png/374726-200.png"></span>
						</div>
						<a href="https://github.com/p17griv/neobook" title="" class="folow-me">View Project On GitHub</a>
					</div>	
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="login-reg-bg">
					<div class="log-reg-area" style="overflow: auto; height: 90%">
                        <h2 class="log-title">Register</h2>
                        <p>
                            A whole new world is waiting for your content!
                        </p>
                        <form method="post" action="register.php">
                            <div class="form-group">
                                <input type="text" required="required" name="fullname"/>
                                <label class="control-label" for="input">First & Last Name</label><i class="mtrl-select"></i>
                            </div>
                            <div class="form-group">
                                <input type="password" required="required" name="password"/>
                                <label class="control-label" for="input">Password</label><i class="mtrl-select"></i>
                            </div>
                            <div class="form-radio">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" value="male" checked="checked"/><i class="check-box"></i>Male
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" value="female"/><i class="check-box"></i>Female
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" required="required"/>
                                <label class="control-label" for="input">Email</label><i class="mtrl-select"></i>
                            </div>
                            <div class="dob">
                                <div class="form-group">
                                    <h6>Birth Date: </h6>
                                    <select id="selectDay" name="day">
                                        <option value="Day">Day</option>
                                        <script>
                                            var select = document.getElementById('selectDay');
                                            for (var i = 1; i <= 31; i++){
                                                var opt = document.createElement('option');
                                                opt.value = i;
                                                opt.innerHTML = i;
                                                select.appendChild(opt);
                                            }
                                        </script>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="month">
                                        <option value="month">Month</option>
                                        <option>Jan</option>
                                        <option>Feb</option>
                                        <option>Mar</option>
                                        <option>Apr</option>
                                        <option>May</option>
                                        <option>Jun</option>
                                        <option>Jul</option>
                                        <option>Aug</option>
                                        <option>Sep</option>
                                        <option>Oct</option>
                                        <option>Nov</option>
                                        <option>Dec</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="selectYear" name="year">
                                        <option value="year">Year</option>
                                        <script>
                                            var select = document.getElementById('selectYear');
                                            var max = new Date().getFullYear();
                                            for (var i = max - 18; i > 1901; i--){
                                                var opt = document.createElement('option');
                                                opt.value = i;
                                                opt.innerHTML = i;
                                                select.appendChild(opt);
                                            }
                                        </script>
                                    </select>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="terms" value="terms" required="required"/><i class="check-box"></i>Accept Terms & Conditions ?
                                </label>
                                <a href="landing.php" style="color: blue; text-decoration: none">Already have an account</a>
                            </div>

                            <div class="submit-btns">
                                <button class="mtr-btn signin" type="submit"><span>Register</span></button>
                            </div>
                            <?php

                            ?>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
	<script src="js/script.js"></script>

</body>	

</html>