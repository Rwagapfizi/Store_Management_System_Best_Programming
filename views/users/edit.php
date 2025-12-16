<?php
$pageTitle = 'Edit User';
require_once 'views/layouts/header.php';

// These variables should be passed from the controller
// $user, $id, $countries
?>

<div class="container form_container">
    <h2>UPDATE USER <?php echo isset($user['userId']) ? $user['userId'] : ''; ?></h2>

    <form action="<?php echo BASE_URL; ?>user/update/<?php echo isset($user['userId']) ? $user['userId'] : ''; ?>" method="POST">
        <div class="row">
            <label for="firstname">First name: </label>
            <input
                type="text"
                name="firstname"
                id="firstname"
                placeholder="firstname"
                required="required"
                value="<?php echo isset($user['firstName']) ? htmlspecialchars($user['firstName']) : ''; ?>" />
        </div>

        <div class="row">
            <label for="lastname">Last name: </label>
            <input
                type="text"
                name="lastname"
                id="lastname"
                placeholder="lastname"
                required="required"
                value="<?php echo isset($user['lastName']) ? htmlspecialchars($user['lastName']) : ''; ?>" />
        </div>

        <div class="row">
            <label for="telephone">Telephone: </label>
            <input
                type="tel"
                name="telephone"
                id="telephone"
                placeholder="telephone"
                required="required"
                value="<?php echo isset($user['telephone']) ? htmlspecialchars($user['telephone']) : ''; ?>" />
        </div>

        <div class="row">
            <label>Gender: </label>
            <?php if (isset($user['gender']) && $user['gender'] == 'Male'): ?>
                <input type="radio" name="gender" id="male" value="Male" checked required />
            <?php else: ?>
                <input type="radio" name="gender" id="male" value="Male" required />
            <?php endif; ?>
            <label for="male">Male</label>

            <?php if (isset($user['gender']) && $user['gender'] == 'Female'): ?>
                <input type="radio" name="gender" id="female" value="Female" checked required />
            <?php else: ?>
                <input type="radio" name="gender" id="female" value="Female" required />
            <?php endif; ?>
            <label for="female">Female</label>
        </div>

        <div class="row">
            <label for="nationality">Nationality: </label>
            <select name="nationality" id="nationality" required>
                <option value="">-Select-</option>
                <?php
                $countries = ['Rwanda', 'Kenya', 'Burundi', 'Uganda', 'Tanzania', 'DRC', 'Russia', 'Italy', 'other'];
                foreach ($countries as $country):
                    $selected = (isset($user['nationality']) && $user['nationality'] == $country) ? 'selected' : '';
                ?>
                    <option value="<?php echo $country; ?>" <?php echo $selected; ?>>
                        <?php echo $country; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <label for="username">User Name: </label>
            <input type="text" name="username" id="username" placeholder="user name" required="required"
                value="<?php echo isset($user['username']) ? htmlspecialchars($user['username']) : ''; ?>" />
        </div>

        <div class="row">
            <label for="Email">Email: </label>
            <input
                type="email"
                name="email"
                id="email"
                placeholder="email"
                required="required"
                value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" />
        </div>

        <div class="row">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="password" required />
        </div>

        <div class="row">
            <label for="confirmpassword">Confirm Password: </label>
            <input type="password" name="cpassword" id="confirmpassword" placeholder="confirm password" required="required" />
        </div>

        <input type="submit" value="Update User" name="Register" />
    </form>

    <div class="action-links">
        <a href="<?php echo BASE_URL; ?>user">Back to Users</a>
        <a href="<?php echo BASE_URL; ?>">Back to Home</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>