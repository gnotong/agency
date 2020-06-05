$(document).ready(function () {
    // Allows to show file name in the form input when we upload file
    bsCustomFileInput.init()
})

$("#add-image").click(function () {
    let widgetCounter = $("#widget_counter");
    let houseAttach = $("#house_attachments");
    // + helps to parse the value into an integer
    const counter = +widgetCounter.val();

    const template = houseAttach.data("prototype").replace(/__name__/g, counter);

    houseAttach.append(template);

    widgetCounter.val(counter + 1);

    handleDeleteButtons();
    bsCustomFileInput.init();
})

function handleDeleteButtons() {
    $("button[data-action='delete']").click(function () {
        const target = this.dataset.target;
        $(target).remove();
    })
}

function updateCounter() {
    const count = +$('#house_attachments div.form-group').length;

    $('#widget_counter').val(count);
}

// initialises the images counter base on the number of image form-group elements in the DOM
updateCounter();
// Handle delete buttons on page load
handleDeleteButtons()