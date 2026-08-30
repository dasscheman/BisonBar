import './bootstrap';

import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;


import './soft-ui-dashboard';

let loadingOverlayRegistered = false;

function registerLoadingOverlay() {
    if (loadingOverlayRegistered || !window.Livewire) {
        return;
    }

    const overlay = document.getElementById('loading-overlay');
    if (!overlay) {
        return;
    }

    loadingOverlayRegistered = true;

    let pending = 0;
    let showTimer = null;
    let hideTimer = null;
    let shownAt = 0;
    const minimumVisibleTime = 300;

    const showOverlay = () => {
        if (showTimer || !overlay.classList.contains('d-none')) {
            return;
        }

        showTimer = window.setTimeout(() => {
            showTimer = null;

            if (pending > 0) {
                overlay.classList.remove('d-none');
                overlay.setAttribute('aria-hidden', 'false');
                shownAt = Date.now();
            }
        }, 0);
    };

    const hideOverlay = () => {
        pending--;
        if (pending <= 0) {
            pending = 0;

            if (showTimer) {
                window.clearTimeout(showTimer);
                showTimer = null;
            }

            const hide = () => {
                hideTimer = null;

                if (pending > 0) {
                    return;
                }

                overlay.classList.add('d-none');
                overlay.setAttribute('aria-hidden', 'true');
            };

            const remaining = Math.max(0, minimumVisibleTime - (Date.now() - shownAt));
            if (remaining > 0) {
                hideTimer = window.setTimeout(hide, remaining);
            } else {
                hide();
            }
        }
    };

    Livewire.hook('commit', ({ succeed, fail }) => {
        pending++;
        showOverlay();
        succeed(hideOverlay);
        fail(hideOverlay);
    });
}

document.addEventListener('livewire:init', registerLoadingOverlay);

if (window.Livewire) {
    registerLoadingOverlay();
}

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
