/*
	Changelog for toggle()
	1/28
	-Parameter for toggle() is the source, which gets which checkbox to base the action from.
	-Gets the array of checkboxes (named users[]) and traverses through all of the checkboxes.
	-Sets the state of the current users[] checkbox to the state of the source checkbox (Select/Deselect All).
*/
function toggle(source){
	checkboxes = document.getElementsByName('users[]');
	for(var i=0, n=checkboxes.length; i<n; i++){
		checkboxes[i].checked = source.checked;
	}
}

/*
	Changelog for deleteValidate()
	1/28
	-Creates a prompt popup to confirm user of deletion. If TRUE, creates another confirmation. Else if FALSE, cancel action.
	-If TRUE on the second popup, continue to controller, then to model, then delete from database. Else if FALSE, cancel action.
*/
function deleteValidate(){
	var deletePromptOne = confirm("Are you sure you want to delete? Process cannot be reversed after action has been done.");
	
	if(deletePromptOne){
		var deletePromptTwo = confirm("Are you REALLY sure you want to delete? Say bye to data after this?");
	}
	
	return deletePromptTwo;
}