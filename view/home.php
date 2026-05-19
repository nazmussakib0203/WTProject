<?php session_start(); 

if(!isset($_SESSION['books'])){
    header('Location: ../control/home_process.php');
    exit;
}
$books = $_SESSION['books'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bookstore - Home</title>
    <link rel="stylesheet" href="/Bookstore/css/mystyle.css">
    <script src="/Bookstore/js/myscript.js" defer></script>
</head>
<body>

<div class="navbar">
    <div class="logo">Book<span>store</span></div>
    <div class="nav-links">
        <a href="../control/home_process.php">Home</a> | 
        <a href="../control/cart_process.php">Cart</a>
    </div>
</div>

<div style="padding:20px; max-width:1200px; margin:0 auto;">
    <h2>Search Books</h2>
    <div style="margin:15px 0; display:flex; gap:10px;">
        <input type="text" id="searchInput" placeholder="Search..." style="padding:8px; width:300px; border-radius:4px; border:1px solid #ccc;">
        <select id="filterSelect" style="padding:8px; border-radius:4px;">
            <option value="title">By Title</option>
            <option value="author">By Author</option>
            <option value="category">By Category</option>
        </select>
        <button onclick="searchBooks()" style="padding:8px 15px; background:#667eea; color:white; border:none; border-radius:4px; cursor:pointer;">Search</button>
        <button onclick="location.href='../control/home_process.php'" style="padding:8px 15px; background:#764ba2; color:white; border:none; border-radius:4px; cursor:pointer;">All Books</button>
    </div>

    <div id="results">
        <h3>All Books:</h3>
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap:20px; margin-top:15px;">
            <?php foreach($books as $row): ?>
                <div style="border:1px solid #ddd; padding:15px; background:white; border-radius:8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <h4 style="margin-bottom:8px; color:#333;"><?php echo htmlspecialchars($row['Title']); ?></h4>
                    <p style="margin:4px 0; font-size:14px; color:#666;"><strong>Author:</strong> <?php echo htmlspecialchars($row['Author']); ?></p>
                    <p style="margin:4px 0; font-size:14px; color:#e74c3c;"><strong>Price:</strong> $<?php echo number_format($row['Price'], 2); ?></p>
                    <a href="book_detail.php?id=<?php echo $row['ID']; ?>" style="display:inline-block; margin-top:10px; color:#764ba2; font-weight:bold; text-decoration:none; font-size:14px;">View Details →</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</body>
</html>