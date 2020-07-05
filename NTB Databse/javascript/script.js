/*
NTB Database js file, that connects to Ajax library;
javascript/AjaxLibrary/downloadHTML.js

Hanif Adedotun 2020
*/

//Module 1
//Display the main table Directive by requesting from the PHP table
var body = document.getElementsByTagName("body");
body.onload = getTable();

function getTable(){ //sends request to the database and waits for response
    downloadHTML('../NTB Databse/database.php?document=table', function(result){
        var table = document.getElementById('tableResult');
        table.innerHTML = result; //render result to html
    });

}

//Module 2
/*
function to edit the table, and validate it on the client side, 
and the server side.

var Table = document.getElementsByTagName("Table");
Table.focusout = editTable();

*/

//Module 3
//Function to Delete a field from the table (directive), edit the functions later
function delTable(){
    var con = confirm("Are you sure you want to delete this field?");
    if (con == true){
        downloadHTML('../NTB Databse/database.php?document=delete', function(result){
            var span = document.getElementById('error');
            span.innerHTML = result;
        });
    } else{
        alert("Good Descision"); 
    }
}

//Module 4
//Function to add a new record to the database



