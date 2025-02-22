function validateFName() {
   
    const firstNameInput = document.getElementById("first_name");
    const firstNameError = document.getElementById("nameError1");
    const nameRegex = /^[A-Za-z\s-]+$/;

    // Validate first name
    if (firstNameInput.value.trim() === "") {
        firstNameError.textContent = "First name is required.";
        firstNameInput.style.borderColor = "red";
    } else if (!nameRegex.test(firstNameInput.value)) {
        firstNameError.textContent = "First name can only contain letters, spaces, and hyphens.";
        firstNameInput.style.borderColor = "red";
    } else {
        firstNameError.textContent = "";
        firstNameInput.style.borderColor = "green";
    }
}

function validateLName() {
   
    const lastNameInput = document.getElementById("last_name");
    const lastNameError = document.getElementById("nameError2");

    const nameRegex = /^[A-Za-z\s-]+$/;
    // Validate last name
    if (lastNameInput.value.trim() === "") {
        lastNameError.textContent = "Last name is required.";
        lastNameInput.style.borderColor = "red";
    } else if (!nameRegex.test(lastNameInput.value)) {
        lastNameError.textContent = "Last name can only contain letters, spaces, and hyphens.";
        lastNameInput.style.borderColor = "red";
    } else {
        lastNameError.textContent = "";
        lastNameInput.style.borderColor = "green";
    }
}

function validateEmail() {
    const emailInput = document.getElementById("email");
    const emailError = document.getElementById("emailError");
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailPattern.test(emailInput.value.trim())) {
        emailError.textContent = "Please enter a valid email address.";
        emailError.style.color = "red";
        emailInput.style.borderColor = "red";
    } else {
        emailError.textContent = "";
        emailInput.style.borderColor = "green";
    }
}

function validatePhone() {
    const phoneInput = document.getElementById("phone");
    const phoneError = document.getElementById("phoneError");
    const phonePattern = /^[7-9]{1}[0-9]{9}$/;

    if (!phonePattern.test(phoneInput.value.trim())) {
        phoneError.textContent = "Enter a valid 10-digit mobile number.";
        phoneError.style.color = "red";
        phoneInput.style.borderColor = "red";
    } else {
        phoneError.textContent = "";
        phoneInput.style.borderColor = "green";
    }
}

document.addEventListener("DOMContentLoaded",function() {
    const form = document.getElementById("myForm");

    if(form){
        form.addEventListener("submit", function(event){
            validateName();
            validateEmail();
            validatePhone();

            const nameError = document.getElementById("nameError").textContent;
            const emailError = document.getElementById("emailError").textContent;
            const phoneError = document.getElementById("phoneError").textContent;

            console.log("Name error:", nameError); // Debug
            console.log("Email error:", emailError); // Debug
            console.log("Phone error:", phoneError); // Debug

            if(nameError || emailError || phoneError){
                event.preventDefault();
                alert("Please fix the errors before submission.");
            }
        });
    }
});


let experienceCount = 1; 
let educationCount = 1; 

function addEducationField() {
    const educationSection = document.getElementById("education-section");

    educationCount++;
    const newEducationEntry = document.createElement("div");
    newEducationEntry.classList.add("education-entry");
    newEducationEntry.innerHTML = `
        <h4>${educationCount}) Education</h4> <!-- Add the numbering -->
        <label for="institute_name[]">Institute Name:</label>
        <input type="text" name="institute_name[]" placeholder="Ex:- KK Wagh" required><br>
        
        <label for="degree[]">Degree:</label>
        <input type="text" name="degree[]" placeholder="Ex:- BE, B.Tech, MSc, etc" required><br>
        
        <label for="location[]">School Location:</label>
        <input type="text" name="location[]" placeholder="Ex:- Nashik" required><br>
        
        <label for="description[]">Description:</label>
        <textarea name="description[]" rows="3"></textarea><br>
        
        <label for="from_date[]">From:</label>
        <input type="date" name="from_date[]" required>
        
        <label for="to_date[]">To:</label>
        <input type="date" name="to_date[]"><br>
        
        <label>
            I am currently attending <input type="checkbox" name="currently_attending[]" value="1" onchange="toggleEndDate(this)">
        </label><br>
        
        <button type="button" class="cancel" onclick="removeField(this, 'education')">Delete</button>
    `;
    educationSection.appendChild(newEducationEntry);
}

function addExperienceField() {
    const experienceSection = document.getElementById("experience-section");
    experienceCount++;

    const newExperienceEntry = document.createElement("div");
    newExperienceEntry.classList.add("experience-entry");
    newExperienceEntry.innerHTML = `
        <h4>${experienceCount}) Experience</h4> <!-- Add the numbering -->
        <label for="experience_title[]">Designation: <z style="color:red;">*</z></label>
        <input type="text" name="experience_title[]" placeholder="Ex:- Junior Developer" required><br>
        
        <label for="experience_company[]">Company: <z style="color:red;">*</z></label>
        <input type="text" name="experience_company[]" placeholder="Ex:- Google, Microsoft, etc." required><br>
        
        <label for="experience_location[]">Location: <z style="color:red;">*</z></label>
        <input type="text" name="experience_location[]" placeholder="Ex:- Nashik, USA, etc" required><br>
        
        <label for="experience_description[]">Description:</label>
        <textarea name="experience_description[]"></textarea><br>
        
        <label for="experience_from_date[]" required>From Date: <z style="color:red;">*</z></label>
        <input type="date" name="experience_from_date[]"><br>
        
        <label for="experience_to_date[]">To Date:</label>
        <input type="date" name="experience_to_date[]"><br>

        <label>
            I am currently working <input type="checkbox" name="currently_attending[]" value="1" onchange="toggleEndDate(this)">
        </label><br>
        
        <button type="button" class="cancel" onclick="removeField(this, 'experience')">Delete</button>
    `;
    experienceSection.appendChild(newExperienceEntry);
}

function removeField(button, type) {
    const entry = button.parentNode;
    entry.remove();

    if (type === "education") {
        const educationEntries = document.querySelectorAll(".education-entry h4");
        educationEntries.forEach((entry, index) => {
            entry.textContent = `${index + 2}) Education`;
        });
        educationCount = educationEntries.length;
    } else if (type === "experience") {
        const experienceEntries = document.querySelectorAll(".experience-entry h4");
        experienceEntries.forEach((entry, index) => {
            entry.textContent = `${index + 2}) Experience`;
        });
        experienceCount = experienceEntries.length;
    }
}

function toggleEndDate(checkbox) {
    const parentDiv = checkbox.closest("div");
    const toDateField = parentDiv.querySelector("input[name='to_date[]'], input[name='experience_to_date[]']");

    if (checkbox.checked) {
        toDateField.disabled = true;
        toDateField.value = "Attending";
    } else {
        toDateField.disabled = false;
        toDateField.value = "";
    }
}


// function toggleExperienceSection(){
//     const fresherRadio = document.getElementById('fresher');
//     const experienceSection = document.getElementById('experience-section');

//     if(fresherRadio.checked){
//         experienceSection.querySelectorAll('input,textarea').forEach((field)=>{
//             field.disabled = true;
//             field.value = "";
//         });
//     }else{
//         experienceSection.querySelectorAll('input,textarea').forEach((field)=>{
//             field.disabled = false;
//         });
//     }
// }

function toggleExperienceSection(){
    const fresherRadio = document.getElementById('fresher');
    const experienceSection = document.getElementById('experience-section');
    const experienceButton = document.getElementById('experience-button');

    const experienceTitle = document.getElementById("experience_title[]");
    const experienceCompany = document.getElementById("experience_company[]");
    const experienceLocation = document.getElementById("experience_location[]");
    const experienceFromDate = document.getElementById("experience_from_date[]");

    if(fresherRadio.checked){
        experienceSection.style.display = 'none';
        experienceButton.style.display = 'none';

        experienceTitle.removeAttribute("required");
        experienceCompany.removeAttribute("required");
        experienceLocation.removeAttribute("required");
        experienceFromDate.removeAttribute("required");
    }else{
        experienceSection.style.display = 'block';
        experienceButton.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const countryCodeSelect = document.getElementById('country_code');

    // Fetch country data from the REST Countries API
    fetch('https://restcountries.com/v3.1/all')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            
            data.sort((a, b) => a.name.common.localeCompare(b.name.common));

            data.forEach(country => {
                if (country.idd && country.idd.root) {
                    const code = country.idd.root + (country.idd.suffixes ? country.idd.suffixes[0] : '');
                    const option = document.createElement('option');
                    option.value = code;
                    option.textContent = `${code} (${country.name.common})`;
                    countryCodeSelect.appendChild(option);

                    if (code === '+91') {
                        option.selected = true;
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching country codes:', error);
            const errorMessage = document.createElement('option');
            errorMessage.value = '';
            errorMessage.textContent = 'Error loading country codes';
            errorMessage.disabled = true;
            countryCodeSelect.appendChild(errorMessage);
        });
});
