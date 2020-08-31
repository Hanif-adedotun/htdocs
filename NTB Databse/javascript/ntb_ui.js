// Javascript for NTB_UI 


// 'Use strict';
window.onload = showTime(),  retreive_checkbox('myonoffswitch'), change('myonoffswitch'), footer_text();

// var new_switch = document.getElementById('myonoffswitch');

// new_switch.addEventListener('change', function(){
//     console.log('The new switch is '+new_switch.checked);
// });

function showTime() {
    var currentDate = new Date();
    var currentHour = currentDate.getHours();
    var currentMinute = currentDate.getMinutes();
    var meridian;


    if (currentHour >= 12 && currentHour < 24) {//if its betweeen 12pm and 12am, the meridian changes
        currentHour = currentHour - 12;
        if (currentHour == 0) {//if it is noon the hour changes to 12pm
            currentHour = '12';
        }
        meridian = 'pm';
    } else {
        meridian = 'am';
    }

    //console.log(currentMinute);

    if (currentMinute < 10) { //if the seconds is less than 10, it adds 0 at the begining of the minute value
        currentMinute = '0' + currentMinute;//addition of 0, check for error later 

    }
    var Totaltime = currentHour + ' : ' + currentMinute + ' ' + meridian;
    toString(Totaltime);

    document.getElementById('showtime').innerHTML = '<b>' + Totaltime + '</b>';

    setTimeout(function () {
        showTime();
    }, 15000); //update after every 15 seconds

}

// Check the correct way to use an addEventListener
var time_label = document.getElementById('showtime');
time_label.addEventListener('mouseout',  function(){
    say_hi();
}, false);

function say_hi(){
    var currentDate = new Date();
    var currentHour = currentDate.getHours();

    if (currentHour < 12 && currentHour > 0) {
        time_label.innerText = 'Good Morning!';
    } 
    else if(currentHour >= 12 && currentHour < 17){
        time_label.innerText = 'Good Afternoon!';
    }
    else if(currentHour >= 17){
        time_label.innerText = 'Good Evening!';
    }
    else {
        time_label.innerText = 'Hello today!';
    }

    setTimeout(function () {
        showTime();
    }, 3000); 
}


//check if the show directive table is checked

function getTable() { //sends request to the database and waits for response
        downloadHTML('../NTB Databse/database.php?document=table1', function (result) { //Directive Table
            var result_element;
            if (document.getElementById('directive_table')){
                result_element = document.getElementById('directive_table');
                result_element.innerHTML = result; //render result to html

            }else{
                result_element = document.createElement('div');
                result_element.id = 'directive_table';
                result_element.innerHTML = result; //render result to html

                //var res =  document.querySelector('body');//parent element to add  element   
                var add_dir = document.querySelector('#add_directive');//gets the add_directive div
                add_dir.before(result_element);//insert new node before the add_directive div
            }
           

        });
}

//Event Listener to check if the checkbox has been changed
var directive_checkbox = document.getElementById('myonoffswitch');
// console.log(directive_checkbox.checked);
directive_checkbox.addEventListener('change', function(){
    change(this.id);
    save_checkbox(this.id);
});

function change(id){//check if the checkbox has betweeen
var checked_status = document.getElementById(id).checked;

//console.log(checked_status);

if (checked_status === true){
    
    getTable();//call the function to show the table 
    console.log('Showing directive table');

}else if(checked_status === false){
    console.log('clear the page');
  
    var table_div = document.querySelector('#directive_table');
    if(table_div){//if it exists in the DOM tree 
        table_div.remove();
    }
}
}

function save_checkbox(id){//save the value to localStorage

var checkbox_status = document.getElementById(id).checked;
if(window.localStorage){
    window.localStorage.clear('checked_status');
    window.localStorage.setItem('checked_status', checkbox_status);
    console.log('Checkbox has been set to '+ checkbox_status);
}
}

function retreive_checkbox(id){//retrieve the saved value
    if(window.localStorage){
        var checked_value = window.localStorage.getItem('checked_status');
        //console.log(checked_value);
        var set_item = document.getElementById(id);
        

        if (checked_value == null){
            set_item.checked = true;
            console.log('The checkbox is '+set_item.checked+ ' by default');
            

        }else{
            var bool_checked;
            bool_checked = parseBoolean(checked_value);//converts it too boolean using the function 
                 
            console.log('The checkbox is '+ bool_checked);
            set_item.checked = bool_checked;//set the checkbox to the value

          // change(id);
        }
    }
}




//jquery functions
$(document).ready(function() {
    animate_objects();
});

function animate_objects() {
    // $('h1').hide() //hide h1 first then show it 
    // .fadeIn('slow')//make the h1 fade in 
    // .fadeTo('slow',0.5)
    $('h1')
    .slideUp('slow')
    .slideDown('slow')
    .css('opacity', '70%');

    setTimeout(function () {
        $('h1').css('opacity', '100%');
    }, 3000); 
}


//convert to boolean function
function parseBoolean(string) {
    switch (String(string).toLowerCase()) {
        case "true":
        case "1":
        case "yes":
        case "y":
            return true;
        case "false":
        case "0":
        case "no":
        case "n":
            return false;
        default:
            return undefined;
    }
}

function footer_text(){
// Display the footer text with current year
var text_element = document.getElementById('foot_text_id');
var current_year = new Date().getFullYear();
console.log(current_year);
text_element.innerHTML = '&copy;' + ' Voltex Designs ' + current_year;
}


var add_button = document.getElementById('add-to-database');
add_button.addEventListener('click', function () {
    console.log('');
});//open_add();


function open_add() {
alertDOM('error', 'input-directive-textbox');
var form_class = document.querySelector('.add-to-database-form');
form_class.style.display = '';
// tableID.classList.remove('hidden');
}