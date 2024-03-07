function onTimeChange(inputElement) {
    let timeSplit = $(inputElement).val().split(':');
    console.log(`timeSplit ${timeSplit}`);
    let hours;
    let minutes;
    let meridian;
    hours = parseInt(timeSplit[0]);
    minutes = parseInt(timeSplit[1]);

    if(hours > 12){
        meridian = 'PM';
        console.log(`meridian ${meridian}`);
        hours -= 12;
    }else if(hours < 12){
        meridian = 'AM';
        console.log(`meridian ${meridian}`);
        if(hours == 0){
            hours = 12;
        }
    }else{
        meridian = 'PM';
    }
    $('#hiddenTime').val(`${hours}:${minutes} ${meridian}`);
}