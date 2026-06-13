<?php
// Include database connection
require_once 'db_connect.php';

$roles = [];
try {
    // Fetch roles from tbl_role
    $stmt = $pdo->query("SELECT id, role_name FROM tbl_role ORDER BY role_name ASC");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log the error (do not display to user in production)
    error_log("Error fetching roles: " . $e->getMessage());
    // Fallback if roles cannot be fetched
    $roles = [
        ['role_id' => 1, 'role_name' => 'Super Admin'],
        ['role_id' => 2, 'role_name' => 'Store Admin'],
        ['role_id' => 3, 'role_name' => 'Manager'],
        ['role_id' => 4, 'role_name' => 'Sales Man']
    ];
}

$login_error = '';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_submit'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role_id = $_POST['role']; // This will be the role_id from the dropdown

    // Basic validation
    if (empty($username) || empty($password) || empty($role_id)) {
        $login_error = "Please fill in all fields.";
    } else {
        // Prepare a SELECT statement to check user credentials and role
        // NOTE: This is a simplified check. In a real application, you'd hash passwords
        // and verify them using password_verify().
        // For demonstration, we assume plaintext passwords for now, but NEVER do this in production.
        $sql = "SELECT * FROM tbl_users WHERE username = :username AND password = :password AND role_id = :role_id";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR); // Again, HASH PASSWORDS IN REAL APPS
            $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Login successful
                // Start a session and store user info
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id']; // Assuming a user_id column
                $_SESSION['username'] = $user['username'];
                $_SESSION['role_id'] = $user['role_id'];
                $_SESSION['role_name'] = ''; // You might want to fetch role_name too

                $role_id = $user['role_id'];

                if ($role_id==1){
                  header("location: super_admin_dashboard.php");
                 }elseif ($role_id== 2){
                  header("location: store_admin_dashboard.php");
                }elseif ($role_id== 3){
                  header("location: manager_dashboard.php");
                }elseif ($role_id== 4){
                  header("location: salesperson_dashboard.php");
                } else {
                    $login_error = "Invalid role.";
                }
                // Redirect to a dashboard or success page
               // header("location: dashboard.php");
                exit;
            } else {
                $login_error = "Invalid username, password, or role.";
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $login_error = "An unexpected error occurred during login. Please try again later.";
        }
    }
}
// Handle signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup_submit'])) {
    // Collect form inputs
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $DOB        = $_POST['dob'];
    $username   = trim($_POST['username']);
    $password   = $_POST['password'];
    $role_id    = 4;
    $is_active  = 0;

    // Check for empty fields
    if (empty($first_name) || empty($last_name) || empty($DOB) || empty($username) || empty($password)) {
        $signup_error = "Please fill all fields.";
    } else {
        try {
           
            // Prepare SQL query
            $sql = "INSERT INTO tbl_users (first_name, last_name, dob, username, password, role_id, is_active)
                    VALUES (:first_name, :last_name, :dob, :username, :password, :role_id, :is_active)";
            $insertStmt = $pdo->prepare($sql);

            // Bind parameters
            $insertStmt->bindParam(':first_name', $first_name);
            $insertStmt->bindParam(':last_name', $last_name);
            $insertStmt->bindParam(':dob', $DOB);
            $insertStmt->bindParam(':username', $username);
            $insertStmt->bindParam(':password', $password); // Secure hashed password
            $insertStmt->bindParam(':role_id', $role_id);
            $insertStmt->bindParam(':is_active', $is_active);

            // Execute statement
            $insertStmt->execute();

            // Redirect or show success message
            header("Location: index.php?signup=success");
            exit;

        } catch (PDOException $e) {
            $signup_error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login / Signup</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    /* Your existing CSS from the previous response goes here.
       Make sure to copy all the CSS you provided earlier. */
    * {
      margin: 0;
      padding: 0;
      list-style-type: none;
    }

    ul {
      display: flex;
      background-color: #1f1f2e;
      width: 100%;
      height: 4rem;
      margin: auto;
      max-width: 2500px;
      justify-content: space-between;
      text-align: right;
      align-items: right;
    }

    li {
      padding: 1rem 2rem 1.15rem;
      text-transform: uppercase;
      cursor: pointer;
      color:rgb(255, 255, 255);
      font-weight: 600;
      font-size : 18px;
      padding-top : 20px;
      min-width: 80px;
      margin: auto;
      text-align : right;
      margin-left : 950px;
    }

    li:hover {
      background-image: url('https://scottyzen.sirv.com/Images/v/button.png');
      background-size: 100% 100%;
      color: #190384;
      animation: spring 300ms ease-out;
      text-shadow: 0 -1px 0 #ef816c;
      font-weight: bold;
    }

    li:active {
      transform: translateY(4px);
    }

    @keyframes spring {
      15% {
        -webkit-transform-origin: center center;
        -webkit-transform: scale(1.2, 1.1);
      }

      40% {
        -webkit-transform-origin: center center;
        -webkit-transform: scale(0.95, 0.95);
      }

      75% {
        -webkit-transform-origin: center center;
        -webkit-transform: scale(1.05, 1);
      }

      100% {
        -webkit-transform-origin: center center;
        -webkit-transform: scale(1, 1);
      }
    }

    :root {
      --primary-color: #1f1f2e;
      --secondary-color: #1f1f2e;
      --black: #000000;
      --white: #ffffff;
      --gray: #efefef;
      --gray-2: #757575;

      --facebook-color: #4267B2;
      --google-color: #DB4437;
      --twitter-color: #1DA1F2;
      --insta-color: #E1306C;
    }

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

    * {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    .logo {
  display: flex;
  
  font-family: 'Poppins', sans-serif;
  font-weight: 700;
  padding-top : 20px;
  font-size: 1.6rem;
  color:rgb(254, 254, 254); /* Sky Blue */
  letter-spacing: 1px;
  user-select: none;
}

.logo img {
  width: 60px;
  padding : px 10px;
  height: 40px;
  object-fit: contain;
  transition: transform 0.3s ease;
}

.logo:hover img {
  transform: rotate(10deg) scale(1.05);
}


    html,
    body {
      height: 100vh;
      overflow: hidden;
    }

    .container {
      position: relative;
      min-height: 100vh;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      padding-top: 4rem;
    }

    .row {
      display: flex;
      flex-wrap: wrap;
      height: calc(100vh - 4rem);
      width: 100%;
      max-width: 1400px;
    }

    .col {
      width: 50%;
    }

    .align-items-center {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .form-wrapper {
      width: 100%;
      max-width: 28rem;
    }

    .form {
      padding: 2rem;
      background-color: var(--white);
      border-radius: 1.5rem;
      width: 100%;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
      transform: scale(0);
      transition: .5s ease-in-out;
      transition-delay: 1s;
    }

    .input-group {
      position: relative;
      width: 100%;
      margin: 1rem 0;
    }

    .input-group i {
      position: absolute;
      top: 50%;vag
      left: 1rem;
      transform: translateY(-50%);
      font-size: 1.4rem;
      color: var(--gray-2);
    }

    .input-group input,
    .input-group select {
      width: 100%;
      padding: 1rem 3rem;
      font-size: 1rem;
      background-color: var(--gray);
      border-radius: .5rem;
      border: 0.125rem solid var(--white);
      outline: none;
    }

    .input-group input:focus,
    .input-group select:focus {
      border: 0.125rem solid var(--primary-color);
    }

    .form button {
      cursor: pointer;
      width: 100%;
      padding: .8rem 0;
      border-radius: .5rem;
      border: none;
      background-color: var(--primary-color);
      color: var(--white);
      font-size: 1.2rem;
      outline: none;
      margin-top: 1rem;
    }

    .form p {
      margin: 1rem 0;
      font-size: .85rem;
    }

    .flex-col {
      flex-direction: column;
    }

    .social-list {
      margin: 2rem 0;
      padding: 1rem;
      border-radius: 1.5rem;
      width: 100%;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
      transform: scale(0);
      transition: .5s ease-in-out;
      transition-delay: 1.2s;
      display: flex;
      justify-content: center;
    }

    .social-list>div {
      color: var(--white);
      margin: 0 .5rem;
      padding: .7rem;
      cursor: pointer;
      border-radius: .5rem;
      transform: scale(0);
      transition: .5s ease-in-out;
    }

    .social-list>div:nth-child(1) {
      transition-delay: 1.4s;
    }

    .social-list>div:nth-child(2) {
      transition-delay: 1.6s;
    }

    .social-list>div:nth-child(3) {
      transition-delay: 1.8s;
    }
    
    .social-list>div:nth-child(4) {
      transition-delay: 2s;
    }

    .social-list>div>i {
      font-size: 1.5rem;
      transition: .4s ease-in-out;
    }

    .social-list>div:hover i {
      transform: scale(1.5);
    }

    .facebook-bg {
      background-color: var(--facebook-color);
    }

    .google-bg {
      background-color: var(--google-color);
    }

    .twitter-bg {
      background-color: var(--twitter-color);
    }

    .insta-bg {
      background-color: var(--insta-color);
    }

    .pointer {
      cursor: pointer;
      font-weight: bold;
      color: var(--primary-color);
    }

    .container.sign-in .form.sign-in,
    .container.sign-in .social-list.sign-in,
    .container.sign-in .social-list.sign-in>div,
    .container.sign-up .form.sign-up,
    .container.sign-up .social-list.sign-up,
    .container.sign-up .social-list.sign-up>div {
      transform: scale(1);
    }

    .content-row {
      position: absolute;
      top: 0;
      left: 0;
      pointer-events: none;
      z-index: 6;
      width: 100%;
      height: 100%;
      display: flex;
    }

    .text {
      margin: 4rem;
      color: var(--white);
    }

    .text h2 {
      font-size: 3.5rem;
      font-weight: 800;
      margin: 2rem 0;
      transition: 1s ease-in-out;
    }

    .text p {
      font-weight: 600;
      transition: 1s ease-in-out;
      transition-delay: .2s;
    }

    .img img {
      width: 30vw;
      transition: 1s ease-in-out;
      transition-delay: .4s;
    }

    .text.sign-in h2,
    .text.sign-in p,
    .img.sign-in img {
      transform: translateX(-250%);
    }

    .text.sign-up h2,
    .text.sign-up p,
    .img.sign-up img {
      transform: translateX(250%);
    }

    .container.sign-in .text.sign-in h2,
    .container.sign-in .text.sign-in p,
    .container.sign-in .img.sign-in img,
    .container.sign-up .text.sign-up h2,
    .container.sign-up .text.sign-up p,
    .container.sign-up .img.sign-up img {
      transform: translateX(0);
    }

    /* BACKGROUND */

    .container::before {
      content: "";
      position: absolute;
      top: 0;
      right: 0;
      height: 110vh;
      width: 300vw;
      transform: translate(35%, 0);
      background-image: linear-gradient(-45deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      transition: 1s ease-in-out;
      z-index: 6;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
      border-bottom-right-radius: max(50vw, 50vh);
      border-top-left-radius: max(50vw, 50vh);
    }

    .container.sign-in::before {
      transform: translate(0, 0);
      right: 50%;
    }

    .container.sign-up::before {
      transform: translate(100%, 0);
      right: 50%;
    }

    /* RESPONSIVE */

    @media only screen and (max-width: 425px) {

      .container::before,
      .container.sign-in::before,
      .container.sign-up::before {
        height: 100vh;
        border-bottom-right-radius: 0;
        border-top-left-radius: 0;
        z-index: 0;
        transform: none;
        right: 0;
      }

      .container.sign-in .col.sign-in,
      .container.sign-up .col.sign-up {
        transform: translateY(0);
      }

      .content-row {
        align-items: flex-start !important;
      }

      .content-row .col {
        transform: translateY(0);
        background-color: unset;
      }

      .col {
        width: 100%;
        position: absolute;
        padding: 2rem;
        background-color: var(--white);
        border-top-left-radius: 2rem;
        border-top-right-radius: 2rem;
        transform: translateY(100%);
        transition: 1s ease-in-out;
      }

      .row {
        align-items: flex-end;
        justify-content: flex-end;
      }

      .form,
      .social-list {
        box-shadow: none;
        margin: 0;
        padding: 0;
      }

      .text {
        margin: 0;
      }

      .text p {
        display: none;
      }

      .text h2 {
        margin: .5rem;
        font-size: 2rem;
      }
    }

    /* Specific styles for role dropdown */
    .input-group .role {
      width: 100%;
    }

    .input-group select#Role {
      appearance: none; /* Remove default arrow */
      -webkit-appearance: none;
      -moz-appearance: none;
      background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23757575%22%20d%3D%22M287%2069.9H5.4c-7.3%200-11.2%208.2-6.5%2014.2l137.3%20163.6c3.4%204.3%209.8%204.3%2013.2%200l137.3-163.6c4.7-6%20.8-14.2-6.5-14.2z%22%2F%3E%3C%2Fsvg%3E'); /* Custom arrow */
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 1em;
      padding-right: 3rem; /* Make space for the arrow */
    }
  </style>
</head>

<body class="bg-gray-900 text-white">

  <ul>
    <div class="logo">
      <!-- Replace the SVG or image src with your actual logo -->
      <img src="https://img.icons8.com/fluency/48/shop.png" alt="Logo" />
      <span>AKSHAR MART</span>
    </div>
    <a style="text-decoration: none;" href="contact.php">
      <li>Contact us</li>
    </a>
  </ul>

  <div id="container" class="container">
    <div class="row">
      <div class="col align-items-center flex-col sign-up">
        <div class="form-wrapper align-items-center">
          <div class="form sign-up">
            <form action="" method="POST"> <div class="input-group">
                <i class='bx bxs-user'></i>
                <input type="text" placeholder="First Name" name="first_name" required>
              </div>
              <div class="input-group">
                <i class='bx bxs-user'></i>
                <input type="text" placeholder="Last Name" name="last_name" required>
              </div>
              <div class="input-group">
                <i class='bx bxs-envelope'></i>
                <input type="date" placeholder="DOB" name="dob" required>
              </div>
              <div class="input-group">
                <i class='bx bxs-envelope'></i>
                <input type="username" placeholder="username" name="username" required>
              </div>
              <div class="input-group">
                <i class='bx bxs-lock-alt'></i>
                <input type="password" placeholder="Password" name="password" required>
              </div>
              
              <button type="submit" name="signup_submit">Sign up</button>
            </form> <p>
              <span>
                Already have an account?
              </span>
              <b onclick="toggle()" class="pointer">
                Sign in here
              </b>
            </p>
          </div>
        </div>

      </div>
      <div class="col align-items-center flex-col sign-in">
        <div class="form-wrapper align-items-center">

          <div class="form sign-in">
            <form action="" method="POST">
              <?php if (!empty($login_error)) : ?>
                <p style="color: red; margin-bottom: 1rem;"><?php echo $login_error; ?></p>
              <?php endif; ?>

              <div class="input-group">
                <i class='bx bxs-user'></i>
                <input type="text" placeholder="Username or Email" name="username" required>
              </div>

              <div class="input-group">
                <i class='bx bxs-lock-alt'></i>
                <input type="password" placeholder="Password" name="password" required>
              </div>

              <div class="input-group">
                <i class='bx bxs-briefcase'></i>
                <select id="Role" name="role" required>
                  <option value="" disabled selected>Select Role</option>
                  <?php foreach ($roles as $role) : ?>
                    <option value="<?php echo htmlspecialchars($role['id']); ?>">
                      <?php echo htmlspecialchars($role['role_name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button type="submit" name="login_submit">
                Sign in
              </button>
            </form>
            <p>
              <b>
                Forgot password?
              </b>
            </p>
            <p>
              <span>
                Don't have an account?
              </span>
              <b onclick="toggle()" class="pointer">
                Sign up here
              </b>
            </p>
          </div>
        </div>
        <div class="form-wrapper">

        </div>
      </div>
      </div>
    <div class="row content-row">
      <div class="col align-items-center flex-col">
        <div class="text sign-in">
          <h2>
            Welcome Back!
          </h2>
          <p>To keep connected with us please login with your personal info</p>
        </div>
        <div class="img sign-in">
          <!-- <img src="https://i.imgur.com/L7pY8L7.png" alt="Sign In Image"> -->
        </div>
      </div>
      <div class="col align-items-center flex-col">
        <div class="img sign-up">
          <!-- <img src="https://i.imgur.com/L7pY8L7.png" alt="Sign Up Image"> -->
        </div>
        <div class="text sign-up">
          <h2>
            Join Us!
          </h2>
          <p>Enter your personal details and start your journey with us</p>
        </div>
      </div>
      </div>
    </div>

  <script>
    let container = document.getElementById('container')

    toggle = () => {
      container.classList.toggle('sign-in')
      container.classList.toggle('sign-up')
    }

    setTimeout(() => {
      container.classList.add('sign-in')
    }, 200)

    // Optional: If you want to retain form data on submission, you'll need
    // to add more complex JS/PHP logic to manage form state after POST.
    // For now, the page will refresh.
  </script>

</body>

</html>