<?php include 'header.php' ?>
<style>
    .inquiry-container {
    display: flex;
    justify-content: space-between;
    max-width: 1100px;
    margin: 50px auto;
    padding: 20px;
}

/* Form Styling */
.form-container {
    flex: 1;
    padding-right: 40px;
}

h2 {
    font-size: 24px;
    font-weight: bold;
    color: #000;
}

label {
    display: block;
    font-size: 14px;
    margin: 10px 0 5px;
}

input,
select,
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

textarea {
    resize: vertical;
}

/* File Input */
.file-types {
    font-size: 12px;
    color: #666;
}

/* Submit Button */
button {
    background-color: #5c1e27;
    color: #fff;
    border: none;
    padding: 10px 15px;
    font-size: 14px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}

button:hover {
    background-color: #47171d;
}

/* Contact Info Section */
.contact-info {
    flex: 0.5;
    padding-left: 40px;
    border-left: 1px solid #ccc;
}

.contact-info p {
    font-size: 14px;
    margin: 10px 0;
}

.contact-info a {
    text-decoration: none;
    color: #9d1b32;
    font-weight: bold;
}

</style>
<section class="inquiry-container">
    <!-- Left Side - Form -->
    <div class="form-container">
      <h2>Inquiry Form</h2>
      <form action="contact.php" method="POST" enctype="multipart/form-data">
        <label for="first-name">First Name *</label>
        <input type="text" id="first-name" name="first-name" required>

        <label for="last-name">Last Name *</label>
        <input type="text" id="last-name" name="last-name" required>

        <label for="phone">Phone Number *</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="email">Email *</label>
        <input type="email" id="email" name="email" required>

        <!-- <label for="department">Department</label>
                <select id="department" name="department">
                    <option selected>Corporate Gifting</option>
                    <option>Customer Support</option>
                    <option>Partnerships</option>
                </select> -->

        <label for="description">Description *</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <!-- <label for="attachment">Attachment</label>
                <input type="file" id="attachment" name="attachment" accept=".jpg, .png, .gif">
                <p class="file-types">Allowed File Types (jpg, png, gif)</p> -->

        <button type="submit">SUBMIT</button>
      </form>
    </div>

    <!-- Right Side - Contact Info -->
    <div class="contact-info">
      <h2>Contact Info</h2>
      <p><strong>Phone -</strong> <span class="phone-number">+91-9924818234</span></p>
      <p><strong>Email -</strong> <a href="Fernwehtechnologies@gmail.com">Fernwehtechnologies@gmail.comom</a></p>
      <p><strong>Address -</strong> 321,3rd Floor,Super Mall Nr. Lal Bungalow , C.G.Road,Navrangpura , Ahmedabad - 38000
      </p>
    </div>
  </section>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_craft";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize a variable to track submission status
$submission_success = false;

// Get form data
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Retrieve form data
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $description = $_POST['description']; 

    // Insert data into the database
    $sql = "INSERT INTO contact (first_name, last_name, phone, email, description) 
            VALUES ('$first_name', '$last_name', '$phone', '$email', '$description')";

    if ($conn->query($sql) === TRUE) {
        // Set success flag to true
        $submission_success = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Close connection
$conn->close();
?>

<?php if ($submission_success): ?>
<script>
    // Show alert when page loads if submission was successful
    window.onload = function() {
        alert("Your inquiry has been submitted successfully!");
        // Redirect to homepage after alert is dismissed
        window.location.href = "contact.php";
    }
</script>
<?php endif; ?>


<?php include 'footer.php' ?>