<?php
// about.php

require_once 'db.php';
include 'templates/header.php';

// Authentication check
if (!$is_loggedin) {
    header("location: /event-management-system/auth/login.php");
    exit;
}
?>

<div class="card">
    <h2><i class='bx bxs-info-circle'></i> About Ayojan Pro (आयोजन प्रो)</h2>
    
    <p><strong>Namaste and welcome to Ayojan Pro!</strong></p>
    
    <p>
        Proudly developed in Nepal, Ayojan Pro is a modern solution designed to bring communities and companies together by simplifying event management. Our mission is to provide a clean, secure, and efficient platform for organizing gatherings, from small team meetings to large-scale corporate functions.
    </p>

    <div class="developer-card">
        <h4>A Word from the Developer</h4>
        <blockquote>
            "Technology has the power to connect us. With Ayojan Pro, my goal was to create a tool that is not only powerful for administrators but also simple and welcoming for every user. It's a project built with a passion for clean code and a love for our community here in Nepal."
            <cite>– Saishan Gimire</cite>
        </blockquote>
    </div>

    <h4>Our Technology</h4>
    <p>Powered by the reliable backend of PHP and MySQL, Ayojan Pro features a responsive and intuitive user interface built with modern CSS and enhanced with JavaScript for a seamless experience.</p>
</div>

<?php include 'templates/footer.php'; ?>
