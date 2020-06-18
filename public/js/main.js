const users=document.getElementById("users");

if(users){
    users.addEventListener('click', e => {
        if(e.target.className==='btn btn-danger delete-user'){
            if(confirm('Sure?')){
                const id=e.target.getAttribute('data-id');

                alert(id);

                fetch(`/symphuser/public/user/delete/${id}`, {
                    method: 'DELETE'
                  }).then(res => window.location.reload());
            }
        }
    })
}

