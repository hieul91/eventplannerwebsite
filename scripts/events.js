//function that will ask for confirmation to delete the event from the server/database
function delete_event(id) {
    if (confirm("Are you sure you want to delete this event?")) {
        window.location = "delete.php?id=" + id
    }
}