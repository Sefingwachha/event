<?php
// contact.php

require_once 'db.php';
include 'templates/header.php';

// Authentication check: Ensure only logged-in users can see this page.
// Redirects to the main landing page if not logged in.
if (!$is_loggedin) {
    header("location: /event-management-system/index.php");
    exit;
}
?>

<div class="card">
    <h2><i class='bx bxs-paper-plane'></i> Get in Touch</h2>
    <p>For any inquiries, feedback, or support regarding the Ayojan Pro project, please feel free to reach out to the developer.</p>

    <div class="contact-details">
        <h3>Developer Information</h3>
        <ul>
            <li><strong>Name:</strong> Saishan Gimire</li>
            <li><strong>Email:</strong> <a href="mailto:contact.saishan@example.com">contact.saishan@example.com</a></li>
            <li><strong>Location:</strong> Kathmandu, Nepal</li>
        </ul>
    </div>

  
</div>

<?php include 'templates/footer.php'; ?>
