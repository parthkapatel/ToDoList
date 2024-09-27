function showLoader(){
    if($('#loader').length){
        $('#loader').removeClass('hidden');
    }
}

function hideLoader(){
    if($('#loader').length){
        $('#loader').addClass('hidden');
    }
}
