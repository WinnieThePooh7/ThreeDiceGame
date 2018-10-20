
function clearPanels()
{
    document.getElementById("right-panel").style.visibility="hidden";
    document.getElementById("error").style.visibility="hidden";
}
function sendData()
{
    var id = document.getElementById("id").value;
    var value = document.getElementById("value").value;
    var stake = document.getElementById("stake").value;
    
    
    var request = new XMLHttpRequest();
    
    
    var jsonRequest = JSON.stringify({"id":id,"stake":stake,"product":value});
    request.onreadystatechange = function()
    {
        if(this.readyState===4 && this.status===200)
        {
            var odgovor = JSON.parse(this.responseText);
            
            document.getElementById("error").style.visibility="hidden";
            document.getElementById("dice1").innerHTML=odgovor.dice1;
            document.getElementById("dice2").innerHTML=odgovor.dice2;
            document.getElementById("dice3").innerHTML=odgovor.dice3;
            document.getElementById("balance").innerHTML=odgovor.amount;
            if(odgovor.status==1) 
            {
                document.getElementById("result").innerHTML="YOU WIN";
                document.getElementById("result").style.color="green";
            }
            else
            {
                document.getElementById("result").innerHTML="YOU LOSE";
                document.getElementById("result").style.color="red";
            }

            document.getElementById("right-panel").style.visibility="visible";
        }
        else if(this.readyState===4 && this.status===400)
        {
            var odgovor = JSON.parse(this.responseText);

            document.getElementById("right-panel").style.visibility="hidden";
            document.getElementById("error").style.color="red";
            document.getElementById("error").style.fontSize="20px";
            document.getElementById("error").innerHTML=odgovor.message;
            document.getElementById("error").style.visibility="visible";
        }
        
    };
    document.getElementById("id").value="";
    document.getElementById("value").value="";
    document.getElementById("stake").value="";
    request.open("POST","http://localhost:8080/ThreeDiceGame/api/APIs/ThreeDiceApi.php",true);
    request.setRequestHeader("Content-Type","application/json");
    request.send(jsonRequest);
}
