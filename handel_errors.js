function validateForm() {
    let isValid = true;

    // Clear previous errors
    document.querySelectorAll('.error-message').forEach(span => span.textContent = '');

    // Example Validation: 2G On Air Date
    const onAirDate = document.getElementById('onairdate').value;
    if (onAirDate === '') {
        document.getElementById('onairdate-error').textContent = 'Please select a 2G On Air Date.';
        isValid = false;
    }

    // Add more validations as needed 
    return isValid;
}


document.addEventListener('DOMContentLoaded', function () {
    const contentContainer = document.getElementById('content-container');
    const radios = document.querySelectorAll('input[name="band"]');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            contentContainer.querySelectorAll('.content-div').forEach(div => {
                div.style.display = 'none';
            });

            const selectedOption = document.querySelector(`#div${this.id.slice(-1)}`);
            selectedOption.style.display = 'block';
        });
    });
});


document.querySelectorAll('[data-tooltip]').forEach(item => {
    item.addEventListener('mouseenter', event => {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = event.target.getAttribute('data-tooltip');
        document.body.appendChild(tooltip);

        tooltip.style.left = `${event.pageX}px`;
        tooltip.style.top = `${event.pageY}px`;
    });

    item.addEventListener('mouseleave', () => {
        document.querySelector('.tooltip').remove();
    });
});



function updateData(url, data) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        console.log('Success:', result);
        // Update the UI with the result
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}

const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('input', debounce(event => {
    console.log(event.target.value);
    // Add your search logic here
}, 300));



function handleResize() {
    if (window.innerWidth < 600) {
        document.body.classList.add('mobile');
    } else {
        document.body.classList.remove('mobile');
    }
}

window.addEventListener('resize', handleResize);
document.addEventListener('DOMContentLoaded', handleResize);



// /* CSS */
// .content-div {
//     opacity: 0;
//     transition: opacity 0.5s ease-in-out;
// }
// .content-div.show {
//     opacity: 1;
// }

document.querySelector('#triggerAnimation').addEventListener('click', () => {
    const div = document.querySelector('.content-div');
    div.classList.add('show');
});
