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



<img width="1458" height="824" alt="image" src="https://github.com/user-attachments/assets/08d3882a-a8dc-48b3-ac1d-e1cf8b6f4c81" />

<img width="1466" height="834" alt="image" src="https://github.com/user-attachments/assets/7160b7e0-c19a-4778-a997-1681727e5e1a" />
