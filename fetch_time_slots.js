document.getElementById('day').addEventListener('change', function() {
    var selectedClassID = document.getElementById('classID').value;
    var selectedDay = this.value;

    // Update the label with the selected day
    document.getElementById('selectedDayLabel').textContent = selectedDay;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_time_slots.php?classID=' + selectedClassID + '&day=' + selectedDay, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var timeSlots = JSON.parse(xhr.responseText);

            var timeSlotSelect = document.getElementById('timeSlot');
            timeSlotSelect.innerHTML = '<option value="" disabled selected></option>';

            // Populate the "timeSlot" select element with the retrieved options
            timeSlots.forEach(function(timeSlot) {
                var option = document.createElement('option');
                option.value = timeSlot.scheduleID;
                option.text = timeSlot.start_time + ' - ' + timeSlot.end_time;
                option.dataset.start_time = timeSlot.start_time;
                option.dataset.end_time = timeSlot.end_time;
                timeSlotSelect.add(option);
            });
        }
    };
    xhr.send();
});

document.getElementById('timeSlot').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];

    // Retrieve start_time and end_time from data attributes
    var start_time = selectedOption.dataset.start_time;
    var end_time = selectedOption.dataset.end_time;

    // Set the values of the hidden input fields
    document.getElementById('start_time').value = start_time;
    document.getElementById('end_time').value = end_time;

    // Do something with the retrieved start_time and end_time
    console.log('Selected start_time:', start_time);
    console.log('Selected end_time:', end_time);
});
