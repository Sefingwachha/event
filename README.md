event-management-system/
├── index.php                 # The main public landing page with login form
├── dashboard.php             # The private "home" page for regular users
├── about.php                 # The personalized "About Us" page
├── contact.php               # The personalized "Contact" page
├── db.php                    # Database connection settings
│
├── admin/
│   └── index.php             # The Admin Dashboard with statistics
│
├── auth/
│   ├── login.php             # Standalone login page (now integrated into index.php)
│   ├── logout.php            # Destroys the session to log a user out
│   └── register.php          # Public user registration page
│
├── css/
│   └── style.css             # All styling for the entire application
│
├── js/
│   └── main.js               # JavaScript for dark mode and live search
│
├── templates/
│   ├── header.php            # Builds the sidebar and header for logged-in users
│   └── footer.php            # Closes the layout and includes the JS file
│
├── events/
│   ├── list.php              # Displays the list of events (view-only for users)
│   ├── create.php            # (Admin Only) Form to create a new event
│   ├── update.php            # (Admin Only) Form to edit an existing event
│   └── delete.php            # (Admin Only) Script to delete an event
│
├── attendees/
│   ├── list.php              # Displays the list of attendees (view-only for users)
│   ├── create.php            # (Admin Only) Form to add a new attendee
│   ├── update.php            # (Admin Only) Form to edit an attendee
│   └── delete.php            # (Admin Only) Script to delete an attendee
│
└── sql/
    └── event_management.sql  # The script to create your database tables & users




    Ayojan Pro (आयोजन प्रो) is a complete, full-stack Event Management System developed by Saishan Gimire. It provides a secure and organized platform for managing events and their attendees through a clean, modern web interface.

Key features include:

Role-Based Security: A strict separation between Administrators, who have full control over all data, and regular Users, who have view-only access.

Full CRUD Functionality: Administrators can create, read, update, and delete events and attendee records.

Admin Dashboard: A central hub for administrators that displays key statistics like total events and recent registrations.

Public Landing Page: A professional, public-facing page that details the project's features and includes an integrated login system.

Modern Tech Stack: Built with raw PHP and MySQL for the backend, and a responsive, mobile-friendly frontend styled with modern CSS and enhanced with JavaScript for features like dark mode and live search.






    Username: admin

Password: password123

Secondary Admin Accounts

Username: admin2

Password: admin456

Username: manager

Password: manager789



user:

Username: saishab

Password: 12345678

<img width="1447" height="831" alt="image" src="https://github.com/user-attachments/assets/f85213c4-dd35-4f75-a4b6-daf58bb15081" />

<img width="1464" height="834" alt="image" src="https://github.com/user-attachments/assets/01d82c36-d1b6-4651-94bd-00b71a1d96b8" />


<img width="1463" height="832" alt="image" src="https://github.com/user-attachments/assets/5ed5c4eb-b09b-4b2a-8e79-eb048a32cd9b" />

<img width="1470" height="831" alt="image" src="https://github.com/user-attachments/assets/af146f7e-4e31-4618-9d5f-a34fa0b94781" />


<img width="1458" height="824" alt="image" src="https://github.com/user-attachments/assets/08d3882a-a8dc-48b3-ac1d-e1cf8b6f4c81" />

<img width="1466" height="834" alt="image" src="https://github.com/user-attachments/assets/7160b7e0-c19a-4778-a997-1681727e5e1a" />
