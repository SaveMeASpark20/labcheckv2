const toggleButton = document.getElementsByClassName('bars')[0];
const navbarLinks = document.getElementsByClassName('navbar-links')[0];
toggleButton.addEventListener('click', () => {
    navbarLinks.classList.toggle('active');
    
})

const activePage = window.location.pathname;

const navLInks = document.querySelectorAll('.navbar-links a').
forEach(link => {

    if(link.href.includes(`${activePage}`)){
        link.classList.add('active-link');
    }
});

if (window.location.href.includes('home')) {
    const searchInput = document.getElementById("searchInput");
    const ticketRowContainer = document.getElementById("ticketRowContainer");
    const ticketRows = ticketRowContainer.querySelectorAll(".ticket");
    console.log(ticketRows);
    function filterResults() {
        const searchTerm = searchInput.value.toLowerCase();

        const regexPattern = new RegExp(searchTerm, "i"); // "i" flag for case-insensitive search

        ticketRows.forEach((ticketRow) => {
            const ticketText = ticketRow.textContent.toLowerCase();

            if (regexPattern.test(ticketText)) {
                ticketRow.style.display = "block";
            } else {
                ticketRow.style.display = "none";
            }
        });
    }

    searchInput.addEventListener("input", filterResults);

    filterResults();                                                    
}


if (window.location.href.includes('make_a_request')) {
    
    function toggleTimeEnd() {
        var requestType = document.getElementById("option-request").value;
        var timeEndInput = document.getElementById("timeEndInput");

        if (requestType === "repair") {
            timeEndInput.classList.add("hidden");
        } else {
            timeEndInput.classList.remove("hidden");
        }
    }

    // Call the function on page load to set the initial state
    toggleTimeEnd();
}