// Save new user data
function saveNewUserData() {
    var login = jQuery('#newUserLogin').val();
    var password = jQuery('#newUserPassword').val();
    var role = jQuery('#newUserRole').val();

    jQuery.ajax({
        url: '../dashboard/users',
        type: 'POST',
        datatype: 'JSON',
        headers: {
            'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
        },
        data: {
            action: 'addNewUser',
            login: login,
            password: password,
            role: role,
            _token: jQuery('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.code == 1) {
                jQuery('#addNewUserModal').modal('hide');
                jQuery('#addNewUserModal input').val('');
                jQuery('#successMessage .message').text(response.message);
                jQuery('#successMessage').fadeIn();
            } else if (response.code == 0) {
                jQuery('#newUserModalErrorMessage p').text(response.message);
                jQuery('#newUserModalErrorMessage').fadeIn();
            } else {
                jQuery('#newUserModalErrorMessage').fadeIn();
            }
        },
        error: function(response) {
            jQuery('#newUserModalErrorMessage').fadeIn();
        },
        complete: function() {
            setTimeout(function() {
                jQuery('#newUserModalErrorMessage, #successMessage, #errorMessage').fadeOut();
                location.reload();
            }, 1500);
        }
    });
}

// Save new task data
function saveNewTaskData() {

    var title = jQuery('#newTaskTitle').val();
    var userId = jQuery('#newTaskUserId').val();
    var formData = new FormData();
    formData.append('action', 'addNewTask');
    formData.append('_token', jQuery('meta[name="csrf-token"]').attr('content'));
    formData.append('title', title);
    formData.append('userId', userId);
    formData.append('taskFile', taskDropzone.getAcceptedFiles());

    jQuery.ajax({
        url: '../dashboard/users',
        type: 'POST',
        datatype: 'JSON',
        headers: {
            'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
        },
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function(response) {
            if (response.code == 1) {
                jQuery('#addTaskModal').modal('hide');
                jQuery('#addTaskModal input').val('');
                jQuery('#successMessage .message').text(response.message);
                jQuery('#successMessage').fadeIn();
            } else if (response.code == 0) {
                jQuery('#newTaskModalErrorMessage p').text(response.message);
                jQuery('#newTaskModalErrorMessage').fadeIn();
            } else {
                jQuery('#newTaskModalErrorMessage').fadeIn();
            }
        },
        error: function(response) {
            jQuery('#newTaskModalErrorMessage').fadeIn();
        },
        complete: function() {
            setTimeout(function() {
                jQuery('#newTaskModalErrorMessage, #successMessage, #errorMessage').fadeOut();
                //location.reload();
            }, 1500);
        }
    });
}

// Delete user data
function deleteUserData() {
    var id = jQuery('#deleteUserId').val();
    jQuery.ajax({
        url: '../dashboard/users',
        type: 'POST',
        datatype: 'JSON',
        headers: {
            'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
        },
        data: {
            action: 'deleteUserData',
            id: id,
            _token: jQuery('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.code == 1) {
                jQuery('#deleteUserModal').modal('hide');
                jQuery('#successMessage .message').text(response.message);
                jQuery('#successMessage').fadeIn();
            } else if (response.code == 0) {
                jQuery('#newUserModalErrorMessage p').text(response.message);
                jQuery('#newUserModalErrorMessage').fadeIn();
            } else {
                jQuery('#newUserModalErrorMessage').fadeIn();
            }
        },
        error: function(response) {
            jQuery('#newUserModalErrorMessage').fadeIn();
        },
        complete: function() {
            setTimeout(function() {
                jQuery('#newUserModalErrorMessage, #successMessage, #errorMessage').fadeOut();
                location.reload();
            }, 1500);
        }
    });
}

Dropzone.autoDiscover = false;
jQuery(document).ready(function() {
    taskDropzone = new Dropzone("#taskDropzoneForm", { 
        paramName: 'taskFile',
        maxFiles: 1,
        url: '../dashboard/task',
        init: function() {
            this.on("maxfilesexceeded", function(file){
                this.removeAllFiles();
                this.addFile(file);
            });
        },
        complete: function(response) {
            jQuery('#addTaskModal').modal('hide');

            if (response.status == 'success') {
                jQuery('#successMessage .message').text('Success create task.');
                jQuery('#successMessage').fadeIn();
            } else {
                jQuery('#errorMessage .message').text('Error create task.');
                jQuery('#errorMessage').fadeIn();
            }
            setTimeout(function() {
                jQuery('#successMessage, #errorMessage').fadeOut();
                location.reload();
            }, 1500);
        }
    });
});