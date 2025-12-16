<?php
$pageTitle = 'Register User';
require_once 'views/layouts/header.php';
?>

<div class="container form_container">
    <h2>REGISTER USER</h2>

    <form action="<?php echo BASE_URL; ?>user/store" method="POST">
        <div class="row">
            <label for="firstname">First name: </label>
            <input
                type="text"
                name="firstname"
                id="firstname"
                placeholder="First Name"
                required="required" />
        </div>

        <div class="row">
            <label for="lastname">Last name: </label>
            <input
                type="text"
                name="lastname"
                id="lastname"
                placeholder="Last Name"
                required="required" />
        </div>

        <div class="row">
            <label for="telephone">Telephone: </label>
            <input
                type="tel"
                name="telephone"
                id="telephone"
                placeholder="Telephone"
                required="required" />
        </div>

        <div class="row">
            <label>Gender: </label>
            <input type="radio" name="gender" id="male" value="Male" required />
            <label for="male">Male</label>
            <input type="radio" name="gender" id="female" value="Female" />
            <label for="female">Female</label>
        </div>

        <div class="row">
            <label for="nationality">Nationality: </label>
            <select name="nationality" id="nationality" required>
                <option value="">-Select-</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Kenya">Kenya</option>
                <option value="Burundi">Burundi</option>
                <option value="Uganda">Uganda</option>
                <option value="Tanzania">Tanzania</option>
                <option value="DRC">DRC</option>
                <option value="Russia">Russia</option>
                <option value="Italy">Italy</option>
                <option value="other">other</option>
            </select>
        </div>

        <div class="row">
            <label for="Email">Email: </label>
            <input
                type="email"
                name="email"
                id="email"
                placeholder="Email"
                required="required" />
        </div>

        <div class="row">
            <label for="username">User Name: </label>
            <input type="text" name="username" id="username" placeholder="User Name" required="required" />
        </div>

        <div class="row">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="Password" required />
        </div>

        <div class="row">
            <label for="confirmpassword">Confirm Password: </label>
            <input type="password" name="cpassword" id="confirmpassword" placeholder="Confirm Password" required="required" />
        </div>

        <input type="submit" value="Register User" name="Register" />
    </form>

    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>user">Back to Users List</a>
        <a href="<?php echo BASE_URL; ?>">Back to Home</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>