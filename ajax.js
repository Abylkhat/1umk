$.ajax({
    type: "POST",
    url: 'script.php',
    data: {name: 'John'},
    success: function(data){
        console.log(data);
    },
    error: function(xhr, status, error){
        console.error(xhr);
    }
});