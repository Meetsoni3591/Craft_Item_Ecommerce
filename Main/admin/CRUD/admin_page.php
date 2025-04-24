<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin_page.css">
</head>
<body>
    <div class="container">
        <div class="admin-produc-form-container">
        <form method="POST" action="admin_page.php" enctype="multipart/form-data">
    <h3>ADD NEW PRODUCT</h3>

    <input type="text" placeholder="Enter Product Name" name="product_name" class="box" required>
    
    <textarea placeholder="Enter Product Description" name="product_description" class="box" required></textarea>
    
    <input type="number" placeholder="Enter Product Price" name="product_price" class="box" step="0.01" required>
    
    <input type="file" accept="image/*" name="product_image" class="box" required>
    
    <input type="text" placeholder="Enter Product Category" name="product_category" class="box" required>
    
    <input type="text" placeholder="Enter Product Sub-Category" name="product_sub_category" class="box" required>
    
    <input type="number" placeholder="Enter Stock Quantity" name="product_stock" class="box" min="0" required>

    <button type="submit" class="btn" name="add_product" value="submit">Add A Product</button>
</form>

        </div>
      
    </div>
</body>
</html>
<?php
$con=mysqli_connect("localhost","root","","project_craft");

if(isset($_POST['add_product'])) 
{
    $product_name=$_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price=$_POST['product_price'];
    $product_category = $_POST['product_category'];
    $product_sub_category = $_POST['product_sub_category'];
    $product_stock = $_POST['product_stock'];
    $product_image = isset($_FILES['product_image']['name']) ? $_FILES['product_image']['name'] : '';
    $product_image_tmp_name = isset($_FILES['product_image']['tmp_name']) ? $_FILES['product_image']['tmp_name'] : '';
    $product_image_folder='C:/xampp/htdocs/ProjectCraft/Main/admin/CRUD/images/'.$product_image;

    if(empty($product_name) || empty($product_price) || empty($product_image))
    {
        $msg[]="please fill out the deatails";
    }
    else{
        $insert="INSERT INTO product_table (name, description, price, image, category, sub_category, stock) 
                VALUES ('$product_name', '$product_description', '$product_price', '$product_image', '$product_category', '$product_sub_category', '$product_stock')";
        $upload=mysqli_query($con,$insert);
        if ($upload) {
            if (move_uploaded_file($product_image_tmp_name, $product_image_folder)) {
                $msg[] = "New product added successfully";
            } else {
                $msg[] = "Product added, but could not upload image";
            }
        } else {
            $msg[] = "Could not add product successfully";
        }
        
    }
}
?>


<?php
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM product_table WHERE id = $id";
    $delete_result = mysqli_query($con, $delete_query);

    if($delete_result) {
        $msg[] = "Product deleted successfully";
    } else {
        $msg[] = "Failed to delete product";
    }
}
?>


<div class="product-list">
    <?php
    $query = "SELECT * FROM product_table";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0) {
        echo '<ul>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<li>';
            echo 'Name: ' . $row['name'] . '<br>';
            echo "<p>" . $row['description'] . "</p>";
            echo 'Price: ' . $row['price'] . '<br>';
            echo "<p>Category: " . $row['category'] . " | Sub-Category: " . $row['sub_category'] . "</p>";
            echo "<p>Stock: " . $row['stock'] . "</p>";
            echo '<img src="/ProjectCraft/Main/admin/CRUD/images/' . $row['image'] . '?t='.time().'" alt="' . $row['name'] . '" style="width:200px;height:200px;"><br>';
            echo '<a href="admin_page.php?delete=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>';
            echo ' | <a href="admin_page.php?edit=' . $row['id'] . '">edit</a>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No products found';
    }
    ?>
</div>
<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = "SELECT * FROM product_table WHERE id = $id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
?>
    <div class="container">
    <div class="admin-produc-form-container">
        <form method="POST" action="admin_page.php" enctype="multipart/form-data">
            <h3>UPDATE PRODUCT</h3>
            <input type="hidden" name="update_id" value="<?= $row['id']; ?>">
            
            <input type="text" name="update_name" value="<?= $row['name']; ?>" class="box" required>
            
            <textarea name="update_description" class="box" required><?= $row['description']; ?></textarea>
            
            <input type="number" name="update_price" value="<?= $row['price']; ?>" class="box" step="0.01" required>
            
            <input type="text" name="update_category" value="<?= $row['category']; ?>" class="box" required>
            
            <input type="text" name="update_sub_category" value="<?= $row['sub_category']; ?>" class="box" required>
            
            <input type="number" name="update_stock" value="<?= $row['stock']; ?>" class="box" min="0" required>
            
            <input type="file" accept="image/*" name="update_image" class="box">
            
            <button type="submit" class="btn" name="update_product">Update Product</button>
        </form>
    </div>

<?php
}
?>
<?php
if (isset($_POST['update_product'])) {
    $update_id = $_POST['update_id'];
    $update_name = $_POST['update_name'];
    $update_description = $_POST['update_description'];
    $update_price = $_POST['update_price'];
    $update_category = $_POST['update_category'];
    $update_sub_category = $_POST['update_sub_category'];
    $update_stock = $_POST['update_stock'];
    
    // Check if a new image is uploaded
    if (!empty($_FILES['update_image']['name'])) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'C:/xampp/htdocs/ProjectCraft/Main/admin/CRUD/images/' . $update_image;

        // Move the new image to the folder
        move_uploaded_file($update_image_tmp_name, $update_image_folder);

        // Update query with image
        $update_query = "UPDATE product_table SET 
            name = '$update_name',
            description = '$update_description',
            price = '$update_price',
            category = '$update_category',
            sub_category = '$update_sub_category',
            stock = '$update_stock',
            image = '$update_image' 
            WHERE id = $update_id";
    } else {
        // Update query without changing image
        $update_query = "UPDATE product_table SET 
            name = '$update_name',
            description = '$update_description',
            price = '$update_price',
            category = '$update_category',
            sub_category = '$update_sub_category',
            stock = '$update_stock'
            WHERE id = $update_id";
    }

    $update_result = mysqli_query($con, $update_query);
    if ($update_result) {
        header("Location: admin_page.php");
        exit();  // Ensures no further code execution
    } else {
        die("Failed to update product: " . mysqli_error($con));
    }
    
}
?>

