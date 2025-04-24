<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        footer {
            flex-shrink: 0;
            width: 100%;
            background-color: #6c243c;
            color: white;
            padding: 20px 0;
            margin-top: auto;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-section {
            width: 18%;
        }

        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 8px;
        }

        .footer-section ul li a {
            text-decoration: none;
            color: white;
            font-size: 14px;
        }

        .footer-section ul li a:hover {
            text-decoration: underline;
        }

        .contact p {
            font-size: 14px;
            margin: 5px 0;
        }

        .contact a {
            color: white;
        }

        .socialMedia a {
            width: 50px;
            height: 50px;
            text-decoration: none;
            text-align: right;
            margin-right: 15px;
            border-radius: 5px;
            transition: 0.4s;
            padding: 2px;
        }

        .socialMedia a i {
            color: #ddd;
            font-size: 25px;
            line-height: 35px;
            border: 1px solid transparent;
            transition-delay: 0.4s;
        }

        .socialMedia a:hover i {
            color: rgb(203, 128, 170);
        }

        .copyright {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/ProjectCraft/Main/homepage.php">Home</a></li>
                    <li><a href="#">Crafts</a></li>
                    <li><a href="#">Home-decor</a></li>
                    <li><a href="#">Jewellery</a></li>
                    <li><a href="#">Accessories</a></li>
                    <li><a href="#">Wall Decor</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Customer Service</h3>
                <ul>
                    <li><a href="#">Track Order</a></li>
                    <li><a href="#">Shipping & Payments</a></li>
                    <li><a href="#">Return & Exchanges</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Cookies Policy</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Craft Maestros</h3>
                <ul>
                    <li><a href="/ProjectCraft/Main/about.php">About Us</a></li>
                    <li><a href="#">Our Maestros</a></li>
                    <li><a href="/ProjectCraft/Main/contact.php">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-section contact">
                <h3>Contact Us</h3>
                <p>321,3rd Floor,Super Mall Nr. Lal Bungalow , C.G.Road,Navrangpura , Ahmedabad - 380009</p>
                <p>+91-9924818234</p>
                <p><a href="mailto:Fernwehtechnologies@gmail.com">Fernwehtechnologies@gmail.com</a></p>
                <div class="socialMedia">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <div class="copyright">
            <p>© 2021 Craft Maestros. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>