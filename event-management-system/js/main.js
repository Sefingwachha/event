// js/main.js (With Dark Mode)

// --- Dark Mode Toggle ---
const darkModeToggle = document.getElementById('darkModeToggle');
const body = document.body;

// Function to enable dark mode
const enableDarkMode = () => {
    body.classList.add('dark-mode');
    localStorage.setItem('darkMode', 'enabled');
};

// Function to disable dark mode
const disableDarkMode = () => {
    body.classList.remove('dark-mode');
    localStorage.setItem('darkMode', 'disabled');
};

// Check local storage for user preference
if (localStorage.getItem('darkMode') === 'enabled') {
    enableDarkMode();
}

// Add event listener to the toggle button
darkModeToggle.addEventListener('click', () => {
    if (body.classList.contains('dark-mode')) {
        disableDarkMode();
    } else {
        enableDarkMode();
    }
});


// --- Live Search Functions (Unchanged) ---
function searchEvents() {
    const input = document.getElementById("eventSearch");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("eventTable");
    const tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) { // Start from 1 to skip header
        let tdName = tr[i].getElementsByTagName("td")[0];
        let tdLocation = tr[i].getElementsByTagName("td")[2];
        
        if (tdName || tdLocation) {
            let nameText = tdName.textContent || tdName.innerText;
            let locationText = tdLocation.textContent || tdLocation.innerText;
            
            if (nameText.toUpperCase().indexOf(filter) > -1 || locationText.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function searchAttendees() {
    const input = document.getElementById("attendeeSearch");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("attendeeTable");
    const tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) { // Start from 1 to skip header
        let tdName = tr[i].getElementsByTagName("td")[0];
        let tdEmail = tr[i].getElementsByTagName("td")[1];
        
        if (tdName || tdEmail) {
            let nameText = tdName.textContent || tdName.innerText;
            let emailText = tdEmail.textContent || tdEmail.innerText;
            
            if (nameText.toUpperCase().indexOf(filter) > -1 || emailText.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
