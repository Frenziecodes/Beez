document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.beez-tab');
    const tabContents = document.querySelectorAll('.beez-tab-content');

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('beez-active-tab'));
            tab.classList.add('beez-active-tab');

            tabContents.forEach(content => content.style.display = 'none');
            tabContents[index].style.display = 'block';
        });
    });

    tabContents.forEach((content, index) => {
        if (index !== 0) {
            content.style.display = 'none';
        }
    });
    
    tabs[0].classList.add('beez-active-tab');
});
