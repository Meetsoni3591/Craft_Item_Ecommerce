<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forged with touch !</title>
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<style>
  * {
    padding: 0px;
    margin: 0px;
  }

  .header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 5px;
    background-color: #eabbd1;
    text-align: center;
  }

  .top-bar {
    background-color: #560e30;
    /*..first sign up */
    text-align: center;
    padding: 10px;
    font-size: 14px;
    color: #f5f8f8;
    font-weight: bold;
    font-style: normal;
  }

  .header ul,
  .header li {
    margin: 0;
    padding: 0;
    list-style: none;
  }

  /* .header ul {
	background: rgb(64, 60, 60);
	list-style: none;
	width: 0%;
} */
  .header li {
    float: left;
    position: relative;
    /* width:auto; */
  }

  .header a {

    color: #560e30;
    display: block;
    font: bold 15px sans-serif;
    padding: 10px 25px;
    text-align: center;
    text-decoration: none;
    -webkit-transition: all .25s ease;
    -moz-transition: all .25s ease;
    -ms-transition: all .25s ease;
    -o-transition: all .25s ease;
    transition: all .25s ease;
  }

  .header li:hover a {
    background-color: #f3d9e5;
    /* header crafts background color */
  }


  #submenu {
    left: 0;
    opacity: 0;
    position: absolute;
    top: 35px;
    visibility: hidden;
    z-index: 1;
  }

  li:hover ul#submenu {
    opacity: 1;
    top: 40px;
    /* adjust this as per top nav padding top & bottom comes */
    visibility: visible;
  }

  #submenu li {
    float: none;
    width: 100%;
  }

  #submenu a:hover {

    background-color: #dd88b0;
    /*drop down hover*/
  }

  #submenu a {

    background-color: #f3d9e5;
    /*drop down background*/
  }

  .icon {
    display: flex;
    align-items: center;
    gap: 15px;
    /* Space between icons */
  }

  .icon-link {
    text-decoration: none;
    color: #333;
    /* Icon color */
    font-size: 24px;
    /* Adjust icon size */
    transition: color 0.3s ease;
  }

  .icon-link:hover {
    color: #ff5733;
    /* Change color on hover */
  }
</style>

<body>
  <div class="top-bar">
    <div class="offer">Sign up & get 10% Off on your first purchase</div>
  </div>
  <section class="header">
    <a href="/ProjectCraft/Main/homepage.php"><img src="logo.png" width="100"></a>
    <li><a href="#">CRAFT</a>
      <ul id="submenu">
        <li><a href="/ProjectCraft/Main/Crafts/Ajrakh.php">Ajrakh</a></li>
        <li><a href="/ProjectCraft/Main/Crafts/Beaded Jewellery.php">Beaded Jewellery</a></li>
        <li><a href="/projectCraft/Main/Crafts/Glass art.php">Glass Art</a></li>
        <li><a href="/projectCraft/Main/Crafts/marble art.php">Marble Art</a></li>
        <li><a href="/projectCraft/Main/Crafts/jali work.php">Jali Work on Wood</a></li>
      </ul>
    </li>
    <li><a href="#">HOME-DECOR</a>
      <ul id="submenu">
        <li><a href="/ProjectCraft/Main/Homedecor/bedding_cussion.php">Bedding & Cushions</a></li>
        <li><a href="/ProjectCraft/Main/Homedecor/carpet_rugs.php">Carpets and Rugs</a></li>
        <li><a href="/ProjectCraft/Main/Homedecor/dinning.php">Dining</a></li>
        <li><a href="/ProjectCraft/Main/Homedecor/decor.php">Decor</a></li>

      </ul>
    </li>
    <li><a href="#">JEWELLARY</a>
      <ul id="submenu">
        <li><a href="/ProjectCraft/Main/Jewellery/Earings.php">Earings</a></li>
        <li><a href="/ProjectCraft/Main/Jewellery/Bangles.php">Bangles</a></li>
        <li><a href="/ProjectCraft/Main/Jewellery/Necklace.php">Necklace</a></li>
        <li><a href="/ProjectCraft/Main/Jewellery/Rings.php">Rings</a></li>
        <li><a href="/ProjectCraft/Main/Jewellery/Sets.php">Sets</a></li>
        <li><a href="/ProjectCraft/Main/Jewellery/Pandants.php">Pendants</a></li>
      </ul>
    </li>
    <li><a href="#">ACCESSORIES</a>
      <ul id="submenu">
        <li><a href="/ProjectCraft/Main/Accessories/Hair.php">Hair</a></li>
        <li><a href="/ProjectCraft/Main/Accessories/Stationery.php">Stationery</a></li>
        <li><a href="/ProjectCraft/Main/Accessories/Rakhis.php">Rakhis</a></li>
        <li><a href="/ProjectCraft/Main/Accessories/Shawls and Wraps.php">Shawls and Wraps</a></li>
        <li><a href="/ProjectCraft/Main/Accessories/Bags.php">Bags</a></li>
        <li><a href="/ProjectCraft/Main/Accessories/Bath.php">Bath</a></li>
      </ul>
    </li>
    <li><a href="">WALL DECOR</a>
      <ul id="submenu">
        <li><a href="/ProjectCraft/Main/Wall Decor/Wall Accent.php">Wall Accents</a></li>
        <li><a href="/ProjectCraft/Main/Wall Decor/Wall art.php">Wall art</a></li>
      </ul>
    </li>

    <li><a href="">GIFTING</a>
      <ul id="submenu">
        <li><a href="/ProjectCraft/Main/Gifting/wedding_gift.php">Wedding Gift</a></li>
        <li><a href="/ProjectCraft/Main/Gifting/wellness_gift.php">Wellness Gifting</a></li>
      </ul>
    </li>
    <li><a href="/ProjectCraft/Main/contact.php">CONTACT US</a></li>
    <li><a href="/ProjectCraft/Main/about.php">ABOUT US</a></li>

    <div class="icon">
      <a href="/ProjectCraft/Main/cart.php" class="icon-link">
        <i class="fa-solid fa-cart-shopping"></i>
      </a>
      <a href="/ProjectCraft/Main/wishlist.php" class="icon-link"><i class="fa-solid fa-heart"></i>
        (<span id="wishlist-count">0</span>)
      </a>
      <a href="/ProjectCraft/Main/profile.php" class="icon-link">
        <i class="fa-solid fa-user"></i>
      </a>
    </div>
</div>

</section>
</body>
</html>