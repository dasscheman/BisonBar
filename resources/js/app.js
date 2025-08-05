import './bootstrap';

import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;


import './soft-ui-dashboard';

window.addEventListener('hideModal', event => {
    const modalElements = document.getElementsByClassName('modal');
    for (let i = 0; i < modalElements.length; i++) {
        const element = modalElements[i];
        // Perform actions on each element
        var myModal = bootstrap.Modal.getOrCreateInstance(element);
        myModal.hide();
        console.log(element);
    }
})
