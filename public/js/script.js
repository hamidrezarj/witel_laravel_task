$(function() {
    $('[data-toggle="datepicker"]').datepicker();
});

document.getElementById('input-image').addEventListener('change', function(event){
    console.log('image val changed');
    console.log(this.value);
    const [file] = this.files;
    
    if(file){
        console.log(file);
        let file_path = URL.createObjectURL(file);
        console.log('file path: ', file_path);
        $('#profile-img').attr('src', file_path);
    }
});