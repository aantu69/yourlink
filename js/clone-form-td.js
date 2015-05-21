$(function () {
    $('#btnAdd').click(function () {   	
        var num     = $('.clonedInput').length; // Checks to see how many "duplicatable" input fields we currently have
        var newNum  = new Number(num + 1);      // The numeric ID of the new input field being added, increasing by 1 each time
        var newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
		
		newElem.find('.control-label').attr('for', 'email-' + newNum);
        newElem.find('.text-input').attr('id', 'email-' + newNum).attr('name', 'emails[]').attr('placeholder', 'Enter email address here').val('');

    	// Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('email-' + newNum).focus();

    	// Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel').attr('disabled', false);
 
    });

    $('#btnDel').click(function () {
        var num = $('.clonedInput').length;
        // how many "duplicatable" input fields we currently have
        $('#entry' + num).slideUp('slow', function () {
        	$(this).remove();
	        // if only five elements remain, disable the "remove" button
	        if (num -1 === 3){
				$('#btnDel').attr('disabled', true);
			}       
	        // enable the "add" button
	        $('#btnAdd').attr('disabled', false);
        });
        return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#btnAdd').attr('disabled', false);
    // Disable the "remove" button
    $('#btnDel').attr('disabled', true);
});