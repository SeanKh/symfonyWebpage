const users=document.getElementById("users");

if(users){
    users.addEventListener('click', e => {
        if(e.target.className==='btn btn-danger delete-user'){
            if(confirm("Confirm the remove of user with OK button, else press Cancel.")){
                const id=e.target.getAttribute('data-id');

                alert("Deleted user with id: "+id);

                fetch(`/symphuser/public/user/delete/${id}`, {
                    method: 'DELETE'
                  }).then(res => window.location.reload());
            }
        }
    })
}

