$('#field-name').on('change', function (e) {
    var fileName = e.target.files[0].name;
    $(this).next().text(fileName);
});

$('.delete-btn').on('click', function(){
    if(confirm('Are you sure you want to delete your post?')){
        return true;
    } else {
        return false;
    }
});