$(document).ready(function() {

    var delButton = $(document).find('#delete');
    delButton.on('click', function() {
        if(confirm('Please confirm')) {
            return true;
        } else {
            return false;
        }
    })
})