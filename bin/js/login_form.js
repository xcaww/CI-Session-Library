function removeText(inputID){
if(document.getElementById(inputID).value == 'username' || document.getElementById(inputID).value == 'password'){
	document.getElementById(inputID).value='';
}
}