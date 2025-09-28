$("#acc_name").autocomplete({
    source: function(request, response)
    {
        $.ajax({
            url: 'http://localhost/Small%20Hospital/backend/admin/server.php',
            type: 'GET',
            datatype: 'json',
            success:function(data){
                console.log(data)

            }
            
        })
    }
});