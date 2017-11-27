function phonenumber()  
{  alert("Okay");
	var text = document.getElementById("phone");
	var phoneno = /^\d{10}$/;  
	if((text.value.match(phoneno))  
	{  
		alert('Okay');
	}  
  else  
	{  
		alert("phone number incorrect!");  
			
	}  
}  
							    function Validate() {
								var x=phonenumber(document.getElementById("phone"));
								if(x)
								{
							        var password = document.getElementById("txtPassword").value;
							        var confirmPassword = document.getElementById("txtConfirmPassword").value;
							        if (password != confirmPassword ) {
									
							            alert("Passwords do not match.");
							            return false;
							        }
							        return true;
							    }
								}
								else{
								alert("INVALID PHONE NUMBER!");
								}
							</script>