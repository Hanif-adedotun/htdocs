//Display the main table Directive by requesting from the PHP table
var body = document.getElementsByTagName("body");
body.onload = getTable();

function getTable(){
    downloadHTML('database.php?document=table', function(result){
        var table = document.getElementById('tableResult');
        table.innerHTML = result;
    });

}
//onclick='delTable()'

var Table = document.getElementsByTagName("Table");
//Table.focusout = editTable();

//Module to Delete a field from the table (directive)
function delTable(){
    var con = confirm("Are you sure you want to delete this field?");
    if (con == true){
        downloadHTML('database.php?document=delete', function(result){
            var span = document.getElementById('error');
            span.innerHTML = result;
        });
    } else{
        alert("Good Descision"); 
    }
}



