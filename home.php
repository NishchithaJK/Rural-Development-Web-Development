<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Include database connection
include 'db_connect.php';

// Search for villager by village ID
if (isset($_POST['search'])) {
    $village_id = $_POST['village_id'];
    header("Location: profile.php?village_id=" . $village_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Lora:wght@700&display=swap"
        rel="stylesheet">
    <title>Village Panchayat Home</title>
</head>

<body>

    <header>
        <div class="header-left">
            <h1> VILLAGE DEVELOPMENT BOARD</h1>
        </div>
        <div class="header-right">
            <p>Welcome, <?php echo $_SESSION['username']; ?>
            <a href="logout.php" class="logout-btn">Logout</a></p>
        </div>
    </header>

    <div class="notifications">
        <marquee>🔔 New government schemes announced! Check them out in the schemes section! | Health camp scheduled for
            October 5th. | New road construction starts next week!</marquee>
    </div>

    <div class="main-content">

        <div class="sidebar">
            <h3>PANCHAYAT SCHEMES</h3>
            <ul>
                <li>
                    <a href="https://www.nrega.nic.in/netnrega/home.aspx" target="_blank" class="scheme-link">
                        <img src="IMG-20240927-WA0003.jpg"
                            alt="NREGA Logo" class="scheme-img"> Mahatma Gandhi NREGA
                    </a>
                </li>
                <li>
                    <a href="https://pmjdy.gov.in/" target="_blank" class="scheme-link">
                        <img src="IMG-20240927-WA0004.jpg" alt="Jan Dhan Logo" class="scheme-img"> Pradhan Mantri Jan
                        Dhan Yojana
                    </a>
                </li>
                <li>
                    <a href="https://www.pmindia.gov.in/en/initiative/pm-kisan/" target="_blank" class="scheme-link">
                        <img src="PMkissan.jpg" alt="PM Kisan Logo" class="scheme-img"> PM Kisan Samman Nidhi
                    </a>
                </li>
                <li>
                    <a href="https://www.aajeevika.gov.in/" target="_blank" class="scheme-link">
                        <img src="IMG-20240927-WA0005.jpg" alt="NRLM Logo" class="scheme-img"> National Rural Livelihood
                        Mission
                    </a>
                </li>
                <li>
                    <a href="https://rural.nic.in/" target="_blank" class="scheme-link">
                        <img src="ministerofrural.jpg" alt="Rural Development Logo" class="scheme-img"> Ministry of
                        Rural Development
                    </a>
                </li>
                <li>
                    <a href="https://www.digitalindia.gov.in/" target="_blank" class="scheme-link">
                        <img src="IMG-20240927-WA0007.jpg" alt="Digital India Logo" class="scheme-img"> Digital
                        India Initiative
                    </a>
                </li>
                <li>
                    <a href="https://rural.nic.in/sites/default/files/PMGSY_0.pdf" target="_blank" class="scheme-link">
                        <img src="IMG-20240927-WA0006.jpg" alt="PMGSY Logo" class="scheme-img"> PM Gram Sadak Yojana
                    </a>
                </li>
                <li>
                    <a href="https://pmaymis.gov.in/" target="_blank" class="scheme-link">
                        <img src="IMG-20240927-WA0008.jpg" alt="PMAY Logo" class="scheme-img"> Pradhan Mantri Awas Yojana
                    </a>
                </li>
            </ul>
        </div>

        <div class="center-content">
            <h2>About the Village Panchayat</h2>
            <p>
                The Village Panchayat is the cornerstone of rural development in India. It oversees
                various schemes and initiatives aimed at improving the livelihood and well-being of
                villagers. Through these schemes, we focus on education, healthcare, infrastructure,
                agriculture, and more to uplift the rural population.
            </p>
            <p>
                Panchayats play a pivotal role in implementing government policies at the grassroots
                level and ensuring that all residents have access to basic services. These bodies help
                decentralize governance, empowering rural areas to take control of their own development.
            </p>

            <!-- Local Products Promotion -->
            <div class="local-products-section">
                <h2>Support Local Products</h2>
                <p>
                    We encourage everyone to buy local products from our village! By supporting local artisans
                    and farmers, you contribute to our community's growth and sustainability.
                </p>
                <p>
                    As the first village to achieve cleanliness and proper sanitation, we are proud to offer a
                    <strong>15% discount</strong> on purchases over <strong>₹500</strong>.
                    Shop for fresh and organic items like <strong>Desi Ghee</strong> and more!
                </p>
                <p>
                    Join us in promoting our local economy!
                    Explore our <a href="products.php" class="shopping-link">shopping page</a> to make your purchase.
                </p>
            </div>
        </div>
    </div>

    <footer>
        <div class="search-bar">
            <form method="post" action="">
                <label for="village_id">Search Villager by Village ID:</label>
                <input type="text" name="village_id" required>
                <button type="submit" name="search">Search</button>
            </form>
        </div>
    </footer>

</body>

</html>