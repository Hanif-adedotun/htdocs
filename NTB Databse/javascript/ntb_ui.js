// Javascript for NTB_UI 
window.onload = showTime(), retreive_checkbox('myonoffswitch'), change('myonoffswitch');
   
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
        if (currentHour == '0') {//if it is noon the hour changes to 12pm
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

    console.log(Totaltime);
    document.getElementById('showtime').innerHTML = '<b>' + Totaltime + '</b>';

    setTimeout(function () {
        showTime();
    }, 15000); //update after every 15 seconds

}

// Check the correct way to use an addEventListener
var time_label = document.getElementById('showtime');
time_label.addEventListener('click', function(){
    say_hi();
}, false);

function say_hi(){
    time_label.innerText = 'Hello today!';

    setTimeout(function () {
        showTime();
    }, 3000); //update after every 15 seconds
}


//check if the show directive table is checked

function getTable(id) { //sends request to the database and waits for response
        downloadHTML('../NTB Databse/database.php?document=table1', function (result) { //Directive Table
            var result_element;
            if (document.getElementById('directive_table')){
                result_element = document.getElementById('directive_table');
                result_element.innerHTML = result; //render result to html
            }else{
                result_element = document.createElement('div');
                result_element.id = 'directive_table';
                result_element.innerHTML = result; //render result to html
                var res =  document.getElementById('directive_cointainer').appendChild(result_element);//parent element to add error element   
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
    
    getTable(id);//call the function to show the table 
    console.log('Showing directive table');

}else if(checked_status === false){
    console.log('clear the page');

    if(document.querySelector('#directive_cointainer')){
         document.querySelector('#directive_cointainer').innerHTML = '';//makes the directive table disspear 
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
        console.log(checked_value);
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
// if($('#checkbox_directive[@checked=checked]') == true){
//     console.log('good');
// }else{
//     console.log('not good');
//     console.log($('#checkbox_directive[@checked]'));
// }



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
