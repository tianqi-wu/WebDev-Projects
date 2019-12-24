// ajax.js

function loginAjax(event) {
        const username = document.getElementById("username").value; // Get the username from the form
        const password = document.getElementById("password").value; // Get the password from the form
    
        // Make a URL-encoded string for passing POST data:
        const data = { 'username': username, 'password': password };
    
        fetch("login_ajax.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(response => response.json())
    .then(data => document.getElementById("holder2").innerHTML = (data.success ? "You've been logged in! Hello, "+username+"!" : `You were not logged in ${data.message}`));
    }

    document.getElementById("login_btn").addEventListener("click", updateCalendar, false); // Bind the AJAX call to button click
    document.getElementById("login_btn").addEventListener("click", loginAjax, false); // Bind the AJAX call to button click
    
    
    
    function registerAjax(event) {
        const username = document.getElementById("username").value; // Get the username from the form
        const password = document.getElementById("password").value; // Get the password from the form
    
        // Make a URL-encoded string for passing POST data:
        const data = { 'username': username, 'password': password };
    
        fetch("register_ajax.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => document.getElementById("holder2").innerHTML = (data.success ? "You've been registered!" : `You were not registered ${data.message}`));
    }
    
    document.getElementById("register_btn").addEventListener("click", registerAjax, false); // Bind the AJAX call to button click
    
    
    
    function addEventAjax(event) {
        const date = document.getElementById("date").value; // Get the username from the form
        const time = document.getElementById("time").value; // Get the password from the form
        const title = document.getElementById("title").value; 
        const content = document.getElementById("content").value;
        const group = document.getElementById("group").value;
        const token = document.getElementById("token").value;
        // Make a URL-encoded string for passing POST data:
        const data = { 'date': date, 'time': time, 'title': title, 'content': content, 'group': group, 'token': token };
    
        fetch("addEvent_ajax.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => document.getElementById("holder3").innerHTML = (data.success ? "Addition successful!" : `Addition failed ${data.message}`))
            .then(updateCalendar());
    
    
    
    }
    
    document.getElementById("create_events").addEventListener("click", addEventAjax, false); // Bind the AJAX call to button click
    
    
    function logoutAjax(event) {
    
        // Make a URL-encoded string for passing POST data:
        const data = { 'logout': true };
    
        fetch("logout_ajax.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => document.getElementById("holder2").innerHTML = (data.success ? "Logout Successful!" : `You were not logged out. ${data.message}`));
    }
    
    document.getElementById("logout").addEventListener("click", logoutAjax, false); // Bind the AJAX call to button click
    document.getElementById("logout").addEventListener("click", function(){
        setTimeout(updateCalendar()
        ,6540);}, false); // Bind the AJAX call to button click
    function passTokenAjax(event) {
    
        // Make a URL-encoded string for passing POST data:
        const data = { 'token': "<?php echo $_SESSION[token]; ?>" };
    
        fetch("passToken_ajax.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(console.log(data))
            .then(response => response.json())
     .then(data => document.getElementById("token").value = (data.success ? data.value : "0"))
    }
    
    document.getElementById("title").addEventListener("change", passTokenAjax, false);
    document.getElementById("title").addEventListener("change", passTokenAjax, false);
    document.getElementById("date").addEventListener("change", passTokenAjax, false);
    
    document.getElementById("title1").addEventListener("change", passTokenAjax, false);


    document.getElementById("new_content").addEventListener("change", passTokenAjax, false);
    document.getElementById("new_time").addEventListener("change", passTokenAjax, false);


    document.getElementById("your_event_id").addEventListener("change", passTokenAjax, false);
    document.getElementById("other_id").addEventListener("change", passTokenAjax, false);
    
    function deleteEventAjax(event) {
        const date = document.getElementById("date1").value; // Get the username from the form
        const title = document.getElementById("title1").value; 
        const token = document.getElementById("token").value;
        // Make a URL-encoded string for passing POST data:
        const data = { 'date': date,  'title': title, 'token': token };
    
        fetch("deleteEvent_ajax.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(console.log(data))
            .then(response => response.json())
            .then(data => document.getElementById("holder5").innerHTML = (data.success ? "Deletion successful!" : `Deletion failed ${data.message}`));
    
    }
    
    document.getElementById("delete_events").addEventListener("click", deleteEventAjax, false); // Bind the AJAX call to button click
    
    document.getElementById("delete_events").addEventListener("click", updateCalendar(), false); // Bind the AJAX call to button click
    
    
    
    function editEventAjax(event) {
        const id = document.getElementById("old_id").value;  
        const date = document.getElementById("new_date").value; // Get the username from the form
        const time = document.getElementById("new_time").value; // Get the password from the form
        const title = document.getElementById("new_title").value; 
        const content = document.getElementById("new_content").value;
        const token = document.getElementById("token").value;
        // Make a URL-encoded string for passing POST data:
        const data = { 'id': id,'date': date, 'time': time, 'title': title, 'content': content, 'token': token };
    
        fetch("editEvent_ajax.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => document.getElementById("holder4").innerHTML = (data.success ? "Edition successful!" : `Edition failed ${data.message}`))
            .then(updateCalendar());
    
    
    
    }

    document.getElementById("edit_events").addEventListener("click", editEventAjax, false); // Bind the AJAX call to button click
    
    document.getElementById("edit_events").addEventListener("click", updateCalendar(), false); // Bind the AJAX call to button click


    function editEventAjax(event) {
        const id = document.getElementById("your_event_id").value;  
        const date = document.getElementById("other_id").value; // Get the username from the form
        const token = document.getElementById("token").value;
        // Make a URL-encoded string for passing POST data:
        const data = { 'id': id,'date': date, 'time': time, 'title': title, 'content': content, 'token': token };
    
        fetch("editEvent_ajax.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => document.getElementById("holder4").innerHTML = (data.success ? "Edition successful!" : `Edition failed ${data.message}`))
            .then(updateCalendar());
    
    
    
    }

    document.getElementById("edit_events").addEventListener("click", editEventAjax, false); // Bind the AJAX call to button click
    
    document.getElementById("edit_events").addEventListener("click", updateCalendar(), false); // Bind the AJAX call to button click




