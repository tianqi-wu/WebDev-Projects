<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <title>Andy's Ajax Calendar Ver 1.0.0</title>
        <link rel="stylesheet" type="text/css" href="csstemp.css" />
        <!--Import content from CSE330 as free software, and jQuery as one part-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
        <script src="https://classes.engineering.wustl.edu/cse330/content/calendar.js" type="text/javascript"></script> 
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet'>
        <script src="ajax.js"></script>
    </head>
    <body>
        <h1>Andy's Calendar Ver 1.0.0</h1>
        <!--Testing materials---Remove this after OK-->
        <div id = "holder"></div>
        <p id ='holder2'><strong>
         <?php ini_set("session.cookie_httponly", 1); session_start();
          if(!isset($_SESSION['username']))
          {echo"You are not logged in.";
          }else{
            $entry = "Hello, ". $_SESSION['username']. ". Your UID is ". $_SESSION['user_id'];
            echo $entry;
            } ?>
            </strong></p>
        <input type="text" id="username" placeholder="Username" />
        <input type="password" id="password" placeholder="Password" />
        <button id="login_btn" class = "button0">Log In</button>
        <button id="register_btn" class = "button0">Register</button>
        <button id="logout" class = "button0">Logout</button>



<div id = "holder1"></div>

        <!--May add ajax sessions here to help login.-->
        <br> 
        <button class = "button1" id = "prev_month">last month</button>
        <button class = "button1" id = "next_month">next month</button>
        <div id="table"></div>




<!--We should use JQuery here.-->

<script type = "text/javascript">

var  newDays= ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
var newMonths = ["January","February","March","April","May","June","July","August","September", "October", "November", "December"];



var currentDate = new Date();
// For our purposes, we can keep the current month in a variable in the global scope
currentMonth = new Month(currentDate.getFullYear(),currentDate.getMonth()); //Depend on time and date

updateCalendar();



// Change the month when the "next" button is pressed
document.getElementById("next_month").addEventListener("click", function(event){
	currentMonth = currentMonth.nextMonth(); // Previous month would be currentMonth.prevMonth()
	updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
}, false);


// Change the month when the "prev" button is pressed
document.getElementById("prev_month").addEventListener("click", function(event){
	currentMonth = currentMonth.prevMonth(); // Previous month would be currentMonth.prevMonth()
	updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
}, false);

//Set all days here

// This updateCalendar() function only alerts the dates in the currently specified month.  You need to write
// it to modify the DOM (optionally using jQuery) to display the days and weeks in the current month.
function updateCalendar(){
  var weeks = currentMonth.getWeeks();
  //Assigning to InnerHTML here.
  document.getElementById("holder1").innerHTML = newMonths[currentMonth.month]+" "+currentMonth.year;
  
  //Clear the older version
  document.getElementById("table").innerHTML = "";


  /* The logic here is to create a table with Javascript.
    We may have to add a table together.
    The element is called "table" then, and then use "createElement" and "getElementById".
    Key: Appending( append() ) and creating elements.
  */
var tableHolder = document.getElementById("table");

//Reference:
var tbl = document.createElement("table");
var tbody = document.createElement("tbody");

///////

var tr = document.createElement("tr");
for(var d = 0; d < 7; d++){
var cell = document.createElement("th");
      var cellText = document.createTextNode(newDays[d]);
      cell.append(cellText);
      tr.append(cell);

}
    tbody.appendChild(tr);



///////
for(var w in weeks){
  var tr = document.createElement("tr");
		var days = weeks[w].getDates();
		// days contains normal JavaScript Date objects.
		//alert("Week starting on "+days[0]);
		
		for(var d in days){
      if(w==0&&days[d].getDate()>=20||w>1&&days[d].getDate()<=8){
        var cell = document.createElement("td");
      /*We would need minor tweaks here.*/
      var cellText = " "
      cell.append(cellText);
      tr.append(cell);
    }else{

// You can see console.log() output in your JavaScript debugging tool, like Firebug,
// WebWit Inspector, or Dragonfly.
var cell = document.createElement("td");
/*We would need minor tweaks here.*/
//      var cellText = document.createTextNode("cell in row "+ row +", column "+column);
//console.log(days[d].toISOString());
var cellText =document.createTextNode("\n"+ days[d].getDate()+"\n\r ");

//cellText.bold();
var cell_contents = document.createElement("LI");    
var event_date = days[d].getDate();

//string realDate
var realDate = days[d].getFullYear()+'-'+((days[d].getMonth()<9)? ('0'+(days[d].getMonth()+1)):(days[d].getMonth()+1))+'-'+((days[d].getDate()<10)? ('0'+days[d].getDate()):(days[d].getDate()));

//var cell_contents = 
updateAjax(realDate);

cell_contents.setAttribute("id", realDate);

//var cell_contents = updateAjax(realDate);




console.log(cellText);



        //We should have more cell texts here no matter what.
      //console.log(days[d].toISOString());
      cell.append(cellText);
      cell.append(cell_contents);
      //cell.append(cellText);
      //cell.append();
      tr.append(cell);
    }
    }
    tbody.appendChild(tr);
	}
  tbl.appendChild(tbody);
  tableHolder.appendChild(tbl);  
  //end of reference
  tbl.setAttribute("border", "1");

/* End of pure implementation of calendar sketch*/
                


}

//141     141    141     141 
function updateAjax(realDate){
  const data = { 'date': realDate };

    fetch("update_ajax.php", {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'content-type': 'application/json' }
        })
        .then(console.log(data))
        .then(response => response.json())
 .then(data=>document.getElementById(realDate).innerHTML = ("\n"+data.value) ); 
}





/*From CSE 330; code 
/* * * * * * * * * * * * * * * * * * * *\
 *               Module 4              *
 *      Calendar Helper Functions      *
 *                                     *
 *        by Shane Carr '15 (TA)       *
 *  Washington University in St. Louis *
 *    Department of Computer Science   *
 *               CSE 330S              *
 *                                     *
 *      Last Update: October 2017      *
\* * * * * * * * * * * * * * * * * * * */

/*  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

(function () {
	"use strict";

	/* Date.prototype.deltaDays(n)
	 * 
	 * Returns a Date object n days in the future.
	 */
	Date.prototype.deltaDays = function (n) {
		// relies on the Date object to automatically wrap between months for us
		return new Date(this.getFullYear(), this.getMonth(), this.getDate() + n);
	};

	/* Date.prototype.getSunday()
	 * 
	 * Returns the Sunday nearest in the past to this date (inclusive)
	 */
	Date.prototype.getSunday = function () {
		return this.deltaDays(-1 * this.getDay());
	};
}());

/** Week
 * 
 * Represents a week.
 * 
 * Functions (Methods):
 *	.nextWeek() returns a Week object sequentially in the future
 *	.prevWeek() returns a Week object sequentially in the past
 *	.contains(date) returns true if this week's sunday is the same
 *		as date's sunday; false otherwise
 *	.getDates() returns an Array containing 7 Date objects, each representing
 *		one of the seven days in this month
 */
function Week(initial_d) {
	"use strict";

	this.sunday = initial_d.getSunday();
		
	
	this.nextWeek = function () {
		return new Week(this.sunday.deltaDays(7));
	};
	
	this.prevWeek = function () {
		return new Week(this.sunday.deltaDays(-7));
	};
	
	this.contains = function (d) {
		return (this.sunday.valueOf() === d.getSunday().valueOf());
	};
	
	this.getDates = function () {
		var dates = [];
		for(var i=0; i < 7; i++){
			dates.push(this.sunday.deltaDays(i));
		}
		return dates;
	};
}

/** Month
 * 
 * Represents a month.
 * 
 * Properties:
 *	.year == the year associated with the month
 *	.month == the month number (January = 0)
 * 
 * Functions (Methods):
 *	.nextMonth() returns a Month object sequentially in the future
 *	.prevMonth() returns a Month object sequentially in the past
 *	.getDateObject(d) returns a Date object representing the date
 *		d in the month
 *	.getWeeks() returns an Array containing all weeks spanned by the
 *		month; the weeks are represented as Week objects
 */
function Month(year, month) {
	"use strict";
	
	this.year = year;
	this.month = month;
	
	this.nextMonth = function () {
		return new Month( year + Math.floor((month+1)/12), (month+1) % 12);
	};
	
	this.prevMonth = function () {
		return new Month( year + Math.floor((month-1)/12), (month+11) % 12);
	};
	
	this.getDateObject = function(d) {
		return new Date(this.year, this.month, d);
	};
	
	this.getWeeks = function () {
		var firstDay = this.getDateObject(1);
		var lastDay = this.nextMonth().getDateObject(0);
		
		var weeks = [];
		var currweek = new Week(firstDay);
		weeks.push(currweek);
		while(!currweek.contains(lastDay)){
			currweek = currweek.nextWeek();
			weeks.push(currweek);
		}
		
		return weeks;
	};
}



/*To CSE 330; code 
/* * * * * * * * * * * * * * * * * * * *\
 *               Module 4              *
 *      Calendar Helper Functions      *
 *                                     *
 *        by Shane Carr '15 (TA)       *
 *  Washington University in St. Louis *
 *    Department of Computer Science   *
 *               CSE 330S              *
 *                                     *
 *      Last Update: October 2017      *
\* * * * * * * * * * * * * * * * * * * */




//////////



            if (!jQuery) {  
    document.getElementById("holder").innerHTML =  "jQuery is not loaded. Please contact the Webmaster."; 
} 


                
                </script>


<!--event: date, time, title, content,group-->
<!--只需要这7个（大概）-->
<!--Tweaks?-->
<!--The date format in the date field of my PHPMyAdmin is YYYY/MM/DD.-->

    <h3>You can create new events here:</h3>
    <div id = "holder3">Please enter new events.</div>


    <input type="date" id="date" placeholder="date" />
    <input type="time" id="time" placeholder="Password" />
    <input type="text" id="title" placeholder="title" />
    <input type="text" id="content" placeholder="content" />
    <input type="number" id="group" placeholder="group" />
    <input type="hidden" name="token" id = "token" value="" />
    <button id="create_events" class = "button0">Create new events</button>
     <script>
       Update calendar
      document.getElementById("create_events").addEventListener("click", function(){
        setTimeout(updateCalendar()
        ,4540);}, false);
     
     
     </script>


<h3>You can Edit the event here:</h3>
<div id = "holder4">Please enter what you want to edit.</div>
<input type="number" id="old_id" placeholder="id" />
<input type="date" id="new_date" placeholder="date" />
<input type="time" id="new_time" placeholder="time" />
<input type="text" id="new_title" placeholder="title" />
<input type="text" id="new_content" placeholder="content" />
<input type="hidden" name="token2" id="token" value="">
<button id="edit_events" class="button0">Edit this event</button>

<script>
       //Update calendar
      document.getElementById("edit_events").addEventListener("click", function(){
       setTimeout(updateCalendar()
        ,6640);}, false);
     
     
     </script>







<!--Delete the Event here.-->

<h3>You can Delete the event here:</h3>
<div id="holder5">Please enter its date and title.</div>
<input type="number" id="old_id" placeholder="id" />
<input type="text" id="title1" placeholder="title">
<input type="hidden" name="token1" id="token" value="">
    <button id="delete_events" class="button0">Delete this event</button>

    <script>
       //Update calendar
      document.getElementById("delete_events").addEventListener("click", function(){
       setTimeout(updateCalendar()
        ,6640);}, false);
     
     
     </script>


<h3>You can also share events here:</h3>
<div id="holder6">Please enter its date and title.</div>
<input type="number" id="your_event_id" placeholder="your id" />
<input type="number" id="other_id" placeholder="other's id" />
<input type="hidden" name="token1" id="token" value="">
    <button id="share_events" class="button0">Share this event</button>

    <script>
       //Update calendar
      document.getElementById("share_events").addEventListener("click", function(){
       setTimeout(updateCalendar()
        ,4540);}, false);
     
     
     </script>


    <script type="text/javascript" src="ajax.js"></script>
                <!--Foot-->
                <footer>
                    Made by 2019 Andy Wu.
                </footer>
                
    </body>
</html>