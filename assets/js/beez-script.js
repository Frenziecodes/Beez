document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.beez-tab');
    const tabContents = document.querySelectorAll('.beez-tab-content');

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            tabContents.forEach(content => content.style.display = 'none');
            tabContents[index].style.display = 'block';
        });
    });

    // Set the first tab as active by default
    tabs[0].classList.add('active');
    tabContents[0].style.display = 'block';
});