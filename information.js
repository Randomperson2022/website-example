function submitForm() {
    var items = document.getElementsByClassName("items");
    var Checked = false;

    for (var i = 0; i < items.length; i++) {
        if (items[i].checked) {
            Checked = true;
            break;
        }
    }

    if (!atLeastOneChecked) {
        alert("Please select at least one item before placing the order.");
    } else {
        document.orderForm.submit();
    }
}
