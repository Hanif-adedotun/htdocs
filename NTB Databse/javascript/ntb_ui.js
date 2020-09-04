// Javascript for NTB_UI 


//jquery functions
$(document).ready(function() {
    animate_objects();
});

function animate_objects() {
    // $('h1').hide() //hide h1 first then show it 
    // .fadeIn('slow')//make the h1 fade in 
    // .fadeTo('slow',0.5)
    $('h1')
    // .slideUp('slow')
    // .slideDown('slow')
    .hide()
    .fadeIn('slow');//make the h1 fade in 

}


//This function is to show the time, and it updates itself after every 15 seconds 
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


var time_label = document.getElementById('showtime');
time_label.onmouseout = function (){
    say_hi();//Greeting message depending on the time of the day
};

function say_hi(){//Greeting message depending on the time of the day
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
        showTime();//calls the show time function after 3 seconds
    }, 3000); 
}


//An object that stores and connect to the database has its properties
//This object is a database connect object, it values only connects to database
var getDBResults = { 
    getSBUresult: function (){
        downloadHTML('../NTB Databse/database.php?document=SBUoptions', function (result) { //Directive Table
            var table = document.getElementById('sbuOptions');
            table.innerHTML = result; //render result to html
        });
    },
    getDirectiveTable: function(){
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
            var add_dir = document.querySelector('#open-modal');//gets the add_directive div
            add_dir.before(result_element);//insert new node before the add_directive div
        }
       
    });
}
};

//This function converts a string to boolean function
//@param (string) is the value to change to a boolean value 
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

// Event Listener to check if the checkbox has been changed
// When the value of the checkbox is changed it calls two function
// @function change(this.id) is to either show or remove the table
//@function save_checkbox(this.is) is to save the value to the localStorage
var directive_checkbox = document.getElementById('myonoffswitch');
directive_checkbox.onchange = function () {
    change(this.id);//shows the table is checkbox is true
    save_checkbox(this.id);//Saves the value to the localStorage
};

//This function is to either show or remove the table depending on the value of the checkbox
//@param (id) is the id value of the checkbox
//It uses 'object.hasOwnProperty()' to check if the property is part of the particular object
function change(id){

var checked_status = document.getElementById(id).checked;

    if (checked_status === true){   

        if(getDBResults.hasOwnProperty('getDirectiveTable')){
            getDBResults.getDirectiveTable();//call the function to show the table 
            console.log('Showing directive table');
        } 
        
        

    }else if(checked_status === false){
        var table_div = document.querySelector('#directive_table');
        
        if(table_div){//if it exists in the DOM tree, remove it 
            table_div.remove();
        }
    }
}

//This function is to save the value of the textbox to local storage
//@param (id) is the id value of the checkbox
function save_checkbox(id){

var checkbox_status = document.getElementById(id).checked;

    if(window.localStorage){//if localStorage exists
        window.localStorage.clear('checked_status');
        window.localStorage.setItem('checked_status', checkbox_status);
        console.log('Checkbox has been set to '+ checkbox_status);
    }
}


//This function receives the value of the checkbox from the 
//local storage, set it to true if there is no value
//@params (id) is the id of the checkbox it receives
//Uses parseBoolean() function to convert the text to boolean
function retreive_checkbox(id){
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
            
            if(bool_checked !== undefined){//makes sure that the function return value is not undefined
                console.log('The checkbox is '+ bool_checked);
                set_item.checked = bool_checked;//set the checkbox to the value
            }else{
                console.error('Value of checkbox is undefined');
            }
        
        }
    }
}


//This function replaces the generic footer text with date added to new one
function footer_text(){
// Display the footer text with current year
var text_element = document.getElementById('foot_text_id');
var current_year = new Date().getFullYear();
text_element.innerHTML = '&copy;' + ' Voltex Designs ' + current_year;
}


// Modal functions
//Controls all the functions to open and close the modal
//It uses 'object.hasOwnProperty()' to check if the property is part of the particular object
function modalFunc(){
    var modal = document.getElementById('addModal');


    //Button to open modal
    var modalbtn = document.getElementById('open-modal');

    //When you click modal Button
    modalbtn.onclick = function(){
        modal.style.display = 'block';

        if (getDBResults.hasOwnProperty('getSBUresult')){
            getDBResults.getSBUresult();//use the object to connect to the SBU table
        }
        
    };
    
    // Span close
    var span = document.getElementsByClassName('close')[0];
    

    // When you click close
    span.onclick = function(){
        AskBeforeExit(modal);//Confirms you want to exit Modal
    };
    

    //if you click outside of the modal
    window.onclick = function(event){
        if(event.target == modal){
            AskBeforeExit(modal);//Confirms you want to exit Modal
        }
    };
}

//This function confirms if the use wants to exit the Modal
//@param (modal) is the variable pointing to the Modal element
//Returns the display value at the instance
function AskBeforeExit(modal) {
    var question = confirm('Are you sure you want to exit? You might loose the your values!');
    if (question == true){
        modal.style.display = 'none';
    }
    return  modal.style.display;
}


// Still in test phase functions

//Center the switch Button
function centerSwitch(){
//This function is to center align the switch Button
var switch_button = document.getElementsByClassName('onoffswitch')[0];
console.log(switch_button.style.width);
console.log(Number(switch_button.style.width));
var window_width = window.screen.width;
}

//This function returns the ID and/or Class name, use in Validating input
function returnId(elem){
var idName = elem.id;
var classname = elem.className;
return idName;
}

//End of test Phase functions

window.onload = showTime(),  retreive_checkbox('myonoffswitch'), change('myonoffswitch'), modalFunc(), footer_text();
//This onload is at the buttom because it uses varaiables that are in the middle of the code