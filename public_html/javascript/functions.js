function cent2inch(form) {

    var counter = 0;

    var l = parseFloat(form.length.value,10);
    var w = parseFloat(form.width.value, 10);
    var h = parseFloat(form.height.value, 10);
        
    form.length.value = l/2.54;
    form.width.value = w/2.54;
    form.height.value = h/2.54;


}

function confirmationDeletePhoto(id) {

    var answer =  confirm("Are you sure you would like to delete the photo?")

    if(answer) {
        window.location = "image_delete.php?id=" + id;
    }

}

function confirmationDeleteAddress(id) {

    var answer =  confirm("Are you sure you would like to delete the address?")

    if(answer) {
        window.location = "address_delete.php?id=" + id;
    }

}

function confirmationDeleteItem(id,itemNumber) {

    var answer =  confirm("Are you sure you would like to delete item " + itemNumber + "?")

    if(answer) {
        window.location = "item_delete.php?id=" + id;
    }

}