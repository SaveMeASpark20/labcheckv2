
//activePage
const activePage = window.location.pathname;

const navLInks = document.querySelectorAll('.side-menu a').
forEach(link => {

    if(link.href.includes(`${activePage}`)){
        link.classList.add('active');
    }
});

const navLInksDropdown = document.querySelectorAll('.side-dropdown a').
forEach(link => {
    if(link.href.includes(`${activePage}`)){
        link.classList.add('active');
    }
});

if (window.location.href.includes('user_register')) {

    const userTypeFilter = document.getElementById("userTypeFilter");
    const userTable = document.getElementById("userTable");

    userTypeFilter.addEventListener("change", function () {
        const selectedUserType = userTypeFilter.value;
        var thCell = document.querySelector(".hide-th"); 
        var tdCells = userTable.querySelectorAll("td[data-cell='section']");
        

        if (selectedUserType === 'admin' || selectedUserType === 'faculty') {
            thCell.style.display ="none"; 
            tdCells.forEach((tdCell) => tdCell.style.display = "none"); // Hide the <td> elements
        }else {
            thCell.style.display = "";
            tdCells.forEach((tdCell) => tdCell.style.display = "");
        }
        

        const rows = userTable.querySelectorAll("tr");

        let rowCount = 1;
        rows.forEach(function (row) {
            
            const userType = row.getAttribute("data-user-type");
            if (selectedUserType === "all" || userType === selectedUserType) {
                row.style.display = "";
                if(rowCount % 2 == 1){
                    rowCount = 0;
                    row.style.background = "white";
                }
                else{
                    rowCount = 1;
                    row.style.background = "#f5f5dd";
                }
            } else {
                row.style.display = "none";
            }

        });
    });
	
	
	//show add user
    const showFormButton = document.getElementById("showAddUserForm");
    const formContainer = document.getElementById("addUserForm");

    showFormButton.addEventListener("click", function () {
        formContainer.classList.toggle("show");
    });

    function closeAddUserModal(){
        formContainer.classList.toggle("show");
    }

    window.addEventListener('click', function(event) {
        var modal = document.getElementById('addUserForm');
        if (event.target == modal) {
            closeAddUserModal();
        }
    });
}



if (window.location.href.includes('home')) {
    const showFormButton = document.getElementById("createAnnouncement");
    const formContainer = document.getElementById("showInputAnnouncement");
    const originalTextButton = showFormButton.innerHTML;
    showFormButton.addEventListener("click", function () {
        if(showFormButton.innerHTML.includes('Close')){
            showFormButton.innerHTML = originalTextButton;
        }else {
            showFormButton.innerHTML = 'Close <span class="fa fa-times"></span>';
        }
        formContainer.classList.toggle("show");
    });
}




//show confirmation in the request
function confirmApproval() {
    if (confirm("Are you sure you want to approve this request?")) {
        return true; // Continue with form submission
    } else {
        return false; // Cancel form submission
    }
}
function confirmResolved() {
    return confirm("Are you sure you want to mark this request as resolved?");
}
//show rejection button and text-area
function showRejectionReason(button) {
	
    const rejectionForm = button.closest(".rejection-form");

    const rejectReason = rejectionForm.querySelector(".reject-reason");
    rejectReason.style.display = "block";
}


// SIDEBAR DROPDOWN
const allDropdown = document.querySelectorAll('#sidebar .side-dropdown');
const sidebar = document.getElementById('sidebar');

allDropdown.forEach(item=> {
	const a = item.parentElement.querySelector('a:first-child');
	a.addEventListener('click', function (e) {
		e.preventDefault();

		if(!this.classList.contains('active')) {
			allDropdown.forEach(i=> {
				const aLink = i.parentElement.querySelector('a:first-child');

				aLink.classList.remove('active');
				i.classList.remove('show');
			})
		}

		this.classList.toggle('active');
		item.classList.toggle('show');
	})
})

// SIDEBAR COLLAPSE
const toggleSidebar = document.querySelector('nav .toggle-sidebar');
const allSideDivider = document.querySelectorAll('#sidebar .divider');

if(sidebar.classList.contains('hide')) {
	allSideDivider.forEach(item => {
		item.textContent = '-'
	})
	allDropdown.forEach(item=> {
		const a = item.parentElement.querySelector('a:first-child');
		a.classList.remove('active');
		item.classList.remove('show');
	})
} else {
	allSideDivider.forEach(item=> {
		item.textContent = item.dataset.text;
	})
}

toggleSidebar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');

	if(sidebar.classList.contains('hide')) {
		allSideDivider.forEach(item=> {
			item.textContent = '-'
		})

		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
	} else {
		allSideDivider.forEach(item=> {
			item.textContent = item.dataset.text;
		})
	}
})

sidebar.addEventListener('mouseleave', function () {
	if(this.classList.contains('hide')) {
		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
		allSideDivider.forEach(item=> {
			item.textContent = '-'
		})
	}
})

sidebar.addEventListener('mouseenter', function () {
	if(this.classList.contains('hide')) {
		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
		allSideDivider.forEach(item=> {
			item.textContent = item.dataset.text;
		})
	}
})

// // PROFILE DROPDOWN
// const profile = document.querySelector('nav .profile');
// const imgProfile = profile.querySelector('img');
// const dropdownProfile = profile.querySelector('.profile-link');

// imgProfile.addEventListener('click', function () {
// 	dropdownProfile.classList.toggle('show');
// })

// MENU
const allMenu = document.querySelectorAll('main .content-data .head .menu');

allMenu.forEach(item=> {
	const icon = item.querySelector('.icon');
	const menuLink = item.querySelector('.menu-link');

	icon.addEventListener('click', function () {
		menuLink.classList.toggle('show');
	})
})


// window.addEventListener('click', function (e) {
// 	if(e.target !== imgProfile) {
// 		if(e.target !== dropdownProfile) {
// 			if(dropdownProfile.classList.contains('show')) {
// 				dropdownProfile.classList.remove('show');
// 			}
// 		}
// 	}

// 	allMenu.forEach(item=> {
// 		const icon = item.querySelector('.icon');
// 		const menuLink = item.querySelector('.menu-link');

// 		if(e.target !== icon) {
// 			if(e.target !== menuLink) {
// 				if (menuLink.classList.contains('show')) {
// 					menuLink.classList.remove('show')
// 				}
// 			}
// 		}
// 	})
// })



if (window.location.href.includes('settings')) {
    const buttons = document.querySelectorAll('.myButton');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const schoolYearValue = this.getAttribute('value');
            const statusValue = this.getAttribute('data-status');
            const semesterValue = this.getAttribute('data-semester');
            const data = {
                schoolYear: schoolYearValue,
                semester: semesterValue,
                status: statusValue,
            };

            fetch("../includes/update_acadyear.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(responseData => {
                if (responseData.message === 'Data received and processed successfully') {
                    
                    const newStatus = statusValue === '0' ? '1' : '0';
                    
                    // Update the data-status attribute
                    this.setAttribute('data-status', newStatus);

                    // Update the button text and background color
                    if (newStatus === '0') {
                        this.innerHTML = 'Enable ? ';
                        this.style.backgroundColor = '#006d1b ';
                    } else {
                        this.innerHTML = 'Disable ? ';
                        this.style.backgroundColor = '#e23100 ';
                    }


                    // Update the status in the <td> element
                    const statusTd = document.getElementById('status-' + schoolYearValue);
                    statusTd.textContent = newStatus === '0' ? 'Disable ' : 'Enable ';
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
            });
        });
    });

    const buttonSchoolYearForm = document.getElementById('showSchoolYearForm');
    const schoolYearForm = document.getElementById('addAcadForm');

    buttonSchoolYearForm.addEventListener('click', () => {
        schoolYearForm.classList.toggle('show');
    })

    function closeAddAcadYearModal(){
        schoolYearForm.classList.toggle("show");
    }

    window.addEventListener('click', function(event) {
        var modal = document.getElementById('addAcadForm');
        if (event.target == modal) {
            closeAddAcadYearModal();
        }
    });

    const buttonUpdateSchoolYearForm = document.getElementById('showUpdateSchoolYearForm');
    const updateSchoolYearForm = document.getElementById('addUpdateAcadForm');

    buttonUpdateSchoolYearForm.addEventListener('click', () => {
        updateSchoolYearForm.classList.toggle('show');
    })

    function closeAddUpdateAcadYearModal(){
        updateSchoolYearForm.classList.toggle("show");
    }

    window.addEventListener('click', function(event) {
        var modal = document.getElementById('addUpdateAcadForm');
        if (event.target == modal) {
            closeAddUpdateAcadYearModal();
        }
    });
}


// Function to show the rejection modal
function showRejectionReason(button) {
    // Get the parent form element
    var form = button.closest('.rejection-form');
    
    // Get the request_id from the hidden input field
    var requestId = form.querySelector('input[name="request_id"]').value;

    // Set the request_id in the modal form
    document.getElementById('rejectionModal').querySelector('input[name="request_id"]').value = requestId;

    // Show the modal
    document.getElementById('rejectionModal').style.display = 'block';
}


// Function to close the rejection modal
function closeModal() {
    document.getElementById('rejectionModal').style.display = 'none';
}
// Close the modal when the close button is clicked
if(document.getElementById('closeModal')){
    document.getElementById('closeModal').addEventListener('click', closeModal);
}

// Close the modal when clicking outside of it
window.addEventListener('click', function(event) {
    var modal = document.getElementById('rejectionModal');
    if (event.target == modal) {
        closeModal();
    }
});

//notification
if(document.querySelector('.notification')){
    var notifications = document.querySelector('.notification');

    notifications.addEventListener('animationend', function(event) {
        if (event.animationName === 'fadeOut') {
            // Remove the notification element from the DOM
            notifications.remove();
        }
    });
}


  

