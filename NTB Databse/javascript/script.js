/*
NTB Database js file, that connects to Ajax library;
javascript/AjaxLibrary/downloadHTML.js

Hanif Adedotun 2020
*/


// This loads all the functions after the DOM loads
window.onload = getTable(), showTime();


//Module to show current time //check for error in the Totaltime;
function showTime(){
    var currentDate = new Date();
    var currentHour = currentDate.getHours();
    var currentMinute  = currentDate.getMinutes();
    var meridian;
    
    
    if (currentHour >= 12 && currentHour < 24){
        currentHour = currentHour - 12;
        if (currentHour == '0'){
            currentHour = 12;
        }
        meridian = 'pm';
    }else{
        meridian = 'am';
    }
    
    //console.log(currentMinute);
    
    if(currentMinute < 10){//if the seconds is less than 10
        currentMinute = '0' + currentDate.getMinutes();
        
    }
    var Totaltime = currentHour + ':' + currentMinute + ' ' + meridian;
    toString(Totaltime);
    
    console.log(Totaltime);
    document.querySelector('#showtime').innerHTML = '<b>' + Totaltime + '</b>';
    
    setTimeout(function(){showTime()}, 15000);//update after every 15 seconds
    
}



//Module 1
//Display All the tables by requesting from MySQL using PHP server

function getTable(){ //sends request to the database and waits for response
    for (let index = 1; index < 5; index++) {
        downloadHTML('../NTB Databse/database.php?document=table'+index, function(result){//Directive Table
            var table = document.getElementById('tableResult'+index);
            table.innerHTML = result; //render result to html
            
        });
        
    }
   
}



//Module 2
/*
function to edit the table, and validate it on the client side, 
and the server side.

var Table = document.getElementsByTagName("Table");
Table.focusout = editTable();

*/


//Module 3
//Function to add a new record to the database


//check error here
function addRecord(tableID, divTable, buttonID){

divTable.classList.add('addoverflow');//Add srollbar to new table

tableID.style.display = '';
tableID.classList.remove('hidden');//show table

//addLocation.innerHTML = addLocation; //add a row to it
console.log('Opened table fields.');

document.getElementById(buttonID).disabled = true;//disable the button after press
}





//Validating each input against the main validator
var tester;
function alertDOM(error, inputClassName){
    var input =  document.getElementsByClassName(inputClassName);
    
    
Array.from(input).forEach(function(element, index, array){
     tester = false;

     console.log(element.type);
     console.log(element.name);
    //console.log(element.className);
    console.log(element.value.length);
    
      

if (!(element.value == '')){ //check if an input is not empty
   if (element.type == 'text'){ //if input is a text
        if(element.value.length < '120'){
        tester = true;
        error.innerHTML = '';
        
      }
      else{
          tester = false;
          error.innerHTML = '<b>Enter a valid text</b>';
      }
   }
   else if (element.type == 'number'){//if input is a number
     if (element.name ==' keyNumber' && element.value.length < '9'){
        tester = true;
        error.innerHTML = '';
     }
     else if (element.name == "meetingNumber" && element.value.length < '6'){
        tester = true;
        error.innerHTML = '';
   }
     else if (element.value.length < '9'){
        tester = true;
        error.innerHTML = '';
     }else{
         tester = false;
         error.innerHTML = '<b>Enter a valid number</b>';
      }

   }
   else if (element.type == 'date'){//if input is a date
       toString(element.value);
       console.log(element.value);
    if (element.value.length < '11'){
        tester = true;
        error.innerHTML = '';
    }else{
        tester = false;
        error.innerHTML = '<b>Enter a valid date</b>';
        
      }
   }
}else{
    tester = false;//fallback if none of the inputs have values
}
return tester;
});
}


//Upload data values to the server
function uploadValues(formElem, spanresult){
    if (tester == true){
    console.log('Talking to the server...');
    //var formElem = document.getElementById('sendForm');
    var dataF = new FormData(formElem); //create a form array list to send to the server

    downloadHTMLPost('../NTB Databse/uploadData.php', dataF, function(result){
        //var span = document.getElementById('NewTableresult');//if an error occur from the database
        spanresult.innerHTML = result;

    
    if (spanresult.contains(document.getElementById('successful'))){
        alert('Successfully added to database!');
        location.reload();
    }
    
    });
}else{
    spanresult.innerHTML = '<b id="error">One or more fields are without values. Input values!</b>';
}


}

//Module 3
//Function to Delete a field from the table (directive)


function delTable(value, databasename){
    var con = confirm("Are you sure you want to delete this field?");
    if (con == true){
         downloadHTML('../NTB Databse/database.php?document=delete&database='+ databasename +'&deletekey='+ value + '', function(result){
            var span = document.getElementById('NewTableresult');
            span.innerHTML = result;
         });
   
        console.log('You deleted ' + value);
        
 if (span.contains(document.getElementById('successful'))){
         alert('successfully Deleted Row!');
         location.reload();
        }
    

    } else{
        alert("Okay"); 
    }
}
