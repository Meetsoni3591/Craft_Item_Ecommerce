<div class="product-list">
    <?php
    $con=mysqli_connect("localhost","root","","project_craft");
    $query = "SELECT * FROM product";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0) {
        echo '<ul>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<li>';
            echo 'Name: ' . $row['name'] . '<br>';
            echo 'Price: ' . $row['price'] . '<br>';
            echo '<img src="/ProjectCraft/Main/admin/CRUD/images/' . $row['image'] . '" alt="' . $row['name'] . '" style="width:200px;height:200px;"><br>';
            echo '<a href="admin_page.php?delete=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No products found';
    }
    ?>
</div>