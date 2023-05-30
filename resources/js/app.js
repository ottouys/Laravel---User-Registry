import './bootstrap';

jQuery( document ).ready( function( $ ) {       

    loadAllUsers();

    $('#addUserForm').on('submit', function(e) {
        e.preventDefault();
        
        var name = $('#name').val();
        var surname = $('#surname').val();
        var email = $('#email').val();
        var position = $('#position').val();        
        
        
        $.ajax({
            type: "POST",
            url: '/add-user',
            data: {
                _token: $('input[name="_token"]').val(),
                name:name,
                surname:surname, 
                email:email, 
                position:position
            },
            success: function( data ) {
                console.log(data);
                
                if(data.status == 'success'){
                    $('#addUsermessage').css({
                        'color': 'green'
                    });

                    $('#addUsermessage').text(data.msg);

                    // Lets load the new data so long
                    loadAllUsers();

                    setTimeout(() => {
                        $('#addUsermessage').text('');
                        $('#AddNewUserModal').modal('hide');                    
                    }, 2500);
                } else if(data.status == 'error') {
                    $('#addUsermessage').css({
                        'color': 'red'
                    });

                    $('#addUsermessage').text(data.msg);

                    setTimeout(() => {
                        $('#addUsermessage').text('');                   
                    }, 2500);
                }                                
            }
        });
    });

    $('#deleteUserForm').on('submit', function(e) {
        e.preventDefault();
        
        var id = $('#userId').val();            
        
        
        $.ajax({
            type: "DELETE",
            url: '/delete-user',
            data: {
                _token: $('input[name="_token"]').val(),
                id:id,                
            },
            success: function( data ) {
                console.log(data);
                
                if(data.status == 'success'){
                    $('#deleteUsermessage').css({
                        'color': 'green'
                    });

                    $('#deleteUsermessage').text(data.msg);

                    // Lets load the new data so long
                    loadAllUsers();
    
                    setTimeout(() => {
                        $('#message').text('');
                        $('#DeleteUserModal').modal('hide');                    
                    }, 2500); 
                } else if(data.status == 'error') {
                    $('#deleteUsermessage').css({
                        'color': 'red'
                    });

                    $('#deleteUsermessage').text(data.msg);

                    setTimeout(() => {
                        $('#message').text('');                 
                    }, 2500); 
                }                               
            }
        });
    });
});

function loadAllUsers()
{
    $('#userLoader').show();

    $.ajax({
        type: "GET",
        url: '/users',        
        success: function( data ) {
            // console.log(data);  

            if(data.status == 'success'){
                let $html = '<div class="col"><table id="users" class="table">';

                $.each(data.users, function(index, user){
                    let $id = user.id;
                    let $name = user.name;
                    let $surname = user.surname;
                    let $email = user.email;

                    $html += `
                        <tr id="${$id}" class="user-item">
                            <td class="name">${$name}  ${$surname}</div>
                            <td class="email">${$email}</div>
                            <td class="delete"><button type="button" class="btn btn-dark" onclick="toggleDeleteModal(${$id})"><ion-icon name="trash-outline"></ion-icon></button></div>
                        </tr>`;        
                });

                $html += '</table></div>  ';

                $('#userLoader').hide();
                $('#user-listing').html($html);
            } else if(data.status == 'error') {
                $('#user-listing').html('<p>An error has occured</p>');
            }            
        }
    });
}

window.toggleDeleteModal = function ($id) {    
    $('#DeleteUserModal').modal('toggle');
    $('#DeleteUserModal #userId').val($id);    
}
