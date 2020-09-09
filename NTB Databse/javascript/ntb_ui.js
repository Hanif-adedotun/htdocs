// Javascript for NTB_UI 


//Object to hold all Id and Class names
var AllIdNames = {
    time_id : 'showtime',//Id for time used by animate_objects();
    db_name_id: 'directive table',//id for h2 which contains db name

    input_SBUoptions_id: 'sbuOptions', //Id for input in Modal used by getDBResults.getSBUresult();
    directiveTable_id: 'directive_table', //directive table div id used in getDBResults.getDirectiveTable();

    switch_id: 'myonoffswitch',//On and Off switch id

    Modal_id: 'addModal',
    OpenModal_id: 'open-modal', //open Modal;
    
    form_id: 'add-to-database-form',
    submit_id: 'submit',
    form_error_id: 'formError',//form error

    footer_text_id: 'foot_text_id',//Footer text id


};

var AllClassNames = {
    close_className : 'close',
    input_values_className: 'input-directive',//Input elements values 
    delete_className: 'delete',//All the delete buttons 
};

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
    String(Totaltime); //Converts the time to a String

    document.getElementById(AllIdNames.time_id).innerHTML = '<b>' + Totaltime + '</b>';

    setTimeout(function () {
        showTime();
    }, 15000); //update after every 15 seconds

}


var time_label = document.getElementById(AllIdNames.time_id);
time_label.onmouseout = function (){
    say_hi(time_label);//Greeting message depending on the time of the day
};

//Greeting message displayed depending on the time of the day
function say_hi(time_label){
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


//A Class that stores and connect to the database has its properties
//This classs is a database connect class, it values only connects to database, and render the results
class Connect_Database { 
    getSBUresult(table) {
        downloadHTML('../NTB Databse/database.php?document=SBUoptions', function (result) { //Directive Table
            table.innerHTML = result; //render result to html
        });
    }


    getDirectiveTable(result_element, next_sibling) {
        downloadHTML('../NTB Databse/database.php?document=table1', function (result) { //Directive Table
        
        if (result_element){//directive table id in (AllIdNames) object
            result_element.innerHTML = result; //render result to html

        }else{
            result_element = document.createElement('div');
            result_element.id = AllIdNames.directiveTable_id;//directive table id in (AllIdNames) object
            result_element.innerHTML = result; //render result to html

            next_sibling.before(result_element);//insert new node before the add_directive div
        }

        if(document.getElementById(AllIdNames.directiveTable_id)){//if the element exists only
            activate_delete();//Activate the delete function only when the table is showing       
        }
       
        });

    
    }

    //Uploads the data to the database
    //@params (dataF) is the form data from all the inputs
    //@params (form) is the form
    UploadDirectiveTable(dataF, form){

        downloadHTMLPost('../NTB Databse/uploadData.php', dataF, function (result) {
 
            if (result.includes('Added')){
                alert(result);//Displays the result in an alert form
                location.reload();
           }else{
               //if an error occur from the database or any reply from the database

                var error_span = document.getElementById(AllIdNames.form_error_id);

                if (error_span){
                    error_span.innerHTML = result;
                }else{

                    error_span = document.createElement('p');//create element for error
                    error_span.id = AllIdNames.form_error_id;//creates and id from our id object
                    error_span.classList.add('derror');//adds the error class
                    span_error.innerHTML = result;//append console.error(); from database
                    var span_error = form.after(error_span);//parent element to add error element
                    
                }
            
           }
          
        });
    }

    //Delete from database
    //Function to delete a value from the specific database
    //@param (value) is the id of the particular row of the table
    //@param (databasename) is the particular database that the button is in
    delTable(value, databasename) {

        console.log('Deleting value...');

        downloadHTML('../NTB Databse/database.php?document=delete&database=' + databasename + '&deletekey=' + value + '', function (result) {
            
            if(result.includes('Succesfully Deleted!')){
                alert(result);
               location.reload();
            }else{
                var error_span = document.getElementById('delete_error');
                 if (error_span){//if error exist before
                     error_span.innerHTML = result;
                 }else{
                    error_span = document.createElement('p');//create element for error
                    error_span.id = 'delete_error';
                    error_span.classList.add('derror');//adds the error class
                    var span_error =  document.getElementById(AllIdNames.directiveTable_id).after(error_span);//parent element to add error element
                    span_error.append(result);//append result from database
                 }
            }
            
        });

    }
}

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
var directive_checkbox = document.getElementById(AllIdNames.switch_id);
directive_checkbox.onchange = function () {
    change(this.id);//shows the table is checkbox is true
    save_checkbox(this.id);//Saves the value to the localStorage
};

//This function is to either show or remove the table depending on the value of the checkbox
//@param (id) is the id value of the checkbox
//activate_delete() function is used to activate the delete fuction
//It uses 'object.hasOwnProperty()' to check if the property is part of the particular object
function change(id){

var checked_status = document.getElementById(id).checked;
var table_div = document.getElementById(AllIdNames.directiveTable_id);

    if (checked_status === true){   

        // Calls the Connect_Database class, and gets the SBU results
        //Gives the classs an element to render the values onto 
        var result_placeholder = document.getElementById(AllIdNames.directiveTable_id);//gets the element to write it to
        var next_sibling = document.getElementById(AllIdNames.OpenModal_id);//gets the next sibling
       
        var Database = new Connect_Database();//Calls the class to connect to the database
        Database.getDirectiveTable(result_placeholder, next_sibling);//call the function to show the table 
            
       
        console.log('Showing directive table');

    }else{       
        
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




// Modal functions
//Controls all the functions to open and close the modal
//It uses 'object.hasOwnProperty()' to check if the property is part of the particular object
var tester;//tester variable used in validate_input(element);
function modalFunc(){
    var modal = document.getElementById(AllIdNames.Modal_id);//Modal id 


    //Button to open modal
    var modalbtn = document.getElementById(AllIdNames.OpenModal_id);

    //When you click modal Button
    modalbtn.onclick = function(){
        modal.style.display = 'block';

        // Calls the Connect_Database class, and gets the SBU results
        //Gives the classs a select element to render the values onto 
        var Database = new Connect_Database();
        var result_placeholder = document.getElementById(AllIdNames.input_SBUoptions_id);//gets the id from object (AllIdNames)
        Database.getSBUresult(result_placeholder);   //use the object to connect to the SBU table, returns the result
        
        check_inputs();//activate check inputs function, to start seeing values
    };
    
    // Span close
    var span = document.getElementsByClassName(AllClassNames.close_className)[0];
    

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

//Validating each input against the main validator
// var input_values = document.getElementsByClassName(AllClassNames.input_values_className);
// input_values.onfocus = function () {
//     console.log('hello');
// };

//Function to check inputs and call the validate function 
//Start seeing and communicating to the validate function 
function check_inputs(){

var input_elements = document.getElementsByClassName(AllClassNames.input_values_className);//Get inputs from the form
//console.log(input_elements);
    Array.from(input_elements).forEach(function (element) {
        //event.preventDefault();//prevent default

        tester = false;

        var error = document.createElement('p');//creates error elemen to be appended to the input
        error.className = 'span_error';
        element.after(error);

        if(element.type == 'date' || element.type == 'select-one'){
           
            element.onblur = function(){//When the input looses focus
                console.log(element.id);
                validate_input(element, error);
            };
        }else{
            element.onkeyup = function () {//When the user types into input 
                console.log(element.id);
                validate_input(element, error);
            };
        }
    });
}

//Function to validate each input as they are clicked

function validate_input(element, error){
   
    if (element.type == 'text') { //if input is a text
        if (element.value.length < 50) {
            tester = true;

            element.classList.remove('input_error');
            element.classList.add('input_good');
            
            error.innerHTML = '';
            console.log(element.value+' is okay.');

        } else {
            tester = false;
            element.classList.remove('input_good');
            element.classList.add('input_error');
            error.innerHTML = '<b>Text is too long</b>';
        }
    } else if (element.type == 'number') { //if input is a number
         if (element.value.length < 10) {
            tester = true;

            element.classList.remove('input_error');
            element.classList.add('input_good');

            error.innerHTML = '';            
            console.log(element.value+' is okay.');
        } else {
            tester = false;
            element.classList.remove('input_good');
            element.classList.add('input_error');
            error.innerHTML = '<b>Number is too long</b>';
        }

    } else if (element.type == 'date') { //if input is a date
        toString(element.value);
        console.log(element.value);

        if (element.value.length < 11) {
            tester = true;

            element.classList.remove('input_error');
            element.classList.add('input_good');
            
            error.innerHTML = '';
            console.log(element.value+' is okay.');
        } else {
            tester = false;
            element.classList.remove('input_good');
            element.classList.add('input_error');
            error.innerHTML = '<b>Enter a valid date</b>';

        }
    }else if(element.type == 'select-one'){
        if (element.value != '') {
            tester = true;
            
            element.classList.remove('input_error');
            element.classList.add('input_good');

            error.innerHTML = '';
            console.log(element.value+' is selected.');
        } else {
            tester = false;
            element.classList.remove('input_good');
            element.classList.add('input_error');
            error.innerHTML = '<b>Enter a valid option</b>';
        }
    }else {
        tester = false;
    }
    return tester;
}

//When the submit button of the form has been clicked
var submit_button = document.getElementById(AllIdNames.submit_id);
submit_button.onclick = function (event){
    event.preventDefault();
    console.log(tester);
    uploadInputs();//Uploads the inputs to the database 
};


//This function uploads the form inputs to the database
function uploadInputs(){
    var form_elem = document.getElementById(AllIdNames.form_id);//Form element
    
    if (tester === true){
        console.log('Talking to the server...');

        var dbname = AllIdNames.db_name_id;//gets the id of the h2 which has the database name
        

        var formData = new FormData(form_elem);//create form data of the form
        formData.append('DatabaseName', dbname);//appends the name of the database and sends it to the validor to check for the database to add to

        var database = new Connect_Database();//Connects to the database, creates a new class
        database.UploadDirectiveTable(formData, form_elem);//Connects to the object //error
    
    }else{

        var error_span = document.createElement('p');//create element for error
        error_span.classList.add('derror');//adds the error class
        error_span.innerHTML = '<b>One or more fields are without values. Input values!</b>';
        form_elem.after(error_span);//append result from database

    }


}

//Button to delete particular row from the database

function activate_delete() {

    var delete_buttons = document.getElementsByClassName(AllClassNames.delete_className);
    // console.log(delete_buttons.length);

    Array.from(delete_buttons).forEach(function (element) {
        //console.log(element);
        element.onclick = function(event){
            event.preventDefault();
            console.log('Delete '+ element.value);
            
            
        var con = confirm("Are you sure you want to delete this field?");
            
            if (con === true) {
                var database_name = AllIdNames.db_name_id;//name of database
                var database = new Connect_Database();
                database.delTable(element.value, database_name);//talk to delete function
                console.log('Deleting...');
            } else {
                alert("Okay");
            }
        };
    });
}




//This function replaces the generic footer text with date added to new one
function footer_text(){
    // Display the footer text with current year
    var text_element = document.getElementById(AllIdNames.footer_text_id);
    var current_year = new Date().getFullYear();
    text_element.innerHTML = '&copy;' + ' Voltex Designs ' + current_year;
}


// Still in test phase functions

//Test tester element

//Center the switch Button
function centerSwitch(){
//This function is to center align the switch Button
var switch_button = document.getElementsByClassName('onoffswitch')[0];
console.log(switch_button.style.width);
console.log(Number(switch_button.style.width));
var window_width = window.screen.width;
}

//End of test Phase functions

document.addEventListener('readystatechange', function(){
    if(document.readyState === 'complete'){
        showTime();  //Show the time at the top of the table
        retreive_checkbox(AllIdNames.switch_id); //set the value of the checkbox from local storage
        change(AllIdNames.switch_id);//show the table if the checkbox is true
        modalFunc(); //Load all the Modal functions
        footer_text(); //Replace the generic footer with a dynamic footer tha changes date according to the current
    }
});
